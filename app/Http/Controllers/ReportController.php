<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Disease;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Action;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReportController extends Controller
{
    public function index()
    {
        return view('content.report.index');
    }
    public function printTifoid()
    {
        $tifoid = Action::with('patient.villages')
            ->whereIn('diagnosa', [265, 39])
            ->orWhere(function ($query) {
                $query->whereJsonContains('diagnosa', '265')->orWhereJsonContains('diagnosa', '39');
            })
            ->get();
        $tifoid->load('patient.villages');

        return view('content.report.print-tifoid', compact('tifoid'));
    }
    public function printDiare()
    {
        return view('content.report.print-diare');
    }
    public function reportDiare()
    {
        $diare = Action::with(['patient.villages', 'hospitalReferral'])
            ->whereIn('diagnosa', [38, 77, 578, 596, 597])
            ->orWhere(function ($query) {
                $query->whereJsonContains('diagnosa', '578')->orWhereJsonContains('diagnosa', '596')->orWhereJsonContains('diagnosa', '597')->orWhereJsonContains('diagnosa', '38')->orWhereJsonContains('diagnosa', '77');
            })
            ->get();

        $diagnosaMap = [
            38 => 'Diare & gastroenteritis oleh penyebab infeksi tertentu (coalitis infeksi)',
            77 => 'Diare disentri (Diamhoea dysentarie)',
            578 => 'Diare dengan dehidrasi berat',
            596 => 'Diare Tanpa Dehidrasi',
            597 => 'Diare dengan dehidrasi ringan-sedang',
        ];

        $dehidrasiMap = [
            38 => 'Tanpa Dehidrasi',
            77 => 'Tanpa Dehidrasi',
            578 => 'Berat',
            596 => 'Tanpa Dehidrasi',
            597 => 'Ringan-Sedang',
        ];

        foreach ($diare as $data) {
            if (is_array($data->diagnosa)) {
                $data->diagnosa_names = array_map(function ($id) use ($diagnosaMap) {
                    return $diagnosaMap[$id] ?? 'Tidak Diketahui';
                }, $data->diagnosa);

                $dehidrasiList = array_map(function ($id) use ($dehidrasiMap) {
                    return $dehidrasiMap[$id] ?? 'Tidak Diketahui';
                }, $data->diagnosa);
                $data->dehidrasi = implode(', ', array_unique($dehidrasiList));
            } else {
                $data->diagnosa_names = [$diagnosaMap[$data->diagnosa] ?? 'Tidak Diketahui'];
                $data->dehidrasi = $dehidrasiMap[$data->diagnosa] ?? 'Tidak Diketahui';
            }
        }

        return view('content.report.report-diare', compact('diare'));
    }

    public function reportSTP()
    {
        return view('content.report.laporan-stp');
    }
    // public function reportPTM()
    // {
    //     return view('content.report.laporan-ptm');
    // }
    public function reportAFP()
    {
        return view('content.report.laporan-afp');
    }
    public function reportDifteri()
    {
        return view('content.report.laporan-difteri');
    }

    public function reportC1()
    {
        function calculateAge($dob)
        {
            $dob = \Carbon\Carbon::parse($dob);
            $now = \Carbon\Carbon::now();

            if ($dob->diffInYears($now) > 0) {
                return $dob->diffInYears($now); // Hitung dalam tahun
            } elseif ($dob->diffInMonths($now) > 0) {
                return $dob->diffInMonths($now); // Hitung dalam bulan
            } else {
                return $dob->diffInDays($now); // Hitung dalam hari
            }
        }

        function calculateAgeUnit($dob)
        {
            $dob = \Carbon\Carbon::parse($dob);
            $now = \Carbon\Carbon::now();

            if ($dob->diffInYears($now) > 0) {
                return 'years'; // Jika umur dalam tahun
            } elseif ($dob->diffInMonths($now) > 0) {
                return 'months'; // Jika umur dalam bulan
            } else {
                return 'days'; // Jika umur dalam hari
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:U1');
        $sheet->setCellValue('A1', 'FORMAT : C-1');
        $sheet
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);

        $sheet->mergeCells('A2:U2');
        $sheet->setCellValue('A2', 'LAPORAN KASUS CAMPAK');
        $sheet
            ->getStyle('A2')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);

        $sheet->mergeCells('A3:U3');
        $sheet->setCellValue('A3', 'Bulan/Tahun : September / 2024');
        $sheet
            ->getStyle('A3')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3')->getFont()->setSize(10);

        // Informasi puskesmas
        $sheet->setCellValue('A5', 'Puskesmas : Tamangapa');
        $sheet->setCellValue('A6', 'Kecamatan : Manggala');
        $sheet->setCellValue('A7', 'Propinsi : Sulawesi Selatan');

        // Header tabel
        $headers = [['No Epid Kasus/ KLB', 'Nama Anak', 'Nama Org Tua', 'Alamat Lengkap (Desa/RT/RW)', 'Umur/Sex', '', 'Vaksin campak sebelum sakit', '', 'Tgl Timbul', '', 'Tgl Diambil Spesimen', '', 'Hasil Spesimen', '', 'Diberi Vit. A (Y/T)', 'Keadaan Akhir (H/M)', 'Klasifikasi Final*', '', '', '', ''], ['', '', '', '', 'L', 'P', 'Brp Kali', 'Tidak/Tdk Tahu', 'Demam', 'Rash', 'Darah', 'Urin', 'Darah', 'Urin', '', '', 'Lab (+)', 'Epid', 'Klinis', 'Rubella Lab (+)', 'Bukan Camp/Rub']];
        $sheet->fromArray($headers, null, 'A9');

        $sheet->mergeCells('A9:A10');
        $sheet->mergeCells('B9:B10');
        $sheet->mergeCells('C9:C10');
        $sheet->mergeCells('D9:D10');
        $sheet->mergeCells('E9:F9');
        $sheet->mergeCells('G9:H9');
        $sheet->mergeCells('I9:J9');
        $sheet->mergeCells('K9:L9');
        $sheet->mergeCells('M9:N9');
        $sheet->mergeCells('O9:O10');
        $sheet->mergeCells('P9:P10');
        $sheet->mergeCells('Q9:U9');

        // Style header
        $sheet->getStyle('A9:U10')->getFont()->setBold(true)->setSize(10);
        $sheet
            ->getStyle('A9:U10')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet
            ->getStyle('A9:U10')
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A9:U10')->getAlignment()->setWrapText(true);
        $sheet
            ->getStyle('A9:U10')
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FFC0CB');
        // Footer Penjelasan
        $sheet->setCellValue('A16', 'Periode KLB : Tgl...........s/d..............');
        $sheet->mergeCells('A17:G17');
        $sheet->setCellValue('A17', 'Penjelasan : Kolom 16: Pemberian Vit.A saat sakit campak');
        $sheet->mergeCells('A18:G18');
        $sheet->setCellValue('A18', ': Kolom 17: H = Hidup, M = Mati');
        $sheet->mergeCells('A19:G19');
        $sheet->setCellValue('A19', ': *Klasifikasi final diisi oleh Kabupaten');

        // Footer Tanda Tangan
        $sheet->setCellValue('R16', 'Makassar, Tgl 04 Oktober 2024');
        $sheet->mergeCells('R17:U17');
        $sheet->setCellValue('R17', 'Plt.Kepala UPT Puskesmas Tamangapa');
        $sheet->mergeCells('R20:U20');
        $sheet->setCellValue('R20', 'dr.Fatimah, M.Kes');
        $sheet->mergeCells('R21:U21');
        $sheet->setCellValue('R21', 'NIP. 19851125 201101 2 009');

        // Style Footer
        $sheet->getStyle('A16:A19')->getFont()->setSize(9); // Font ukuran 9
        $sheet->getStyle('R16:R21')->getFont()->setSize(9); // Font ukuran 9
        $sheet
            ->getStyle('A16:A19')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet
            ->getStyle('R16:R21')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $actions = Action::select('*') // Pilih semua kolom
            ->where(function ($query) {
                $query
                    ->where('diagnosa', 'like', '%"97"%') // Jika `diagnosa` disimpan dalam format JSON
                    ->orWhere('diagnosa', '97'); // Jika `diagnosa` disimpan sebagai string
            })
            ->get();

        $diagnosisData = [];
        $data = []; // Inisialisasi array data untuk tabel

        foreach ($actions as $action) {
            $diagnosisIds = [];
            if (is_array($action->diagnosa)) {
                $diagnosisIds = $action->diagnosa;
            } elseif (is_string($action->diagnosa)) {
                $decoded = json_decode($action->diagnosa, true);
                if (is_array($decoded)) {
                    $diagnosisIds = $decoded;
                }
            }

            if (empty($diagnosisIds)) {
                continue;
            }

            foreach ($diagnosisIds as $diagnosisId) {
                if ($diagnosisId != 97) {
                    // Pastikan hanya mengambil data dengan diagnosa ID 97
                    continue;
                }

                $key = $diagnosisId . '-' . ($action->icd10 ?? 'Unknown');

                if (!isset($diagnosisData[$key])) {
                    $diagnosisData[$key] = [
                        'name' => Diagnosis::find($diagnosisId)?->name ?? 'Unknown',
                    ];
                }

                // Data tabel
                $data[] = ['', $action->patient->name ? ucwords(strtolower($action->patient->name)) : 'Unknown', '', $action->patient->address ?? 'Unknown', $action->patient->dob && calculateAgeUnit($action->patient->dob) == 'months' ? calculateAge($action->patient->dob) . ' bln' : null, $action->patient->dob && calculateAgeUnit($action->patient->dob) == 'years' ? calculateAge($action->patient->dob) . 'thn' : null, $action->visits ?? '0x', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
            }
        }
        $sheet->fromArray($data, null, 'A11');

        // Penyesuaian lebar kolom secara spesifik
        $columnWidths = [15, 20, 20, 30, 5, 5, 10, 15, 10, 10, 10, 10, 10, 10, 5, 10, 10, 10, 10, 10, 15];
        foreach (range('A', 'U') as $index => $columnID) {
            $sheet->getColumnDimension($columnID)->setWidth($columnWidths[$index]);
        }
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Warna hitam
                ],
            ],
        ];

        // Terapkan border ke seluruh tabel, dari header hingga data terakhir
        $sheet->getStyle('A9:U13')->applyFromArray($styleArray);

        // Pengaturan kertas dan skala untuk A4
        $sheet
            ->getPageSetup()
            ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(PageSetup::PAPERSIZE_A4)
            ->setFitToWidth(1) // Skala agar tabel muat di lebar halaman
            ->setFitToHeight(0);

        // Menyimpan file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan_Kasus_Campak.xlsx';
        $filePath = storage_path('app/public/' . $fileName);

        $writer->save($filePath);
        //

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
    public function reportPTM()
    {
        function calculateAgePTM($dob)
        {
            $dob = \Carbon\Carbon::parse($dob);
            $now = \Carbon\Carbon::now();

            if ($dob->diffInYears($now) > 0) {
                return $dob->diffInYears($now); // Hitung dalam tahun
            } elseif ($dob->diffInMonths($now) > 0) {
                return $dob->diffInMonths($now); // Hitung dalam bulan
            } else {
                return $dob->diffInDays($now); // Hitung dalam hari
            }
        }

        function calculateAgeUnitPTM($dob)
        {
            $dob = \Carbon\Carbon::parse($dob);
            $now = \Carbon\Carbon::now();

            if ($dob->diffInYears($now) > 0) {
                return 'years'; // Jika umur dalam tahun
            } elseif ($dob->diffInMonths($now) > 0) {
                return 'months'; // Jika umur dalam bulan
            } else {
                return 'days'; // Jika umur dalam hari
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:U1');
        $sheet->setCellValue('A1', 'JUMLAH KASUS DAN KEMATIAN PENYAKIT TIDAK MENULAR MENURUT JENIS KELAMIN DAN UMUR');
        $sheet
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);

        // $sheet->mergeCells('A2:U2');
        // $sheet->setCellValue('A2', 'LAPORAN KASUS CAMPAK');
        // $sheet
        //     ->getStyle('A2')
        //     ->getAlignment()
        //     ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);

        // $sheet->mergeCells('A3:U3');
        // $sheet->setCellValue('A3', 'Bulan/Tahun : September / 2024');
        // $sheet
        //     ->getStyle('A3')
        //     ->getAlignment()
        //     ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('A3')->getFont()->setSize(10);

        // Informasi puskesmas
        $sheet->setCellValue('A2', 'PDinas Kesehatan Kota Makassar');
        $sheet->setCellValue('A3', 'Bulan/Tahun : MARET/2024');
        $sheet->setCellValue('A4', 'Jumlah kasus baru (Kunjungan pertama dan belum tercatat di RS/Fasilitas Kesehatan Lainnya)');

        $headers = [['JUMLAH KASUS DAN KEMATIAN PENYAKIT TIDAK MENULAR MENURUT JENIS KELAMIN DAN UMUR'], ['Dinas Kesehatan Kota Makassar'], ['Bulan/Tahun : MARET/2024'], ['Jumlah kasus baru (Kunjungan pertama dan belum tercatat di RS/Fasilitas Kesehatan Lainnya)'], ['NO', 'PENYAKIT TIDAK MENULAR', 'Jenis Kelamin dan Umur (Th)', '', '', '', '', '', '', '', 'Jenis Kelamin dan Umur (Th)', '', '', '', '', '', '', '', 'Total'], ['', '', 'Laki-Laki (L)', '', '', '', '', '', '', '', 'Perempuan (P)', '', '', '', '', '', '', '', ''], ['', '', '18-24', '25-34', '35-44', '45-54', '55-64', '65-74', '≥ 75', 'Jumlah', '18-24', '25-34', '35-44', '45-54', '55-64', '65-74', '≥ 75', 'Jumlah', '']];

        // Data penyakit berdasarkan gambar
        // $data = [
        //     ['1', 'Hipertensi', 1, 4, 3, 5, 6, 7, 21, 47, 13, 23, 25, 31, 27, 17, 113, 182],
        //     ['2', 'Diabetes Melitus', 0, 1, 0, 2, 3, 4, 7, 17, 2, 5, 10, 11, 9, 5, 33, 50],
        //     ['3', 'Obesitas', 9, 6, 5, 4, 3, 2, 16, 45, 19, 16, 21, 26, 25, 25, 102, 189],
        //     ['4', 'Struma', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        //     ['5', 'Thyrotoksikosis', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        //     ['6', 'Stroke', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        //     ['7', 'Asma', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        //     ['8', 'PPOK', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        //     ['9', 'Osteoporosis', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        //     ['10', 'Penyakit Ginjal Kronik', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        //     ['11', 'Kecelakaan Lalu Lintas Jalan', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        //     ['12', 'Tumor Payudara', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        //     ['13', 'Tumor pada Retina Mata', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        //     ['14', 'Tumor pada Bibir, Rongga Mulut', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        //     ['15', 'Tumor Genitalia Eksterna Pria', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        //     ['16', 'Tumor Genitalia Eksterna Perempuan', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        //     ['17', 'Serviks', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        //     ['18', ' Tumor Genitalia Interna Perempuan (Kecuali Serviks)', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        //     ['', ' Jumlah', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
        // ];
        
        // Memasukkan header
        foreach ($headers as $rowIndex => $headerRow) {
            $sheet->fromArray($headerRow, null, 'A' . (1 + $rowIndex));
        }

        // Memasukkan data penyakit
        $startRow = count($headers) + 1;
        // $sheet->fromArray($data, null, 'A' . $startRow);
        
        
        // Merge kolom header
        $sheet->mergeCells('A5:A7'); // NO
        $sheet->mergeCells('B5:B7'); // PENYAKIT TIDAK MENULAR
        $sheet->mergeCells('C5:J5'); // Jenis Kelamin dan Umur (Laki-Laki)
        $sheet->mergeCells('K5:R5'); // Jenis Kelamin dan Umur (Perempuan)
        $sheet->mergeCells('S5:S7'); // Total
        $sheet->mergeCells('C6:J6'); // Sub-header Laki-Laki
        $sheet->mergeCells('K6:R6'); // Sub-header Perempuan

        // Style header
        $sheet->getStyle('A1:S7')->getFont()->setBold(true);
        $sheet
            ->getStyle('A1:S7')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet
            ->getStyle('A5:S7')
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('90EE90'); // Hijau muda
        // Footer Penjelasan
        $sheet->setCellValue('B30', 'Mengetahui :');
        $sheet->mergeCells('B31:G31');
        $sheet->setCellValue('B31', 'Kepala Puskesmas Tamangapa Makassar,');
        $sheet->mergeCells('B34:G34');
        $sheet->setCellValue('B34', 'dr. Hj. Sri Zakiah Usman');
        $sheet->mergeCells('B35:G35');
        $sheet->setCellValue('B35', 'NIP: 19700521 20021 2 006');

        // Footer Tanda Tangan
        $sheet->setCellValue('R30', 'Makassar, Tgl 04 Oktober 2024');
        $sheet->mergeCells('R31:U31');
        $sheet->setCellValue('R31', 'Plt.Kepala UPT Puskesmas Tamangapa');
        $sheet->mergeCells('R34:U34');
        $sheet->setCellValue('R34', 'dr.Fatimah, M.Kes');
        $sheet->mergeCells('R35:U35');
        $sheet->setCellValue('R35', 'NIP. 19851125 201101 2 009');

        // Style Footer
        $sheet->getStyle('A30:A33')->getFont()->setSize(9); // Font ukuran 9
        $sheet->getStyle('R30:R35')->getFont()->setSize(9); // Font ukuran 9
        $sheet
            ->getStyle('A30:A33')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet
            ->getStyle('R30:R35')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $dataPenyakit = [
                'Hipertensi' => ['134', '186', '291'],
                'Diabetes Melitus' => ['362', '363', '364'],
                'Obesitas' => ['264', '269'],
                'Struma' => [],
                'Thyrotoksikosis' => [],
                'Stroke' => [],
                'Asma' => [],
                'PPOK' => [],
                'Osteoporosis' => [],
                'Penyakit Ginjal Kronik' => [],
                'Kecelakaan Lalu Lintas Jalan' => [],
                'Tumor Payudara' => [],
                'Tumor pada Retina Mata' => [],
                'Tumor pada Bibir, Rongga Mulut' => [],
                'Tumor Genitalia Eksterna Pria' => [],
                'Tumor Genitalia Eksterna Perempuan' => [],
                'Serviks' => [],
                'Tumor Genitalia Interna Perempuan (Kecuali Serviks)' => []
            ];
            
            $ageGroups = [
                '18-24' => [18, 24],
                '25-34' => [25, 34],
                '35-44' => [35, 44],
                '45-54' => [45, 54],
                '55-64' => [55, 64],
                '65-74' => [65, 74],
                '>=75'  => [75, PHP_INT_MAX],
                'Unknown' => [0, 17] // Ensure the Unknown group is defined
            ];
            
            $result = []; // For storing results
            $actions = Action::with('patient.villages');
            
            // Fetch actions where 'diagnosa' contains IDs from $dataPenyakit
            foreach ($dataPenyakit as $penyakit => $diagnosisIds) {
                // Skip empty diagnosis categories (though still need to include them in the result)
                foreach ($diagnosisIds as $diagnosisId) {
                    $actions->orWhereJsonContains('diagnosa', $diagnosisId);
                }
            }
            
            // Get the results
            $actions = $actions->get();
            
            // Process each action
            foreach ($actions as $action) {
                // Skip if the patient is 17 years old or younger
                $age = calculateAgePTM($action->patient->dob);
                // dd($age);
                if ($age <= 17) {
                    continue; // Skip processing if the patient is 17 or younger
                }
            
                // Loop through diagnosis categories in $dataPenyakit
                foreach ($dataPenyakit as $penyakit => $diagnosisIds) {
                    foreach ($diagnosisIds as $diagnosisId) {
                        // Check if this diagnosisId is part of the action's diagnosa
                        if (!in_array($diagnosisId, $action->diagnosa)) {
                            continue;
                        }
            
                        // Use the disease name from the key (penyakit)
                        $diagnosisName = $penyakit; // This will be the disease name from the array key
            
                        // Determine gender
                        $gender = strtolower($action->patient->genderName->name) === 'male' ? 'L' : 'P';
            
                        // Calculate age and determine the age group
                        $ageGroup = 'Unknown'; // Default age group is 'Unknown'
            
                        // Ensure proper array access (key => [min, max])
                        foreach ($ageGroups as $group => $range) {
                            // $range should be an array like [min, max]
                            $min = $range[0];
                            $max = $range[1];
            
                            if ($age >= $min && $age <= $max) {
                                $ageGroup = $group;
                                break;
                            }
                        }
            
                        // Initialize the result array if it doesn't exist yet
                        if (!isset($result[$diagnosisName])) {
                            $result[$diagnosisName] = [
                                'L' => array_fill_keys(array_keys($ageGroups), 0),
                                'P' => array_fill_keys(array_keys($ageGroups), 0),
                            ];
                        }
            
                        // Increment the count for gender and age group
                        $result[$diagnosisName][$gender][$ageGroup]++;
                    }
                }
            }
            
            // Ensure all diseases (even those with no data) are represented in the final result
            foreach ($dataPenyakit as $penyakit => $diagnosisIds) {
                // If the disease is not in the result, initialize it with zeros
                if (!isset($result[$penyakit])) {
                    $result[$penyakit] = [
                        'L' => array_fill_keys(array_keys($ageGroups), 0),
                        'P' => array_fill_keys(array_keys($ageGroups), 0),
                    ];
                }
            }
            
            // Prepare the data for the table
            $data = [];
            $no = 1;
            
            foreach ($result as $diagnosis => $genderData) {
                $row = [
                    'no' => $no++,
                    'diagnosis' => $diagnosis,
                    'L_total' => 0,
                    'P_total' => 0,
                    'Total' => 0,
                ];
            
                // Populate the age group counts for both genders
                foreach (array_keys($ageGroups) as $group) {
                    $row["L_$group"] = $genderData['L'][$group] ?? 0;
                    $row["P_$group"] = $genderData['P'][$group] ?? 0;
            
                    // Accumulate totals for each gender and the overall total
                    $row['L_total'] += $row["L_$group"];
                    $row['P_total'] += $row["P_$group"];
                }
            
                // Calculate the overall total
                $row['Total'] = $row['L_total'] + $row['P_total'];
            
                // Add the row to the data array
                $data[] = $row;
            }
            
            // Write to the sheet (make sure the sheet instance is available)
            $sheet->fromArray($data, null, 'A8');
            
            
            
                    // Penyesuaian lebar kolom secara spesifik
        $columnWidths = [5, 50, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 15];
        foreach (range('A', 'S') as $index => $columnID) {
            $sheet->getColumnDimension($columnID)->setWidth($columnWidths[$index]);
        }
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Warna hitam
                ],
            ],
        ];

        // Terapkan border ke seluruh tabel, dari header hingga data terakhir
        $sheet->getStyle('A5:S26')->applyFromArray($styleArray);

        // Pengaturan kertas dan skala untuk A4
        $sheet
            ->getPageSetup()
            ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(PageSetup::PAPERSIZE_A4)
            ->setFitToWidth(1) // Skala agar tabel muat di lebar halaman
            ->setFitToHeight(0);

        // Menyimpan file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan_PTM.xlsx';
        $filePath = storage_path('app/public/' . $fileName);

        $writer->save($filePath);
        //

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function reportRJP()
    {
        return view('content.report.laporan-rjp');
    }
    public function reportSKDR()
    {
        return view('content.report.laporan-skdr');
    }
    public function reportLKG()
    {
        return view('content.report.laporan-lkg');
    }
    public function reportLRKG()
    {
        return view('content.report.laporan-lrkg');
    }
    public function reportLKT()
    {
        return view('content.report.laporan-lkt');
    }
    public function reportLBKT()
    {
        return view('content.report.laporan-lbkt');
    }
    public function reportURT()
    {
        $services = ['Hecting (Jahit Luka)', 'Ganti Verban', 'Insici Abses', 'Sircumsisi (Bedah Ringan)', 'Ekstraksi Kuku', 'Observasi dengan tindakan Invasif', 'Observasi tanpa tindakan Invasif'];

        $data = [];

        foreach ($services as $service) {
            $data[$service] = [
                'akses' => Action::where('tindakan', $service)->where('kartu', 'akses')->count(),
                'bpjs_mandiri' => Action::where('tindakan', $service)->where('kartu', 'bpjs_mandiri')->count(),
                'bpjs_kis' => Action::where('tindakan', $service)->where('kartu', 'bpjs')->count(),
                'gratis' => Action::where('tindakan', $service)->where('kartu', 'gratis_jkd')->count(),
                'umum' => Action::where('tindakan', $service)->where('kartu', 'umum')->count(),
            ];
        }
        return view('content.report.laporan-urt', compact('data'));
    }
    public function reportLKRJ()
    {
        return view('content.report.laporan-lkrj');
    }
    public function reportRRT()
    {
        $rujukan = Action::select('rujuk_rs', DB::raw('COUNT(*) as count'))->where('rujuk_rs', '!=', '1')->groupBy('rujuk_rs')->orderBy('count', 'desc')->take(10)->get();
        $actions = Action::select('diagnosa', 'icd10')->get();

        $diagnosisData = [];

        foreach ($actions as $action) {
            $diagnosisIds = [];
            if (is_array($action->diagnosa)) {
                $diagnosisIds = $action->diagnosa;
            } elseif (is_string($action->diagnosa)) {
                $decoded = json_decode($action->diagnosa, true);
                if (is_array($decoded)) {
                    $diagnosisIds = $decoded;
                }
            }

            if (empty($diagnosisIds)) {
                continue;
            }

            foreach ($diagnosisIds as $diagnosisId) {
                $key = $diagnosisId . '-' . ($action->icd10 ?? 'Unknown');

                if (!isset($diagnosisData[$key])) {
                    $diagnosisData[$key] = [
                        'name' => Diagnosis::find($diagnosisId)?->name ?? 'Unknown',
                        'icd10' => $action->icd10,
                        'count' => 0,
                    ];
                }

                $diagnosisData[$key]['count']++;
            }
        }

        usort($diagnosisData, fn($a, $b) => $b['count'] - $a['count']);

        $topDiagnoses = array_slice($diagnosisData, 0, 10);

        return view('content.report.laporan-rrt', compact('rujukan', 'diagnosisData'));
    }
    public function reportLL()
    {
        return view('content.report.laporan-ll');
    }
    public function reportFormulir10()
    {
        return view('content.report.laporan-formulir10');
    }

    public function reportFormulir11()
    {
        return view('content.report.laporan-formulir11');
    }
    public function reportFormulir12()
    {
        return view('content.report.laporan-formulir12');
    }
    public function reportLR()
    {
        return view('content.report.laporan-lr');
    }
    public function reportUP()
    {
        $patients = Action::whereHas('patient', function ($query) {
            $query->whereBetween(DB::raw('TIMESTAMPDIFF(YEAR, dob, CURDATE())'), [15, 59]);
        })->get();

        return view('content.report.laporan-up', compact('patients'));
    }
}
