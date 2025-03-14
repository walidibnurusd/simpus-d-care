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
    public function index(Request $request)
    {
        $routeName = $request->route()->getName();
        return view('content.report.index', compact('routeName'));
    }
    public function printTifoid(Request $request)
    {
        // Get the selected month and year from the request
        $month = $request->input('bulan');
        $year = $request->input('tahun');
    
        // Build the query
        $query = Action::with('patient.villages')
            ->whereIn('diagnosa', [265, 39])
            ->orWhere(function ($query) {
                $query->whereJsonContains('diagnosa', '265')->orWhereJsonContains('diagnosa', '39');
            });
    
        // Add filters for month and year if provided
        if ($month && $year) {
            $query->whereYear('created_at', $year)
                  ->whereMonth('created_at', $month);
        }
    
        // Execute the query
        $tifoid = $query->get();
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

    public function reportSTP(Request $request)
    {
        // Ambil bulan dan tahun dari parameter request (dengan default bulan dan tahun saat ini)
        $month = $request->input('month', Carbon::now()->month);  // default ke bulan saat ini
        $year = $request->input('year', Carbon::now()->year);    // default ke tahun saat ini
    
        $diagnosaNames = [
            37 => 'Kolera',
            38 => 'Diare',
            578 => 'Diare',
            596 => 'Diare',
            597 => 'Diare',
            77 => 'Diare Berdarah',
            256 => 'Tifus Perut Klinis',
            39 => 'Tifus Perut Klinis',
            396 => 'TBC Paru BTA (+)',
            'unknown_1' => 'Tersangka TBC Paru',
            'unknown_2' => 'Kusta PB',
            'unknown_3' => 'Kusta MB',
            97 => 'Campak',
            89 => 'Difteria',
            90 => 'Batuk Rejan',
            91 => 'Tetanus',
            92 => 'Tetanus',
            204 => 'Tetanus',
            581 => 'Hepatitis Klinis',
            105 => 'Malaria Klinis',
            329 => 'Malaria Vivax',
            331 => 'Malaria Falciparum',
            'unknown_4' => 'Malaria Mix',
            101 => 'Demam Berdarah Dengue',
            390 => 'Demam Dengue',
            25 => 'Pneumonia',
            26 => 'Pneumonia',
            572 => 'Gonorhoe',
            109 => 'Frambusia',
            110 => 'Filariasis',
            142 => 'Influensa',
        ];
    
        // Ambil data dengan diagnosa yang valid berdasarkan diagnosaNames dan filter berdasarkan bulan dan tahun
        $stp = Action::with(['patient'])
            ->whereIn('diagnosa', array_keys($diagnosaNames))
            ->whereYear('created_at', $year)  // Filter berdasarkan tahun
            ->whereMonth('created_at', $month)  // Filter berdasarkan bulan
            ->orWhere(function ($query) use ($diagnosaNames, $year, $month) {
                foreach (array_keys($diagnosaNames) as $id) {
                    $query->orWhereJsonContains('diagnosa', (string) $id);
                }
            })
            ->get()
            ->map(function ($action) {
                if (!empty($action->patient) && !empty($action->patient->dob)) {
                    $dob = Carbon::parse($action->patient->dob);
                    $now = Carbon::now();
                    $action->ageInDays = $dob->diffInDays($now);
                    $action->age = $dob->age;
                    $action->gender = $action->patient->gender ?? 'unknown';
                } else {
                    $action->ageInDays = 0;
                    $action->age = 0;
                    $action->gender = 'unknown';
                }
                return $action;
            });
    
        // Kelompokkan data berdasarkan rentang usia
        $groupedData = $stp->groupBy(function ($action) {
            $ageInDays = $action->ageInDays;
            $age = $action->age;
    
            if ($ageInDays <= 7) {
                return '0-7 hr';
            } elseif ($ageInDays <= 28) {
                return '8-28 hr';
            } elseif ($age < 1) {
                return '0-1 tahun';
            } elseif ($age <= 4) {
                return '1-4 tahun';
            } elseif ($age <= 9) {
                return '5-9 tahun';
            } elseif ($age <= 14) {
                return '10-14 tahun';
            } elseif ($age <= 19) {
                return '15-19 tahun';
            } elseif ($age <= 44) {
                return '20-44 tahun';
            } elseif ($age <= 54) {
                return '45-54 tahun';
            } elseif ($age <= 59) {
                return '55-59 tahun';
            } elseif ($age <= 69) {
                return '60-69 tahun';
            } else {
                return '70+ tahun';
            }
        });
    
        // Siapkan laporan awal dengan semua nilai nol
        $ageGroups = ['0-7 hr', '8-28 hr', '0-1 tahun', '1-4 tahun', '5-9 tahun', '10-14 tahun', '15-19 tahun', '20-44 tahun', '45-54 tahun', '55-59 tahun', '60-69 tahun', '70+ tahun'];
        $report = [];
        foreach ($diagnosaNames as $diagnosaName) {
            foreach ($ageGroups as $ageGroup) {
                $report[$diagnosaName][$ageGroup] = [
                    'total' => 0,
                    'male' => 0,
                    'female' => 0,
                ];
            }
        }
    
        // Isi laporan berdasarkan data yang dikelompokkan
        foreach ($groupedData as $ageGroup => $actions) {
            foreach ($actions->groupBy('diagnosa') as $diagnosaId => $cases) {
                if (!isset($diagnosaNames[$diagnosaId])) {
                    \Log::warning("Unknown diagnosa ID: {$diagnosaId}");
                    continue;
                }
                $diagnosaName = $diagnosaNames[$diagnosaId];
                $maleCount = $cases
                    ->filter(function ($case) {
                        return $case->patient->gender === 1;
                    })
                    ->count();
    
                $femaleCount = $cases
                    ->filter(function ($case) {
                        return $case->patient->gender === 2;
                    })
                    ->count();
    
                $report[$diagnosaName][$ageGroup]['total'] += $cases->count();
                $report[$diagnosaName][$ageGroup]['male'] += $maleCount;
                $report[$diagnosaName][$ageGroup]['female'] += $femaleCount;
            }
        }
    
        // Kirim data ke tampilan dengan parameter bulan dan tahun untuk digunakan di filter
        return view('content.report.laporan-stp', compact('report', 'ageGroups', 'month', 'year'));
    }
    

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

            $gender = $action->patient->gender == 2 ? 'L' : 'P';

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
        $totalRow['L_>=75'] = 0;
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
            $row['L_>=75'] = isset($genderData['L']['>=75']) ? $genderData['L']['>=75'] : 0;
            $totalRow['L_>=75'] += $row['L_>=75']; // Tambahkan ke total

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
        $totalRowOrdered['L_>=75'] = $totalRow['L_>=75'];

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
        $columnWidths = [5, 50, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 15];
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

     public function reportRJP(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
    
        // Konversi bulan ke format nama bulan
        $namaBulan = Carbon::createFromFormat('m', $bulan)->translatedFormat('F');
    
        // Daftar tindakan yang ingin dihitung (tanpa "Tidak Ada")
        $tindakan = [
            "Observasi Tanpa Tindakan Invasif",
            "Observasi Dengan Tindakan Invasif",
            "Corpus Alineum",
            "Ekstraksi Kuku",
            "Sircumsisi (Bedah Ringan)",
            "Incisi Abses",
            "Rawat Luka",
            "Ganti Verban",
            "Spooling",
            "Toilet Telinga",
            "Tetes Telinga",
            "Aff Hecting",
            "Hecting (Jahit Luka)",
            "Tampon/Off Tampon"
        ];
    
        // Ambil data dari database
        $data = Action::whereIn('tindakan_ruang_tindakan', $tindakan)
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->selectRaw('tindakan_ruang_tindakan, COUNT(*) as jumlah')
            ->groupBy('tindakan_ruang_tindakan')
            ->get()
            ->keyBy('tindakan_ruang_tindakan'); // Index array dengan nama tindakan
    
        // Gabungkan dengan nilai default 0 jika tidak ditemukan
        $result = collect($tindakan)->map(function ($t) use ($data) {
            return [
                'tindakan_ruang_tindakan' => $t,
                'jumlah' => $data->has($t) ? $data[$t]->jumlah : 0
            ];
        });
    
        return view('content.report.laporan-rjp', compact('result', 'namaBulan', 'tahun'));
    }
    public function reportSKDR()
    {
        return view('content.report.laporan-skdr');
    }
    public function reportLKG(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
    
        // Validasi input bulan dan tahun
        if (!$bulan || !$tahun) {
            return response()->json(['error' => 'Bulan dan tahun diperlukan'], 400);
        }
    
        // Daftar diagnosis
        $diagnosisList = [
            "K00.6" => "Persistensi Gigi Sulung",
            "K01.1" => "Impaksi M3 Klasifikasi IA",
            "K02" => "Karies Gigi",
            "K03" => "Penyakit jaringan keras gigi lainnya",
            "K04" => "Penyakit pulpa dan jaringan periapikal",
            "K05" => "Gingivitis dan penyakit periodontal",
            "K07" => "Anomali Dentofasial / termasuk maloklusi Kelainan",
            "K08" => "Gangguan gigi dan jaringan penyangga lainnya",
            "K12" => "Stomatitis dan Lesi-lesi yang berhubungan",
            "K13.0" => "Angular Cheilitis / penyakit bibir dan mukosa",
            "L51" => "Eritema Multiformis",
            "R51" => "Nyeri Orofasial",
            "S02.6" => "Fraktur mahkota yang tidak merusak pulpa",
            "K07.3" => "Crowded",
            "K14.3" => "Hipertrofi of Tongue Papiloma",
            "D21.9" => "Tumor di langit-langit",
            "M27.0" => "Torus palatinal"
        ];
    
        // Ambil ID diagnosis berdasarkan kode ICD10
        $diagnosis = Diagnosis::whereIn('icd10', array_keys($diagnosisList))
            ->pluck('id', 'icd10')
            ->map(fn($id) => (string) $id)
            ->toArray();
    
        // Jika diagnosis kosong, langsung return hasil kosong
        if (empty($diagnosis)) {
            return response()->json([]);
        }
    
        // Ambil data tindakan berdasarkan ID diagnosis dan filter bulan & tahun
        $actions = Action::where('tipe', 'poli-gigi')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where(function ($query) use ($diagnosis) {
                foreach ($diagnosis as $id) {
                    $query->orWhereJsonContains('diagnosa', $id);
                }
            })
            ->get();
    
        // Inisialisasi array data diagnosis
        $diagnosisData = [];
        $totalLaki = 0;
        $totalPerempuan = 0;
    
        foreach ($diagnosisList as $code => $name) {
            $diagnosisId = $diagnosis[$code] ?? null;
    
            if (!$diagnosisId) {
                continue;
            }
    
            $filteredActions = $actions->filter(function ($action) use ($diagnosisId) {
                $diagnosa = is_string($action->diagnosa) ? json_decode($action->diagnosa, true) : $action->diagnosa;
                return in_array($diagnosisId, (array) $diagnosa);
            });
    
            // Hitung jumlah laki-laki dan perempuan
            $lakiLakiCount = $filteredActions->where('patient.gender', 2)->count();
            $perempuanCount = $filteredActions->where('patient.gender', 1)->count();
    
            $diagnosisData[$code] = [
                'code' => $code,
                'name' => $name,
                'laki_laki' => $lakiLakiCount,
                'perempuan' => $perempuanCount,
                'total' => $lakiLakiCount + $perempuanCount
            ];
    
            // Hitung total keseluruhan
            $totalLaki += $lakiLakiCount;
            $totalPerempuan += $perempuanCount;
        }
    
        // Tindakan gigi
        $tindakanGigi = [
            "Gigi Sulung Tumpatan Sementara",
            "Gigi Tetap Tumpatan Sementara",
            "Gigi Tetap Tumpatan Tetap",
            "Gigi Sulung Tumpatan Tetap",
            "Perawatan Saluran Akar",
            "Gigi Sulung Pencabutan",
            "Gigi Tetap Pencabutan",
            "Pembersihan Karang Gigi",
            "Odontectomy",
            "Sebagian Prothesa",
            "Penuh Prothesa",
            "Reparasi Prothesa",
            "Premedikasi/Pengobatan",
            "Tindakan Lain",
            "Incisi Abses Gigi"
        ];
    
        $tindakan = Action::where('tipe', 'poli-gigi')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->whereIn('tindakan', $tindakanGigi)
            ->get();
            $rujukanL = Action::join('patients', 'actions.id_patient', '=', 'patients.id')
            ->where('actions.tipe', 'poli-gigi')
            ->whereMonth('actions.tanggal', $bulan)
            ->whereYear('actions.tanggal', $tahun)
            ->where('patients.gender', 2) // Laki-laki
            ->where('actions.rujuk_rs', '!=', 1)
            ->count();
        
        $rujukanP = Action::join('patients', 'actions.id_patient', '=', 'patients.id')
            ->where('actions.tipe', 'poli-gigi')
            ->whereMonth('actions.tanggal', $bulan)
            ->whereYear('actions.tanggal', $tahun)
            ->where('patients.gender', 1) // Perempuan
            ->where('actions.rujuk_rs', '!=', 1)
            ->count();
        
    
        // Mengirim data ke satu view
        return view('content.report.laporan-lkg', compact('bulan', 'tahun', 'diagnosisData', 'totalLaki', 'totalPerempuan', 'tindakanGigi', 'tindakan','rujukanL','rujukanP'));
    }
   public function reportLRKG(Request $request)
    {
        // Ambil input bulan dan tahun
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
    
        // Validasi input bulan dan tahun
        if (!$bulan || !$tahun) {
            return response()->json(['error' => 'Bulan dan tahun diperlukan'], 400);
        }
    
        // Daftar diagnosis ICD-10
        $diagnosisList = [
            "K00.6" => "Persistensi Gigi Sulung",
            "K01.1" => "Impaksi M3 Klasifikasi IA",
            "K02" => "Karies Gigi",
            "K03" => "Penyakit jaringan keras gigi lainnya",
            "K04" => "Penyakit pulpa dan jaringan periapikal",
            "K05" => "Gingivitis dan penyakit periodontal",
            "K07" => "Anomali Dentofasial / termasuk maloklusi Kelainan",
            "K08" => "Gangguan gigi dan jaringan penyangga lainnya",
            "K12" => "Stomatitis dan Lesi-lesi yang berhubungan",
            "K13.0" => "Angular Cheilitis / penyakit bibir dan mukosa",
            "L51" => "Eritema Multiformis",
            "R51" => "Nyeri Orofasial",
            "S02.6" => "Fraktur mahkota yang tidak merusak pulpa",
            "K07.3" => "Crowded",
            "K14.3" => "Hipertrofi of Tongue Papiloma",
            "D21.9" => "Tumor di langit-langit",
            "M27.0" => "Torus palatinal"
        ];
    
        // Ambil ID diagnosis berdasarkan kode ICD-10
        $diagnosis = Diagnosis::whereIn('icd10', array_keys($diagnosisList))
            ->pluck('id', 'icd10')
            ->map(fn($id) => (string) $id)
            ->toArray();
    
        // Jika diagnosis kosong, langsung return hasil kosong
        if (empty($diagnosis)) {
            return response()->json([]);
        }
    
        // Ambil data tindakan berdasarkan ID diagnosis dan filter bulan & tahun
        $actionsBaru = Action::where('tipe', 'poli-gigi')->where('kasus', 1)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();
    
        $actionsLama = Action::where('tipe', 'poli-gigi')->where('kasus', 0)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();
    
        // Definisi rentang usia
        $ageGroups = [
            '0-4' => [0, 4],
            '5-6' => [5, 6],
            '7-11' => [7, 11],
            '12' => [12, 12],
            '13-14' => [13, 14],
            '15-18' => [15, 18],
            '19-34' => [19, 34],
            '35-44' => [35, 44],
            '45-64' => [45, 64],
            '65+' => [65, 150] // Asumsi batas usia tertinggi 150 tahun
        ];
    
        // Inisialisasi array data diagnosis
        $diagnosisData = [];
    
        foreach ($diagnosisList as $code => $name) {
            $diagnosisId = $diagnosis[$code] ?? null;
    
            if (!$diagnosisId) {
                continue;
            }
    
            // Filter tindakan yang memiliki diagnosis terkait untuk kasus baru
            $filteredActionsBaru = $actionsBaru->filter(function ($action) use ($diagnosisId) {
                $diagnosa = is_string($action->diagnosa) ? json_decode($action->diagnosa, true) : $action->diagnosa;
                return in_array($diagnosisId, (array) $diagnosa);
            });
    
            // Filter tindakan yang memiliki diagnosis terkait untuk kasus lama
            $filteredActionsLama = $actionsLama->filter(function ($action) use ($diagnosisId) {
                $diagnosa = is_string($action->diagnosa) ? json_decode($action->diagnosa, true) : $action->diagnosa;
                return in_array($diagnosisId, (array) $diagnosa);
            });
    
            // Inisialisasi data penyakit
            $data = [
                'code' => $code,
                'name' => $name,
                'ageGroups' => [],
                'total' => ['laki_laki' => 0, 'perempuan' => 0, 'jumlah' => 0],
                'kasus_lama' => ['laki_laki' => 0, 'perempuan' => 0, 'jumlah' => 0] // Placeholder kasus lama
            ];
    
            // Inisialisasi data per rentang usia
            foreach ($ageGroups as $group => $range) {
                $data['ageGroups'][$group] = ['laki_laki' => 0, 'perempuan' => 0, 'jumlah' => 0];
            }
    
            // Hitung jumlah pasien berdasarkan gender dan rentang usia untuk kasus baru
            foreach ($filteredActionsBaru as $action) {
                $patient = $action->patient;
                $age = \Carbon\Carbon::parse($patient->dob)->age;
                $gender = $patient->gender; // 2 = Laki-laki, 1 = Perempuan
    
                foreach ($ageGroups as $group => [$minAge, $maxAge]) {
                    if ($age >= $minAge && $age <= $maxAge) {
                        if ($gender == 2) {
                            $data['ageGroups'][$group]['laki_laki']++;
                        } else {
                            $data['ageGroups'][$group]['perempuan']++;
                        }
                        $data['ageGroups'][$group]['jumlah']++;
                    }
                }
    
                // Tambahkan ke total keseluruhan kasus baru
                if ($gender == 2) {
                    $data['total']['laki_laki']++;
                } else {
                    $data['total']['perempuan']++;
                }
                $data['total']['jumlah']++;
            }
    
            // Hitung jumlah pasien untuk kasus lama
            $data['kasus_lama']['laki_laki'] = $filteredActionsLama->where('patient.gender', 2)->count();
            $data['kasus_lama']['perempuan'] = $filteredActionsLama->where('patient.gender', 1)->count();
            $data['kasus_lama']['jumlah'] = $filteredActionsLama->count();
    
            $diagnosisData[] = $data;
        }
    
        // Kirim data ke tampilan laporan
        return view('content.report.laporan-lrkg', compact('diagnosisData', 'bulan', 'tahun'));
    }
 public function reportLKT(Request $request)
    {
        $request->validate([
            'bulan' => 'nullable|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:' . now()->year,
        ]);
    
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
    
        // Ambil semua diagnosa dari Action berdasarkan tahun (dan bulan jika dipilih)
        $query = Action::whereYear('tanggal', $tahun);
        if ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        }
        $allDiagnosa = $query->pluck('diagnosa')->toArray();
    
        // Ubah array multidimensi menjadi satu dimensi
        $flatDiagnosa = [];
        foreach ($allDiagnosa as $item) {
            if (is_string($item)) {
                $decoded = json_decode($item, true); // Decode JSON jika masih berbentuk string
                if (is_array($decoded)) {
                    $flatDiagnosa = array_merge($flatDiagnosa, $decoded);
                }
            } elseif (is_array($item)) {
                $flatDiagnosa = array_merge($flatDiagnosa, $item);
            }
        }
    
        // Hitung jumlah kemunculan setiap diagnosa dan ambil 10 terbanyak
        $topDiagnosa = array_count_values($flatDiagnosa);
        arsort($topDiagnosa);
        $topDiagnosa = array_slice($topDiagnosa, 0, 10, true); // Tetap simpan jumlah kasus
    
        // Ambil informasi diagnosa dari tabel `Diagnosis`
        $diagnosa = Diagnosis::whereIn('id', array_keys($topDiagnosa))->get();
    
        // Ambil jumlah pasien baru dan lama berdasarkan diagnosa
        $data = [];
        foreach ($diagnosa as $item) {
            $baru = Action::whereJsonContains('diagnosa', (string) $item->id)
                ->whereYear('tanggal', $tahun)
                ->when($bulan, function ($query) use ($bulan) {
                    return $query->whereMonth('tanggal', $bulan);
                })
                ->where('kasus', 1)
                ->whereNotIn('tipe', ['poli-kia', 'poli-kb'])
                ->count();
    
            $lama = Action::whereJsonContains('diagnosa', (string) $item->id)
                ->whereYear('tanggal', $tahun)
                ->when($bulan, function ($query) use ($bulan) {
                    return $query->whereMonth('tanggal', $bulan);
                })
                ->where('kasus', 0)
                ->whereNotIn('tipe', ['poli-kia', 'poli-kb'])
                ->count();
    
            $data[] = [
                'tahun' => $tahun,
                'bulan' => $bulan,
                'diagnosa' => $item->name, // Pastikan kolom benar
                'icd10' => $item->icd10,   // Pastikan kolom benar
                'baru' => $baru,
                'lama' => $lama,
                'total' => $baru + $lama, // Tambahkan total kasus
            ];
        }
    
        // Urutkan berdasarkan total kasus terbanyak
        usort($data, function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });
    
        return view('content.report.laporan-lkt', compact('data', 'tahun', 'bulan'));
    }
    public function reportLBKT()
    {
        return view('content.report.laporan-lbkt');
    }
   public function reportURT(Request $request)
    {
        // Ambil bulan & tahun dari request, atau gunakan default bulan & tahun sekarang
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
    
        $services = [
            "Hecting (Jahit Luka)",
            "Aff Hecting",
            "Ganti Verban",
            "Incisi Abses",
            "Sircumsisi (Bedah Ringan)",
            "Ekstraksi Kuku",
            "Observasi Dengan Tindakan Invasif",
            "Observasi Tanpa Tindakan Invasif",
        ];
    
        $data = [];
    
        foreach ($services as $service) {
            // Inisialisasi array default untuk mencegah "Undefined array key"
            $data[$service] = [
                'pbi' => 0,
                'askes' => 0,
                'jkn_mandiri' => 0,
                'umum' => 0,
                'jkd' => 0,
            ];
    
            // Hitung jumlah berdasarkan kartu dengan filter bulan & tahun
            foreach (['pbi', 'askes', 'jkn_mandiri', 'umum', 'jkd'] as $kartu) {
                $data[$service][$kartu] = Action::where('tindakan_ruang_tindakan', $service)
                    ->whereHas('patient', function ($query) use ($kartu) {
                        $query->where('jenis_kartu', $kartu);
                    })
                    ->whereYear('tanggal', $tahun) // Filter berdasarkan tahun
                    ->whereMonth('tanggal', $bulan) // Filter berdasarkan bulan
                    ->count() ?: 0;
            }
        }
    
        return view('content.report.laporan-urt', compact('data', 'bulan', 'tahun'));
    }
    public function reportLKRJ()
    {
        return view('content.report.laporan-lkrj');
    }
   public function reportRRT(Request $request)
    {
        // Get the selected month and year from the request
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
    
        // Get top 10 rujukan RS (excluding '1')
        $rujukanQuery = Action::select('rujuk_rs', DB::raw('COUNT(*) as count'))
            ->where('rujuk_rs', '!=', '1');
    
        // Apply month and year filter if provided
        if ($bulan && $tahun) {
            $rujukanQuery->whereMonth('tanggal', $bulan)
                         ->whereYear('tanggal', $tahun);
        }
    
        $rujukan = $rujukanQuery->groupBy('rujuk_rs')
                                ->orderByDesc('count')
                                ->take(10)
                                ->get();
    
        // Get the actions with diagnosis data
          $actionsQuery = Action::select('diagnosa')
        ->where('rujuk_rs', '!=', '1')
        ->whereNotIn('tipe', ['poli-kia', 'poli-kb']);
    
        // Apply month and year filter for actions if provided
        if ($bulan && $tahun) {
            $actionsQuery->whereMonth('tanggal', $bulan)
                         ->whereYear('tanggal', $tahun);
        }
    
        $actions = $actionsQuery->get();
    
        // Process the diagnosis data
        $diagnosisData = [];
        $allDiagnosisIds = [];
    
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
    
            if (!empty($diagnosisIds)) {
                $allDiagnosisIds = array_merge($allDiagnosisIds, $diagnosisIds);
            }
        }
    
        // Fetch all relevant diagnoses in one query
        $diagnoses = Diagnosis::whereIn('id', array_unique($allDiagnosisIds))->get()->keyBy('id');
    
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
                $diagnosis = $diagnoses[$diagnosisId] ?? null;
                $key = $diagnosisId . '-' . ($diagnosis->icd10 ?? 'Unknown');
    
                if (!isset($diagnosisData[$key])) {
                    $diagnosisData[$key] = [
                        'name' => $diagnosis->name ?? 'Unknown',
                        'icd10' => $diagnosis->icd10 ?? 'Unknown',
                        'count' => 0,
                    ];
                }
    
                $diagnosisData[$key]['count']++;
            }
        }
    
        // Sort and get top 10 diagnoses
        usort($diagnosisData, fn($a, $b) => $b['count'] - $a['count']);
        $topDiagnoses = array_slice($diagnosisData, 0, 10);
    
        return view('content.report.laporan-rrt', compact('rujukan', 'topDiagnoses', 'bulan', 'tahun'));

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
    public function reportLR(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
    
        $rujukanQuery = Action::select('rujuk_rs', DB::raw('COUNT(*) as count'))
            ->where('rujuk_rs', '!=', '1');
    
        if ($bulan && $tahun) {
            $rujukanQuery->whereMonth('tanggal', $bulan)
                         ->whereYear('tanggal', $tahun);
        }
    
        $rujukan = $rujukanQuery->groupBy('rujuk_rs')
                                ->orderByDesc('count')
                                ->get();
    
        $hospitalIds = $rujukan->pluck('rujuk_rs')->unique();
        $hospitals = Hospital::whereIn('id', $hospitalIds)->get()->keyBy('id');
        $hospitalColumns = $hospitals->pluck('name')->toArray();
    
        foreach ($rujukan as $r) {
            $r->hospital_name = $hospitals[$r->rujuk_rs]->name ?? 'Unknown';
        }
    
        $actionsQuery = Action::select(
                'actions.diagnosa',
                'actions.rujuk_rs',
                'patients.gender',
                'patients.jenis_kartu as payment_method' // Menggunakan alias agar lebih jelas
            )
            ->join('patients', 'patients.id', '=', 'actions.id_patient')
            ->where('actions.rujuk_rs', '!=', '1');
    
        if ($bulan && $tahun) {
            $actionsQuery->whereMonth('tanggal', $bulan)
                         ->whereYear('tanggal', $tahun);
        }
    
        $actions = $actionsQuery->get();
        $diagnosisData = [];
        $allDiagnosisIds = [];
    
        foreach ($actions as $action) {
            $diagnosisIds = is_string($action->diagnosa) ? json_decode($action->diagnosa, true) : $action->diagnosa;
            if (is_array($diagnosisIds)) {
                $allDiagnosisIds = array_merge($allDiagnosisIds, $diagnosisIds);
            }
        }
    
        $diagnoses = Diagnosis::whereIn('id', array_unique($allDiagnosisIds))->get()->keyBy('id');
    
        foreach ($actions as $action) {
            $diagnosisIds = is_string($action->diagnosa) ? json_decode($action->diagnosa, true) : $action->diagnosa;
            if (!is_array($diagnosisIds)) continue;
    
            foreach ($diagnosisIds as $diagnosisId) {
                $diagnosis = $diagnoses[$diagnosisId] ?? null;
                $key = $diagnosisId . '-' . ($diagnosis->icd10 ?? 'Unknown');
                $hospitalName = $hospitals[$action->rujuk_rs]->name ?? 'Unknown';
    
                if (!isset($diagnosisData[$key])) {
                    $diagnosisData[$key] = [
                        'name' => $diagnosis->name ?? 'Unknown',
                        'icd10' => $diagnosis->icd10 ?? 'Unknown',
                        'count' => 0,
                        'hospitals' => array_fill_keys($hospitalColumns, 0),
                        'male' => 0,
                        'female' => 0,
                        'payments' => [
                            'pbi' => 0, 'askes' => 0, 'jkn_mandiri' => 0, 'umum' => 0, 'jkd' => 0
                        ]
                    ];
                }
    
                $diagnosisData[$key]['count']++;
                if ($action->gender === 2) {
                    $diagnosisData[$key]['male']++;
                } elseif ($action->gender === 1) {
                    $diagnosisData[$key]['female']++;
                }
    
                // Pastikan payment_method tidak null dan cocok dengan daftar
                $paymentMethod = $action->payment_method ?? 'umum';
                if (isset($diagnosisData[$key]['payments'][$paymentMethod])) {
                    $diagnosisData[$key]['payments'][$paymentMethod]++;
                }
    
                $diagnosisData[$key]['hospitals'][$hospitalName]++;
            }
        }
    
        // Urutkan berdasarkan jumlah kasus terbanyak
        usort($diagnosisData, fn($a, $b) => $b['count'] - $a['count']);
        $topDiagnoses = array_slice($diagnosisData, 0);
    
        // Hitung total keseluruhan
        $totalRow = [
            'name' => 'Total',
            'icd10' => '-',
            'count' => array_sum(array_column($topDiagnoses, 'count')),
            'male' => array_sum(array_column($topDiagnoses, 'male')),
            'female' => array_sum(array_column($topDiagnoses, 'female')),
            'payments' => [
                'pbi' => array_sum(array_column(array_column($topDiagnoses, 'payments'), 'pbi')),
                'askes' => array_sum(array_column(array_column($topDiagnoses, 'payments'), 'askes')),
                'jkn_mandiri' => array_sum(array_column(array_column($topDiagnoses, 'payments'), 'jkn_mandiri')),
                'umum' => array_sum(array_column(array_column($topDiagnoses, 'payments'), 'umum')),
                'jkd' => array_sum(array_column(array_column($topDiagnoses, 'payments'), 'jkd'))
            ],
            'hospitals' => array_fill_keys($hospitalColumns, 0)
        ];
    
        foreach ($hospitalColumns as $hospital) {
            $totalRow['hospitals'][$hospital] = array_sum(array_column(array_column($topDiagnoses, 'hospitals'), $hospital));
        }
    
        // Tambahkan total ke hasil akhir
        $topDiagnoses[] = $totalRow;
    
        return view('content.report.laporan-lr', compact('rujukan', 'topDiagnoses', 'bulan', 'tahun', 'hospitalColumns'));
    }
    public function reportUP(Request $request)
    {
        // Get the selected month and year from the request
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
    
        // Build the query
        $patients = Action::whereHas('patient', function ($query) use ($bulan, $tahun) {
            $query->whereBetween(DB::raw('TIMESTAMPDIFF(YEAR, dob, CURDATE())'), [15, 59]);
    
            // Filter by month and year if provided
            if ($bulan && $tahun) {
                $query->whereMonth('created_at', $bulan)
                      ->whereYear('created_at', $tahun);
            }
        })->get();
    
        return view('content.report.laporan-up', compact('patients'));
    }
    
}
