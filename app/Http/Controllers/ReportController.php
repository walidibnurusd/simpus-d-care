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
        return view('content.report.report-diare');
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
            'Tumor Genitalia Interna Perempuan (Kecuali Serviks)' => [],
       
        ];

        $ageGroups = [
            '18-24' => [18, 24],
            '25-34' => [25, 34],
            '35-44' => [35, 44],
            '45-54' => [45, 54],
            '55-64' => [55, 64],
            '65-74' => [65, 74],
            '>=75' => [75, PHP_INT_MAX],
            'Unknown' => [0, 17], // Pastikan grup "Unknown" ada
        ];

        // Inisialisasi hasil
        $result = array_fill_keys(array_keys($dataPenyakit), [
            'L' => array_fill_keys(array_keys($ageGroups), 0),
            'P' => array_fill_keys(array_keys($ageGroups), 0),
        ]);

        // Gabungkan semua diagnosis ID untuk query
        $allDiagnosisIds = array_merge(...array_values($dataPenyakit));

        // Ambil data tindakan
        $actions = Action::with('patient.villages')
            ->where(function ($query) use ($allDiagnosisIds) {
                foreach ($allDiagnosisIds as $diagnosisId) {
                    $query->orWhereJsonContains('diagnosa', $diagnosisId);
                }
            })
            ->get();

        // Proses setiap data tindakan
        $processedPatients = []; // Simpan pasien yang sudah diproses

        foreach ($actions as $action) {
            $age = calculateAgePTM($action->patient->dob);
            if ($age <= 17) {
                continue;
            }
        
            $gender = $action->patient->gender ==2  ? 'L' : 'P';
        
            foreach ($dataPenyakit as $penyakit => $diagnosisIds) {
                if (!array_intersect($diagnosisIds, $action->diagnosa)) {
                    continue;
                }
        
                // Pastikan pasien belum diproses untuk penyakit ini
                if (isset($processedPatients[$action->patient->id][$penyakit])) {
                    continue;
                }
                $processedPatients[$action->patient->id][$penyakit] = true;
        
                $ageGroup = 'Unknown';
                foreach ($ageGroups as $group => $range) {
                    if ($age >= $range[0] && $age <= $range[1]) {
                        Log::info("Age $age masuk ke grup: $group");
                        $ageGroup = $group;
                        break;
                    }
                }
        
                $result[$penyakit][$gender][$ageGroup]++;
            }
        }
        
        // Siapkan data untuk tabel
$data = [];
$no = 1;

// Inisialisasi total untuk setiap kolom
$totalRow = [
    'no' => '', // Kolom ini kosong untuk baris total
    'diagnosis' => 'Jumlah', // Nama diagnosis untuk total
];

// Inisialisasi total untuk setiap kolom kelompok usia dan total gender
foreach (array_keys($ageGroups) as $group) {
    if ($group !== 'Unknown') {
        $totalRow["L_$group"] = 0;
        $totalRow["P_$group"] = 0;
    }
}
$totalRow["L_>=75"] = 0;
$totalRow['L_total'] = 0;
$totalRow['P_total'] = 0;
$totalRow['Total'] = 0;
foreach ($result as $diagnosis => $genderData) {
    // Initialize the row with the diagnosis and the counter
    $row = [
        'no' => $no++, // Assuming $no is a counter for each row
        'diagnosis' => $diagnosis,
    ];

    // Add the L values for each age group first
    foreach (array_keys($ageGroups) as $group) {
        // Add the L value for the group (do not include L_Unknown)
        if ($group !== 'Unknown') {
            $row["L_$group"] = isset($genderData['L'][$group]) ? $genderData['L'][$group] : 0;
            $totalRow["L_$group"] += $row["L_$group"]; // Tambahkan ke total
        }
    }

    // Add L_>=75 before L_total
    $row["L_>=75"] = isset($genderData['L']['>=75']) ? $genderData['L']['>=75'] : 0;
    $totalRow["L_>=75"] += $row["L_>=75"]; // Tambahkan ke total

    // Now add the L_total (after L_>=75)
    $row['L_total'] = 0; // Initialize L_total
    foreach (array_keys($ageGroups) as $group) {
        if ($group !== 'Unknown') {
            $row['L_total'] += isset($row["L_$group"]) ? $row["L_$group"] : 0;
        }
    }
    $totalRow['L_total'] += $row['L_total']; // Tambahkan ke total

    // Add the P values for each age group after the L values
    foreach (array_keys($ageGroups) as $group) {
        // Add the P value for the group (do not include P_Unknown)
        if ($group !== 'Unknown') {
            $row["P_$group"] = isset($genderData['P'][$group]) ? $genderData['P'][$group] : 0;
            $totalRow["P_$group"] += $row["P_$group"]; // Tambahkan ke total
        }
    }

    // Initialize P_total before accumulation
    $row['P_total'] = 0; // Initialize P_total
    foreach (array_keys($ageGroups) as $group) {
        if ($group !== 'Unknown') {
            $row['P_total'] += isset($row["P_$group"]) ? $row["P_$group"] : 0;
        }
    }
    $totalRow['P_total'] += $row['P_total']; // Tambahkan ke total

    // Calculate the overall total
    $row['Total'] = $row['L_total'] + $row['P_total'];
    $totalRow['Total'] += $row['Total']; // Tambahkan ke total keseluruhan

    // Add this row to the data array
    $data[] = $row; // The row is correctly added to the data array here
}

// Susun ulang urutan totalRow agar sama dengan urutan baris di atas
$totalRowOrdered = [
    'no' => 'Total', // 'no' diisi dengan label "Total"
    'diagnosis' => '', // Kosongkan diagnosis untuk total
];

// Tambahkan total untuk setiap kolom L
foreach (array_keys($ageGroups) as $group) {
    if ($group !== 'Unknown') {
        $totalRowOrdered["L_$group"] = $totalRow["L_$group"];
    }
}

// Tambahkan total untuk L_>=75
$totalRowOrdered["L_>=75"] = $totalRow["L_>=75"];

// Tambahkan total untuk L_total
$totalRowOrdered['L_total'] = $totalRow['L_total'];

// Tambahkan total untuk setiap kolom P
foreach (array_keys($ageGroups) as $group) {
    if ($group !== 'Unknown') {
        $totalRowOrdered["P_$group"] = $totalRow["P_$group"];
    }
}

// Tambahkan total untuk P_total
$totalRowOrdered['P_total'] = $totalRow['P_total'];

// Tambahkan total keseluruhan
$totalRowOrdered['Total'] = $totalRow['Total'];
$totalRowOrdered['no'] = ''; 
$totalRowOrdered['diagnosis'] = 'Jumlah'; 
// Tambahkan baris total ke akhir data
$data[] = $totalRowOrdered;


// return $data;

        // Tulis data ke sheet (mulai dari cell A8)
        Log::info('Populating sheet with data starting at A8.', ['data' => $data]);
        $sheet->fromArray($data, null, 'A8');
        // Penyesuaian lebar kolom secara spesifik
        $columnWidths = [5, 50, 10,10,10,10,10,10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 15];
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
