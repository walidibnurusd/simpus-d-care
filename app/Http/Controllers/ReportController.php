<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Disease;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Action;
use App\Models\Patients;
use App\Models\Kunjungan;
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
use PhpOffice\PhpSpreadsheet\IOFactory;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $routeName = $request->route()->getName();
        return view('content.report.index', compact('routeName'));
    }
    public function printTifoid(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $diagnosaValue = '600';

        $tifoid = Action::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->filter(function ($action) use ($diagnosaValue) {
                return is_array($action->diagnosa) && in_array($diagnosaValue, $action->diagnosa);
            });

        return view('content.report.laporan-tifoid', compact('tifoid'));
    }

    public function printDiare()
    {
        return view('content.report.print-diare');
    }
    public function reportDiare(Request $request)
    {
        // Get the month and year from the request
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $diagnosaValue = '602';

        $diare = Action::with(['patient', 'hospitalReferral'])
            ->where(function ($query) use ($diagnosaValue) {
                $query->whereIn('diagnosa', [$diagnosaValue])->orWhereJsonContains('diagnosa', $diagnosaValue);
            })
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        // Diagnosis and dehydration mappings
        $diagnosaMap = [
            602 => 'Diare & gastroenteritis oleh penyebab infeksi tertentu (coalitis infeksi)',
        ];

        $dehidrasiMap = [
            602 => 'Tanpa Dehidrasi',
        ];

        $diare = $diare->map(function ($data) use ($diagnosaMap, $dehidrasiMap) {
            if (is_array($data->diagnosa) && in_array(602, $data->diagnosa)) {
                $data->diagnosa_names = [$diagnosaMap[602]];
                $data->dehidrasi = $dehidrasiMap[602];
            } else {
                $data->diagnosa_names = ['Tidak Diketahui'];
                $data->dehidrasi = 'Tidak Diketahui';
            }

            return $data;
        });
        return view('content.report.report-diare', compact('diare', 'bulan', 'tahun'));
    }

    public function reportSTP(Request $request)
    {
        $bulanMap = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $angkaBulan = (int) $request->input('bulan');
        $bulan = $bulanMap[$angkaBulan] ?? 'Bulan Tidak Dikenal';
        $tahun = $request->tahun;

        // Diagnosis Values Mapping
        $diagnoses = [
            'kolera' => ['989'],
            'diare' => ['602'],
            'disentri' => ['601'],
            'demamTifoid' => ['600'],
            'tbParu' => ['603'],
            'tersangkaTbParu' => ['990'],
            'kustaPb' => ['991'],
            'kustaMb' => ['992'],
            'campak' => ['623'],
            'difteri' => ['610'],
            'batuk' => ['611'],
            'tetanus' => ['609'],
            'hepatitisKlinis' => ['993'],
            'malaria' => ['639'],
            'malariaVivax' => ['994'],
            'malariaFalciparum' => ['995'],
            'malariaMix' => ['995'],
            'dbd' => ['618'],
            'dd' => ['617'],
            'pneumonia' => ['733'],
            'gonore' => ['614'],
            'frambusia' => ['615'],
            'filariasis' => ['643'],
            'influenza' => ['731'],
        ];

        // Retrieve and process data for each diagnosis
        $diagnosisData = [];
        foreach ($diagnoses as $key => $values) {
            $diagnosisData[$key] = $this->getGroupedDataAll($values, $angkaBulan, $tahun);
        }

        // Group cases by age
        $groupedDataByAge = [];
        foreach ($diagnosisData as $key => $data) {
            $groupedDataByAge[$key] = $this->groupByAgeAll($data);
        }

        // Count total cases by gender
        $groupedDataByGender = [];
        foreach ($diagnosisData as $key => $data) {
            $groupedDataByGender[$key] = [
                'datas' => $this->getTotalByGender($data),
            ];
        }

        // Load Excel template
        $templatePath = public_path('assets/report/report-surveilans.xlsx');
        if (!file_exists($templatePath)) {
            abort(404, 'Template Excel tidak ditemukan.');
        }

        // Open the template Excel file
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('O4', $bulan);
        $sheet->setCellValue('O3', $tahun);

        // Age columns
        $columns = [
            '0-7 hari' => 'C',
            '8-28 hari' => 'D',
            '1-11 bulan' => 'E',
            '1-4 thn' => 'F',
            '5-9 thn' => 'G',
            '10-14 thn' => 'H',
            '15-19 thn' => 'I',
            '20-44 thn' => 'J',
            '45-54 thn' => 'K',
            '55-59 thn' => 'L',
            '60-69 thn' => 'M',
            '>70 thn' => 'N',
        ];

        $row = 9;

        foreach ($groupedDataByAge as $key => $groupedAgeData) {
            // Write data for age and gender
            $this->writeAgeDataToExcel($sheet, $row, $groupedAgeData, $columns);
            $this->writeGenderDataToExcelStp($sheet, $row, $groupedDataByGender[$key]['datas']);

            // Increment row after writing data
            $row++;
        }

        // Stream the Excel file to user
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'laporan-surveilans.xlsx');
    }

    public function reportAFP(Request $request)
    {
        $bulanMap = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        // misalnya request input-nya seperti ini:
        $angkaBulan = (int) $request->input('bulan');
        $bulan = $bulanMap[$angkaBulan] ?? 'Bulan Tidak Dikenal';
        $tahun = $request->tahun;

        $templatePath = public_path('assets/report/report-afp.xlsx');

        if (!file_exists($templatePath)) {
            abort(404, 'Template Excel tidak ditemukan.');
        }

        // Buka template
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('M3', 'Bulan : ' . $bulan);
        $sheet->setCellValue('Q3', 'Tahun : ' . $tahun);
        $tanggal = Carbon::now()->translatedFormat('j F Y');
        $sheet->setCellValue('O20', 'Makassar, ' . $tanggal);
        // Stream ke user (tanpa menyimpan di server)
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'laporan-afp.xlsx');
    }
    public function reportDifteri()
    {
        return view('content.report.laporan-difteri');
    }

    public function reportC1(Request $request)
    {
        function calculateAge($dob)
        {
            $dob = Carbon::parse($dob);
            $now = Carbon::now();

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
            $dob = Carbon::parse($dob);
            $now = Carbon::now();

            if ($dob->diffInYears($now) > 0) {
                return 'years'; // Jika umur dalam tahun
            } elseif ($dob->diffInMonths($now) > 0) {
                return 'months'; // Jika umur dalam bulan
            } else {
                return 'days'; // Jika umur dalam hari
            }
        }

        $bulanMap = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $angkaBulan = (int) $request->input('bulan');
        $bulan = $bulanMap[$angkaBulan] ?? 'Bulan Tidak Dikenal';
        $tahun = $request->tahun;

        $templatePath = public_path('assets/report/report-campak.xlsx');

        if (!file_exists($templatePath)) {
            abort(404, 'Template Excel tidak ditemukan.');
        }

        // Buka template
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A3', 'Bulan/Tahun : ' . $bulan . '/' . $tahun);
        $tanggal = Carbon::now()->translatedFormat('j F Y');
        $sheet->setCellValue('O18', 'Makassar, ' . $tanggal);
        // Stream ke user (tanpa menyimpan di server)
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'laporan-kasus-campak.xlsx');
    }
    public function reportPTM()
    {
        function calculateAgePTM($dob)
        {
            $dob = Carbon::parse($dob);
            $now = Carbon::now();

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
            $dob = Carbon::parse($dob);
            $now = Carbon::now();

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
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
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
        $sheet->getStyle('A1:S7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A5:S7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('90EE90'); // Hijau muda
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
        $sheet->getStyle('A30:A33')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('R30:R35')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
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
        $tindakan = ['Observasi Tanpa Tindakan Invasif', 'Observasi Dengan Tindakan Invasif', 'Corpus Alineum', 'Ekstraksi Kuku', 'Sircumsisi (Bedah Ringan)', 'Incisi Abses', 'Rawat Luka', 'Ganti Verban', 'Spooling', 'Toilet Telinga', 'Tetes Telinga', 'Aff Hecting', 'Hecting (Jahit Luka)', 'Tampon/Off Tampon'];

        // Ambil data dari database
        $data = Action::whereIn('tindakan_ruang_tindakan', $tindakan)->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->selectRaw('tindakan_ruang_tindakan, COUNT(*) as jumlah')->groupBy('tindakan_ruang_tindakan')->get()->keyBy('tindakan_ruang_tindakan'); // Index array dengan nama tindakan

        // Gabungkan dengan nilai default 0 jika tidak ditemukan
        $result = collect($tindakan)->map(function ($t) use ($data) {
            return [
                'tindakan_ruang_tindakan' => $t,
                'jumlah' => $data->has($t) ? $data[$t]->jumlah : 0,
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
            'K00.6' => 'Persistensi Gigi Sulung',
            'K01.1' => 'Impaksi M3 Klasifikasi IA',
            'K02' => 'Karies Gigi',
            'K03' => 'Penyakit jaringan keras gigi lainnya',
            'K04' => 'Penyakit pulpa dan jaringan periapikal',
            'K05' => 'Gingivitis dan penyakit periodontal',
            'K07' => 'Anomali Dentofasial / termasuk maloklusi Kelainan',
            'K08' => 'Gangguan gigi dan jaringan penyangga lainnya',
            'K12' => 'Stomatitis dan Lesi-lesi yang berhubungan',
            'K13.0' => 'Angular Cheilitis / penyakit bibir dan mukosa',
            'L51' => 'Eritema Multiformis',
            'R51' => 'Nyeri Orofasial',
            'S02.6' => 'Fraktur mahkota yang tidak merusak pulpa',
            'K07.3' => 'Crowded',
            'K14.3' => 'Hipertrofi of Tongue Papiloma',
            'D21.9' => 'Tumor di langit-langit',
            'M27.0' => 'Torus palatinal',
        ];

        // Ambil ID diagnosis berdasarkan kode ICD10
        $diagnosis = Diagnosis::whereIn('icd10', array_keys($diagnosisList))->pluck('id', 'icd10')->map(fn($id) => (string) $id)->toArray();

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
                'total' => $lakiLakiCount + $perempuanCount,
            ];

            // Hitung total keseluruhan
            $totalLaki += $lakiLakiCount;
            $totalPerempuan += $perempuanCount;
        }

        // Tindakan gigi
        $tindakanGigi = ['Gigi Sulung Tumpatan Sementara', 'Gigi Tetap Tumpatan Sementara', 'Gigi Tetap Tumpatan Tetap', 'Gigi Sulung Tumpatan Tetap', 'Perawatan Saluran Akar', 'Gigi Sulung Pencabutan', 'Gigi Tetap Pencabutan', 'Pembersihan Karang Gigi', 'Odontectomy', 'Sebagian Prothesa', 'Penuh Prothesa', 'Reparasi Prothesa', 'Premedikasi/Pengobatan', 'Tindakan Lain', 'Incisi Abses Gigi'];

        $tindakan = Action::where('tipe', 'poli-gigi')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->whereIn('tindakan', $tindakanGigi)->get();
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
        return view('content.report.laporan-lkg', compact('bulan', 'tahun', 'diagnosisData', 'totalLaki', 'totalPerempuan', 'tindakanGigi', 'tindakan', 'rujukanL', 'rujukanP'));
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
                'icd10' => $item->icd10, // Pastikan kolom benar
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

        $services = ['Hecting (Jahit Luka)', 'Aff Hecting', 'Ganti Verban', 'Incisi Abses', 'Sircumsisi (Bedah Ringan)', 'Ekstraksi Kuku', 'Observasi Dengan Tindakan Invasif', 'Observasi Tanpa Tindakan Invasif'];

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
                $data[$service][$kartu] =
                    Action::where('tindakan_ruang_tindakan', $service)
                        ->whereHas('patient', function ($query) use ($kartu) {
                            $query->where('jenis_kartu', $kartu);
                        })
                        ->whereYear('tanggal', $tahun) // Filter berdasarkan tahun
                        ->whereMonth('tanggal', $bulan) // Filter berdasarkan bulan
                        ->count() ?:
                    0;
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
        $rujukanQuery = Action::select('rujuk_rs', DB::raw('COUNT(*) as count'))->where('rujuk_rs', '!=', '1');

        // Apply month and year filter if provided
        if ($bulan && $tahun) {
            $rujukanQuery->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        }

        $rujukan = $rujukanQuery->groupBy('rujuk_rs')->orderByDesc('count')->take(10)->get();

        // Get the actions with diagnosis data
        $actionsQuery = Action::select('diagnosa')
            ->where('rujuk_rs', '!=', '1')
            ->whereNotIn('tipe', ['poli-kia', 'poli-kb']);

        // Apply month and year filter for actions if provided
        if ($bulan && $tahun) {
            $actionsQuery->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
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
    public function reportFormulir11(Request $request)
    {
        $bulanMap = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $angkaBulan = (int) $request->input('bulan');
        $bulan = $bulanMap[$angkaBulan] ?? 'Bulan Tidak Dikenal';
        $tahun = $request->tahun;
        $tanggal = Carbon::now()->translatedFormat('j F Y');

        // Diagnosis Values Mapping
        $diagnoses = [
            'alergi' => ['766', '778'],
            'chikungunya' => ['619'],
            'dbd' => ['618'],
            'dd' => ['617'],
            'filariasis' => ['643'],
            'infeksiUmbilikus' => ['838'],
            'kandidiasisMulut' => ['638'],
            'keracunanMakanan' => ['874'],
            'lepra' => ['607'],
            'leptospirosis' => ['606'],
            'malaria' => ['639'],
            'morbili' => ['623'],
            'reaksiAnafilaktik' => ['876'],
            'syok' => ['858'],
            'tb' => ['604'],
            'tbc' => ['603'],
            'hiv' => ['629'],
            'varisela' => ['621'],
            'anemia' => ['662'],
            'hivNonKomplikasi' => ['877'],
            'leukemia' => ['663'],
            'limfadenitis' => ['642'],
            'limfomaMaligna' => ['660'],
            'lupus' => ['791'],
            'thalasemia' => ['664'],
            'ankilostomiosis' => ['644'],
            'apendisitisAkut' => ['760'],
            'askariasis' => ['646'],
            'atresia' => ['845'],
            'bibirLangitSumbing' => ['844'],
            'bibirSumbing' => ['843'],
            'demamTifoid' => ['600'],
            'disentri' => ['601'],
            'gastritis' => ['758'],
            'diare' => ['602'],
            'gastroschisis' => ['851'],
            'hemeroid' => ['724'],
            'hepatitisA' => ['626'],
            'hepatitisB' => ['627'],
            'hepatitisC' => ['628'],
            'intoleransiMakanan' => ['763'],
            'kolesistitis' => ['762'],
            'langitSumbing' => ['842'],
            'malabsorbsiMakanan' => ['764'],
            'omphalocele' => ['850'],
            'parotitis' => ['630'],
            'pendarahan' => ['765', '940'],
            'peritonitis' => ['761'],
            'refluksGastroesofageal' => ['757'],
            'skistosomiasis' => ['640'],
            'strongiloidiasis' => ['647'],
            'taeniasis' => ['641'],
            'ulkusMulut' => ['754'],
            'astigmatisme' => ['706'],
            'bendaAsingKonjungtiva' => ['869'],
            'blefaritis' => ['692'],
            'butaSenja' => ['708'],
            'episkleritis' => ['698'],
            'glaukomaAkut' => ['702'],
            'glaukomaKronis' => ['703'],
            'hifema' => ['699'],
            'hipermetropia' => ['704'],
            'hordeolum' => ['691'],
            'katarakKongenital' => ['841'],
            'katarakDewasa' => ['700'],
            'konjungtivitisAlergi' => ['695'],
            'konjungtivitisInfeksi' => ['696'],
            'laserasi' => ['860'],
            'lowVision' => ['690'],
            'mataKering' => ['694'],
            'miopiaRingan' => ['705'],
            'perdarahanSubkonjungtiva' => ['709'],
            'presbiopia' => ['707'],
            'pterygium' => ['697'],
            'retinoblastoma' => ['658'],
            'retinopatiDiabetik' => ['701'],
            'traumaKimiaMata' => ['872'],
            'trikiasis' => ['693'],
            'bendaAsingTelinga' => ['870'],
            'mastoiditis' => ['714'],
            'otitisEksterna' => ['710'],
            'otitisMediaAkut' => ['712'],
            'otitisMediaKronik' => ['713'],
            'prebiaskusis' => ['717'],
            'serumenProp' => ['711'],
            'tuliBising' => ['715'],
            'tuliKongenital' => ['716'],
            'angina' => ['719'],
            'cardiorespiratory' => ['854'],
            'gagalJantung' => ['722'],
            'hipertensi' => ['718'],
            'infarkMiokard' => ['720'],
            'takikardia' => ['721'],
            'artritisReumatoid' => ['792'],
            'osteoartritis' => ['789'],
            'frakturTerbuka' => ['862'],
            'frakturTertutup' => ['863'],
            'lipoma' => ['661'],
            'osteoporosis' => ['794'],
            'osteosarkoma' => ['654'],
            'polimialgiaReumatik' => ['793'],
            'reductionDeformity' => ['849'],
            'talipes' => ['848'],
            'vulnus' => ['864'],
            'anencephaly' => ['839'],
            'bellsPalsy' => ['689'],
            'delirium' => ['675'],
            'epilepsi' => ['684'],
            'kejang' => ['857'],
            'meningo' => ['840'],
            'migren' => ['686'],
            'neuroblastoma' => ['659'],
            'rabies' => ['616'],
            'statusEpileptikus' => ['685'],
            'stroke' => ['723'],
            'tensionHeadache' => ['687'],
            'tetanus' => ['609'],
            'tetanusNeonatorum' => ['608'],
            'tia' => ['688'],
            'vertigo' => ['855'],
            'demensia' => ['674'],
            'gangguanAnxietas' => ['679'],
            'anxietasDepresi' => ['680'],
            'depresi' => ['678'],
            'gangguanNapza' => ['676'],
            'gangguanAnak' => ['683'],
            'gangguanPsikotik' => ['677'],
            'gangguanSomatoform' => ['681'],
            'insomnia' => ['682'],
            'asmaBronkial' => ['741'],
            'asfiksia' => ['852'],
            'bendaAsingHidung' => ['871'],
            'bronkitisAkut' => ['734'],
            'bronkitisAkutDewasa' => ['739'],
            'difteria' => ['610'],
            'epistaksis' => ['853'],
            'faringitisAkut' => ['727'],
            'furunkelHidung' => ['737'],
            'influenza' => ['731'],
            'kankerNasofaring' => ['651'],
            'kankerParu' => ['653'],
            'laringitisAkut' => ['729'],
            'penyakitParu' => ['740'],
            'pertusis' => ['611'],
            'pneumoniaAspirasi' => ['743'],
            'bronkopneumonia' => ['732'],
            'pneumonia' => ['733'],
            'pneumotoraks' => ['744'],
            'commonCold' => ['725'],
            'rinitisAlergi' => ['736'],
            'rinitisVasomotor' => ['735'],
            'sinusitisAkut' => ['726'],
            'statusAsmatikus' => ['742'],
            'tonsilitisAkut' => ['728'],
            'tonsilitisKronis' => ['738'],
            'akneVulgarisRingan' => ['784'],
            'cutaneusLarvaMigrans' => ['645'],
            'dermatitisAtopik' => ['771'],
            'dermatitisKontakAlergi' => ['775'],
            'dermatitisKontakIritan' => ['776'],
            'dermatitisNumularis' => ['772'],
            'dermatitisPerioral' => ['785'],
            'dermatitisPopok' => ['774'],
            'dermatitisSeboroik' => ['773'],
            'tineaCapitis' => ['631'],
            'tineaCorporis' => ['635'],
            'tineaCruris' => ['636'],
            'tineaManuum' => ['633'],
            'tineaPedis' => ['634'],
            'tineaUnguium' => ['632'],
            'erisipelas' => ['612'],
            'eritrasma' => ['770'],
            'fixedDrugEruption' => ['777'],
            'exanthematousDrugEruption' => ['777'],
            'frambusia' => ['615'],
            'herpesSimplek' => ['620'],
            'herpesZoster' => ['622'],
            'hidradenitisSupuratif' => ['786'],
            'likenSimpleks' => ['779'],
            'lukaBakar' => ['873'],
            'miliaria' => ['787'],
            'moluskumKontagiosum' => ['625'],
            'pedikulosisKapitis' => ['648'],
            'pedikulosisPubis' => ['649'],
            'abses' => ['768'],
            'impetigo' => ['767'],
            'pioderma' => ['769'],
            'pitiriasisRosea' => ['780'],
            'pitiriasisVersikolor' => ['637'],
            'reaksiGigitanSerangga' => ['875'],
            'sindromStevensJohnson' => ['783'],
            'skabies' => ['650'],
            'skrofuloderma' => ['605'],
            'ulkusTungkai' => ['788'],
            'urtikaria' => ['781'],
            'verukaVulgaris' => ['624'],
            'diabetesMellitus1' => ['667'],
            'diabetesMellitus2' => ['668'],
            'hiperglikemia' => ['859'],
            'hiperurisemia' => ['673'],
            'hipoglikemia' => ['669'],
            'hipotiroidKongenital' => ['665'],
            'lipidemia' => ['672'],
            'malnutrisiEnergi' => ['670'],
            'obesitas' => ['671'],
            'tirotoksikosis' => ['666'],
            'epispadia' => ['847'],
            'fimosis' => ['799'],
            'hipertropiProstat' => ['798'],
            'hypospadia' => ['846'],
            'infeksiSaluranKemih' => ['797'],
            'parafimosis' => ['800'],
            'ginjalKronik' => ['795'],
            'pielonefritis' => ['796'],
            'abortusInkomplit' => ['809'],
            'abortusKomplit' => ['808'],
            'anemiaDefisiensi' => ['837'],
            'crackedNipple' => ['835'],
            'eklampsi' => ['813'],
            'hiperemesisGravidarum' => ['817'],
            'invertedNipple' => ['834'],
            'kankerServiks' => ['657'],
            'kehamilanNormal' => ['833'],
            'ketubanPecahDini' => ['827'],
            'mastitis' => ['801'],
            'perdarahanPostPartum' => ['832'],
            'persalinanLama' => ['830'],
            'preEklampsia' => ['812'],
            'rupturPerineum' => ['831'],
            'tumorPayudara' => ['656'],
            'fluorAlbus' => ['805'],
            'sifilis' => ['613'],
            'gonore' => ['614'],
            'vaginitis' => ['802'],
            'vulvitis' => ['803'],
        ];

        // Retrieve and process data for each diagnosis
        $diagnosisData = [];
        foreach ($diagnoses as $key => $values) {
            $diagnosisData[$key] = $this->getGroupedData($values, $angkaBulan, $tahun);
        }

        // Group cases by age
        $groupedDataByAge = [];
        foreach ($diagnosisData as $key => $data) {
            $groupedDataByAge[$key] = $this->groupByAge($data['kasusBaru']);
        }

        // Count total cases by gender
        $groupedDataByGender = [];
        foreach ($diagnosisData as $key => $data) {
            $groupedDataByGender[$key] = [
                'barus' => $this->getTotalByGender($data['kasusBaru']),
                'lamas' => $this->getTotalByGender($data['kasusLama']),
                'totalBaru' => $data['kasusBaru']->count(),
                'totalLama' => $data['kasusLama']->count(),
            ];
        }

        // Load Excel template
        $templatePath = public_path('assets/report/report-11.xlsx');
        if (!file_exists($templatePath)) {
            abort(404, 'Template Excel tidak ditemukan.');
        }

        // Open the template Excel file
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('K5', $bulan);
        $sheet->setCellValue('K7', $tahun);
        $sheet->setCellValue('P357', 'Makassar, ' . $tanggal);

        // Age columns
        $columns = [
            '0-7 hari' => 'D',
            '8-28 hari' => 'E',
            '1-11 bulan' => 'F',
            '1-4 thn' => 'G',
            '5-9 thn' => 'H',
            '10-14 thn' => 'I',
            '15-19 thn' => 'J',
            '20-44 thn' => 'K',
            '45-59 thn' => 'L',
            '>59 thn' => 'M',
        ];

        $row = 13; // Starting row
        $skipRow1 = [15];
        $skipRow2 = [38];
        $skipRow3 = [49];
        $skipRow4 = [106];
        $skipRow5 = [139];
        $skipRow6 = [146];
        $skipRow7 = [164];
        $skipRow8 = [200];
        $skipRow9 = [223];
        $skipRow10 = [235];
        $skipRow11 = [238];
        $skipRow12 = [251];
        $skipRow13 = [278];
        $skipRow14 = [297];
        $skipRow15 = [311];
        $skipRow16 = [323];
        $skipRow17 = [324];
        $skipRow18 = [347];

        $skipRangeStart = 18;
        $skipRangeEnd = 20;
        $skipRangeStart2 = 29;
        $skipRangeEnd2 = 31;
        $skipRangeStart3 = 41;
        $skipRangeEnd3 = 43;
        $skipRangeStart4 = 52;
        $skipRangeEnd4 = 54;
        $skipRangeStart5 = 64;
        $skipRangeEnd5 = 66;
        $skipRangeStart6 = 77;
        $skipRangeEnd6 = 79;
        $skipRangeStart7 = 87;
        $skipRangeEnd7 = 90;
        $skipRangeStart8 = 99;
        $skipRangeEnd8 = 101;
        $skipRangeStart9 = 111;
        $skipRangeEnd9 = 113;
        $skipRangeStart10 = 123;
        $skipRangeEnd10 = 126;
        $skipRangeStart11 = 135;
        $skipRangeEnd11 = 137;
        $skipRangeStart12 = 147;
        $skipRangeEnd12 = 149;
        $skipRangeStart13 = 160;
        $skipRangeEnd13 = 162;
        $skipRangeStart14 = 173;
        $skipRangeEnd14 = 175;
        $skipRangeStart15 = 184;
        $skipRangeEnd15 = 187;
        $skipRangeStart16 = 195;
        $skipRangeEnd16 = 197;
        $skipRangeStart17 = 207;
        $skipRangeEnd17 = 209;
        $skipRangeStart18 = 219;
        $skipRangeEnd18 = 221;
        $skipRangeStart19 = 231;
        $skipRangeEnd19 = 233;
        $skipRangeStart20 = 244;
        $skipRangeEnd20 = 246;
        $skipRangeStart21 = 256;
        $skipRangeEnd21 = 258;
        $skipRangeStart22 = 268;
        $skipRangeEnd22 = 270;
        $skipRangeStart23 = 280;
        $skipRangeEnd23 = 282;
        $skipRangeStart24 = 291;
        $skipRangeEnd24 = 293;
        $skipRangeStart25 = 302;
        $skipRangeEnd25 = 304;
        $skipRangeStart26 = 314;
        $skipRangeEnd26 = 316;
        $skipRangeStart27 = 326;
        $skipRangeEnd27 = 328;
        $skipRangeStart28 = 338;
        $skipRangeEnd28 = 340;
        $skipRangeStart29 = 350;
        $skipRangeEnd29 = 352;

        // Combine all rows to skip
        $skipRowsCombined = array_merge(
            $skipRow1,
            $skipRow2,
            $skipRow3,
            $skipRow4,
            $skipRow5,
            $skipRow6,
            $skipRow7,
            $skipRow8,
            $skipRow9,
            $skipRow10,
            $skipRow11,
            $skipRow12,
            $skipRow13,
            $skipRow14,
            $skipRow15,
            $skipRow16,
            $skipRow17,
            $skipRow18,

            range($skipRangeStart, $skipRangeEnd),
            range($skipRangeStart2, $skipRangeEnd2),
            range($skipRangeStart3, $skipRangeEnd3),
            range($skipRangeStart4, $skipRangeEnd4),
            range($skipRangeStart5, $skipRangeEnd5),
            range($skipRangeStart6, $skipRangeEnd6),
            range($skipRangeStart7, $skipRangeEnd7),
            range($skipRangeStart8, $skipRangeEnd8),
            range($skipRangeStart9, $skipRangeEnd9),
            range($skipRangeStart10, $skipRangeEnd10),
            range($skipRangeStart11, $skipRangeEnd11),
            range($skipRangeStart12, $skipRangeEnd12),
            range($skipRangeStart13, $skipRangeEnd13),
            range($skipRangeStart14, $skipRangeEnd14),
            range($skipRangeStart15, $skipRangeEnd15),
            range($skipRangeStart16, $skipRangeEnd16),
            range($skipRangeStart17, $skipRangeEnd17),
            range($skipRangeStart18, $skipRangeEnd18),
            range($skipRangeStart19, $skipRangeEnd19),
            range($skipRangeStart20, $skipRangeEnd20),
            range($skipRangeStart21, $skipRangeEnd21),
            range($skipRangeStart22, $skipRangeEnd22),
            range($skipRangeStart23, $skipRangeEnd23),
            range($skipRangeStart24, $skipRangeEnd24),
            range($skipRangeStart25, $skipRangeEnd25),
            range($skipRangeStart26, $skipRangeEnd26),
            range($skipRangeStart27, $skipRangeEnd27),
            range($skipRangeStart28, $skipRangeEnd28),
            range($skipRangeStart29, $skipRangeEnd29),
        );

        foreach ($groupedDataByAge as $key => $groupedAgeData) {
            // Skip rows for kasusu lama
            while (in_array($row, $skipRowsCombined)) {
                $row++; // Skip to the next row
            }

            // Write data for age and gender
            $this->writeAgeDataToExcel($sheet, $row, $groupedAgeData, $columns);
            $this->writeGenderDataToExcel($sheet, $row, $groupedDataByGender[$key]['barus'], $groupedDataByGender[$key]['lamas'], $groupedDataByGender[$key]['totalBaru'], $groupedDataByGender[$key]['totalLama']);

            // Increment row after writing data
            $row++;
        }

        // Stream the Excel file to user
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'laporan-formulir11.xlsx');
    }
    public function reportFormulir13(Request $request)
    {
        $bulanMap = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $angkaBulan = (int) $request->input('bulan');
        $bulan = $bulanMap[$angkaBulan] ?? 'Bulan Tidak Dikenal';
        $tahun = $request->tahun;
        $tanggal = Carbon::now()->translatedFormat('j F Y');

        // Diagnosis Values Mapping
        $diagnoses = [
            'persistensiGigiSulung' => ['745'],
            'impaksiM3' => ['746'],
            'kariesGigi' => ['747'],
            'penyakitJaringanKerasGigi' => ['748'],
            'penyakitPulpaJaringanPeriapikal' => ['749'],
            'gingivitisPenyakitPeriodental' => ['750'],
            'anormali' => ['751'],
            'gangguanGigi' => ['753'],
            'stomatitis' => ['754'],
            'angularCheilitis' => ['755'],
            'eritemaMultiformis' => ['782'],
            'cephalgia' => ['856'],
            'frakturMahkota' => ['861'],
        ];

        // Retrieve and process data for each diagnosis
        $diagnosisData = [];
        foreach ($diagnoses as $key => $values) {
            $diagnosisData[$key] = $this->getGroupedData($values, $angkaBulan, $tahun);
        }

        // Group cases by age
        $groupedDataByAge = [];
        foreach ($diagnosisData as $key => $data) {
            $groupedDataByAge[$key] = $this->groupByAge($data['kasusBaru']);
        }

        // Count total cases by gender
        $groupedDataByGender = [];
        foreach ($diagnosisData as $key => $data) {
            $groupedDataByGender[$key] = [
                'barus' => $this->getTotalByGender($data['kasusBaru']),
                'lamas' => $this->getTotalByGender($data['kasusLama']),
                'totalBaru' => $data['kasusBaru']->count(),
                'totalLama' => $data['kasusLama']->count(),
            ];
        }

        // Load Excel template
        $templatePath = public_path('assets/report/report-13.xlsx');
        if (!file_exists($templatePath)) {
            abort(404, 'Template Excel tidak ditemukan.');
        }

        // Open the template Excel file
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('M5', $bulan);
        $sheet->setCellValue('M7', $tahun);
        $sheet->setCellValue('O35', 'Makassar, ' . $tanggal);

        // Age columns
        $columns = [
            '0-7 hari' => 'D',
            '8-28 hari' => 'E',
            '1-11 bulan' => 'F',
            '1-4 thn' => 'G',
            '5-9 thn' => 'H',
            '10-14 thn' => 'I',
            '15-19 thn' => 'J',
            '20-44 thn' => 'K',
            '45-59 thn' => 'L',
            '>59 thn' => 'M',
        ];

        $row = 12;

        $skipRangeStart = 15;
        $skipRangeEnd = 18;
        $skipRangeStart2 = 27;
        $skipRangeEnd2 = 30;

        // Combine all rows to skip
        $skipRowsCombined = array_merge(range($skipRangeStart, $skipRangeEnd), range($skipRangeStart2, $skipRangeEnd2));

        foreach ($groupedDataByAge as $key => $groupedAgeData) {
            // Skip rows for kasusu lama
            while (in_array($row, $skipRowsCombined)) {
                $row++; // Skip to the next row
            }

            // Write data for age and gender
            $this->writeAgeDataToExcel($sheet, $row, $groupedAgeData, $columns);
            $this->writeGenderDataToExcel($sheet, $row, $groupedDataByGender[$key]['barus'], $groupedDataByGender[$key]['lamas'], $groupedDataByGender[$key]['totalBaru'], $groupedDataByGender[$key]['totalLama']);

            // Increment row after writing data
            $row++;
        }

        // Stream the Excel file to user
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'laporan-formulir13.xlsx');
    }
    public function reportFormulir12(Request $request)
    {
        $bulanMap = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $angkaBulan = (int) $request->input('bulan');
        $bulan = $bulanMap[$angkaBulan] ?? 'Bulan Tidak Dikenal';
        $tahun = $request->tahun;
        $tanggal = Carbon::now()->translatedFormat('j F Y');

        // Diagnosis Values Mapping
        $diagnoses = [
            'diareTanpaDehidrasi' => ['997'],
            'diare' => ['602'],
            'diareDehidrasiBerat' => ['998'],
            'pneumonia' => ['733'],
            'demamTifoid' => ['600'],
            'demamTifoidProbable' => ['999'],
            'afp' => ['1000'],
            'hepatitis' => ['993'],
            'buta' => ['1001'],
            'cederaAkibatKecelakaan' => ['1002'],
            'cederaAkibatTenggelam' => ['1003'],
            'cederaAkibatJatuh' => ['1004'],
            'cederaAkibatLukaBakar' => ['873'],
            'cederaAkibatGigiUlar' => ['1005'],
            'cederaAkibatGangguanKesehatan' => ['1006'],
            'cederaAkibatKekerasanMental' => ['1007'],
            'cederaAkibatKekerasanSeksual' => ['1008'],
            'keracunanBahanKimia' => ['1009'],
            'keracunanMakanan' => ['874'],
            'sakitKerja' => ['1010'],
            'cederaKerja' => ['1011'],
            'bunuhDiri' => ['1012'],
            'traumaLahir' => ['1013'],
            'kembarSiam' => ['1014'],
        ];

        // Retrieve and process data for each diagnosis
        $diagnosisData = [];
        foreach ($diagnoses as $key => $values) {
            $diagnosisData[$key] = $this->getGroupedData($values, $angkaBulan, $tahun);
        }

        // Group cases by age
        $groupedDataByAge = [];
        foreach ($diagnosisData as $key => $data) {
            $groupedDataByAge[$key] = $this->groupByAge($data['kasusBaru']);
        }

        // Count total cases by gender
        $groupedDataByGender = [];
        foreach ($diagnosisData as $key => $data) {
            $groupedDataByGender[$key] = [
                'barus' => $this->getTotalByGender($data['kasusBaru']),
                'lamas' => $this->getTotalByGender($data['kasusLama']),
                'totalBaru' => $data['kasusBaru']->count(),
                'totalLama' => $data['kasusLama']->count(),
            ];
        }

        // Load Excel template
        $templatePath = public_path('assets/report/report-12.xlsx');
        if (!file_exists($templatePath)) {
            abort(404, 'Template Excel tidak ditemukan.');
        }

        // Open the template Excel file
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('M5', $bulan);
        $sheet->setCellValue('M7', $tahun);
        $sheet->setCellValue('N68', 'Makassar, ' . $tanggal);

        // Age columns
        $columns = [
            '0-7 hari' => 'D',
            '8-28 hari' => 'E',
            '1-11 bulan' => 'F',
            '1-4 thn' => 'G',
            '5-9 thn' => 'H',
            '10-14 thn' => 'I',
            '15-19 thn' => 'J',
            '20-44 thn' => 'K',
            '45-59 thn' => 'L',
            '>59 thn' => 'M',
        ];

        $row = 13;
        $skipRow1 = [19];
        $skipRow2 = [27];
        $skipRow3 = [35];
        $skipRow4 = [58];
        $skipRow5 = [60];

        $skipRangeStart = 14;
        $skipRangeEnd = 16;
        $skipRangeStart2 = 21;
        $skipRangeEnd2 = 24;
        $skipRangeStart3 = 30;
        $skipRangeEnd3 = 33;
        $skipRangeStart4 = 38;
        $skipRangeEnd4 = 40;
        $skipRangeStart5 = 46;
        $skipRangeEnd5 = 48;
        $skipRangeStart6 = 52;
        $skipRangeEnd6 = 55;
        $skipRangeStart7 = 62;
        $skipRangeEnd7 = 65;

        // Combine all rows to skip
        $skipRowsCombined = array_merge($skipRow1, $skipRow2, $skipRow3, $skipRow4, $skipRow5, range($skipRangeStart, $skipRangeEnd), range($skipRangeStart2, $skipRangeEnd2), range($skipRangeStart3, $skipRangeEnd3), range($skipRangeStart4, $skipRangeEnd4), range($skipRangeStart5, $skipRangeEnd5), range($skipRangeStart6, $skipRangeEnd6), range($skipRangeStart7, $skipRangeEnd7));

        foreach ($groupedDataByAge as $key => $groupedAgeData) {
            // Skip rows for kasusu lama
            while (in_array($row, $skipRowsCombined)) {
                $row++; // Skip to the next row
            }

            // Write data for age and gender
            $this->writeAgeDataToExcel($sheet, $row, $groupedAgeData, $columns);
            $this->writeGenderDataToExcel($sheet, $row, $groupedDataByGender[$key]['barus'], $groupedDataByGender[$key]['lamas'], $groupedDataByGender[$key]['totalBaru'], $groupedDataByGender[$key]['totalLama']);

            // Increment row after writing data
            $row++;
        }

        // Stream the Excel file to user
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'laporan-formulir12.xlsx');
    }

    public function reportJamkesda(Request $request)
    {
        $bulanMap = [
            1 => 'JANUARI',
            2 => 'FEBRUARI',
            3 => 'MARET',
            4 => 'APRIL',
            5 => 'MEI',
            6 => 'JUNI',
            7 => 'JULI',
            8 => 'AGUSTUS',
            9 => 'SEPTEMBER',
            10 => 'OKTOBER',
            11 => 'NOVEMBER',
            12 => 'DESEMBER',
        ];

        $angkaBulan = (int) $request->input('bulan');
        $bulan = $bulanMap[$angkaBulan] ?? 'Bulan Tidak Dikenal';
        $tahun = $request->tahun;
        $tanggal = Carbon::now()->translatedFormat('j F Y');

        $templatePath = public_path('assets/report/report-jamkesda.xlsx');
        if (!file_exists($templatePath)) {
            abort(404, 'Template Excel tidak ditemukan.');
        }

        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A9', 'BULAN ' . $bulan . ' TAHUN ' . $tahun);

        $kunjunganData = Kunjungan::whereMonth('tanggal', $angkaBulan)
            ->whereYear('tanggal', $tahun)
            ->whereHas('patient', function ($query) {
                $query->where('jenis_kartu', 'jkd');
            })
            ->with(['patient:id,name,dob,gender,nik,address,jenis_kartu'])
            ->get();

        $row = 12;
        $no = 1;

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        foreach ($kunjunganData as $data) {
            $patient = $data->patient;

            if (!$patient || empty($patient->name) || empty($patient->dob) || empty($patient->nik) || empty($patient->address) || !isset($patient->gender) || empty($data->tanggal) || empty($data->poli)) {
                continue;
            }

            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", Carbon::parse($data->tanggal)->format('d-m-Y'));
            $sheet->setCellValue("C{$row}", $patient->name);
            $sheet->setCellValue("D{$row}", Carbon::parse($patient->dob)->age . ' thn');
            $sheet->setCellValue("E{$row}", $patient->gender == 1 ? 'Perempuan' : 'Laki-laki');

            // Format NIK sebagai teks
            $sheet
                ->getStyle("F{$row}")
                ->getNumberFormat()
                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $sheet->setCellValueExplicit("F{$row}", $patient->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

            $sheet->setCellValue("G{$row}", $patient->address);

            $poliLabel = match ($data->poli) {
                'poli-umum' => 'Poli Umum',
                'poli-kb' => 'Poli KB',
                'poli-kia' => 'Poli KIA',
                'ruang-tindakan' => 'UGD',
                'tindakan' => 'Tindakan',
                default => 'Poli Gigi',
            };
            $sheet->setCellValue("H{$row}", $poliLabel);
            $sheet->setCellValue("I{$row}", ''); // Kolom KET

            $sheet->getStyle("A{$row}:I{$row}")->applyFromArray($borderStyle);

            $row++;
            $no++;
        }

        // Tanda tangan dinamis
        $tandaTanganRow = $row + 2;
        $sheet->setCellValue('D' . ($tandaTanganRow + 1), "Makassar, {$tanggal}");
        $sheet->setCellValue('D' . ($tandaTanganRow + 2), 'Mengetahui,');
        $sheet->setCellValue('D' . ($tandaTanganRow + 3), 'Kepala UPT Puskesmas Tamangapa');
        $sheet->setCellValue('D' . ($tandaTanganRow + 5), 'dr. Fatimah M.Kes');
        $sheet->setCellValue('D' . ($tandaTanganRow + 6), 'NIP.198511252011012009');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'laporan-rawat-jalan-jamkesda.xlsx');
    }
    public function reportUspro(Request $request)
    {
        $bulanMap = [
            1 => 'JANUARI',
            2 => 'FEBRUARI',
            3 => 'MARET',
            4 => 'APRIL',
            5 => 'MEI',
            6 => 'JUNI',
            7 => 'JULI',
            8 => 'AGUSTUS',
            9 => 'SEPTEMBER',
            10 => 'OKTOBER',
            11 => 'NOVEMBER',
            12 => 'DESEMBER',
        ];

        $angkaBulan = (int) $request->input('bulan');
        $bulan = $bulanMap[$angkaBulan] ?? 'Bulan Tidak Dikenal';
        $tahun = $request->tahun;
        $tanggal = Carbon::now()->translatedFormat('j F Y');

        $templatePath = public_path('assets/report/report-uspro.xlsx');
        if (!file_exists($templatePath)) {
            abort(404, 'Template Excel tidak ditemukan.');
        }

        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A9', 'BULAN ' . $bulan . ' TAHUN ' . $tahun);

        $kunjunganData = Kunjungan::whereMonth('tanggal', $angkaBulan)
            ->whereYear('tanggal', $tahun)
            ->whereHas('patient', function ($query) {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 15 AND 59');
            })
            ->with(['patient:id,name,dob,gender,nik,address'])
            ->get();
        $patientIds = $kunjunganData->pluck('patient.id')->filter()->unique()->values();

        // Hitung jumlah kunjungan untuk setiap pasien dalam satu query
        $kunjunganCounts = Kunjungan::whereIn('pasien', $patientIds)->select('pasien', DB::raw('COUNT(*) as total'))->groupBy('pasien')->pluck('total', 'pasien');
        $row = 12;
        $no = 1;

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        foreach ($kunjunganData as $data) {
            $patient = $data->patient;

            if (!$patient || empty($patient->name) || empty($patient->dob) || empty($patient->nik) || empty($patient->address) || !isset($patient->gender) || empty($data->tanggal) || empty($data->poli)) {
                continue;
            }

            $action = Action::where('id_patient', $patient->id)->whereDate('tanggal', $data->tanggal)->first();

            $diagnosa = '-';
            if ($action) {
                $rawDiagnosa = $action->diagnosa;

                if (is_string($rawDiagnosa)) {
                    $diagnosaIds = json_decode($rawDiagnosa, true);
                } elseif (is_array($rawDiagnosa)) {
                    $diagnosaIds = $rawDiagnosa;
                } else {
                    $diagnosaIds = [];
                }

                $diagnosaIds = array_map('intval', $diagnosaIds);
                $diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();
                $diagnosa = !empty($diagnoses) ? implode(', ', $diagnoses) : '-';
            }

            $kunjunganCount = $kunjunganCounts[$patient->id] ?? 0;
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", Carbon::parse($data->tanggal)->format('d-m-Y'));
            $sheet->setCellValue("C{$row}", $patient->name);
            $sheet
                ->getStyle("D{$row}")
                ->getNumberFormat()
                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $sheet->setCellValueExplicit("D{$row}", $patient->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue("E{$row}", Carbon::parse($patient->dob)->format('d-m-Y'));
            $sheet->setCellValue("F{$row}", Carbon::parse($patient->dob)->age . ' thn');
            $sheet->setCellValue("G{$row}", $patient->gender == 1 ? 'Perempuan' : 'Laki-laki');
            $sheet->setCellValue("H{$row}", $patient->address);
            $sheet->setCellValue("I{$row}", $diagnosa);
            $sheet->setCellValue("J{$row}", $kunjunganCount == 1 ? 'Baru' : 'Lama');

            $sheet->getStyle("A{$row}:J{$row}")->applyFromArray($borderStyle);

            $row++;
            $no++;
        }

        // Tanda tangan dinamis
        $tandaTanganRow = $row + 2;
        $sheet->setCellValue('D' . ($tandaTanganRow + 1), "Makassar, {$tanggal}");
        $sheet->setCellValue('D' . ($tandaTanganRow + 2), 'Mengetahui,');
        $sheet->setCellValue('D' . ($tandaTanganRow + 3), 'Kepala UPT Puskesmas Tamangapa');
        $sheet->setCellValue('D' . ($tandaTanganRow + 5), 'dr. Fatimah M.Kes');
        $sheet->setCellValue('D' . ($tandaTanganRow + 6), 'NIP.198511252011012009');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'laporan-usia-produktif.xlsx');
    }
    public function reportPanduHipertensi(Request $request)
    {
        $bulanMap = [
            1 => 'JANUARI',
            2 => 'FEBRUARI',
            3 => 'MARET',
            4 => 'APRIL',
            5 => 'MEI',
            6 => 'JUNI',
            7 => 'JULI',
            8 => 'AGUSTUS',
            9 => 'SEPTEMBER',
            10 => 'OKTOBER',
            11 => 'NOVEMBER',
            12 => 'DESEMBER',
        ];

        $angkaBulan = (int) $request->input('bulan');
        $bulan = $bulanMap[$angkaBulan] ?? 'Bulan Tidak Dikenal';
        $tahun = $request->tahun;
        $tanggal = Carbon::now()->translatedFormat('j F Y');

        $templatePath = public_path('assets/report/report-pandu-hipertensi.xlsx');
        if (!file_exists($templatePath)) {
            abort(404, 'Template Excel tidak ditemukan.');
        }

        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A9', 'BULAN ' . $bulan . ' TAHUN ' . $tahun);

        $kunjunganData = Kunjungan::whereMonth('tanggal', $angkaBulan)
            ->whereYear('tanggal', $tahun)
            ->whereHas('patient')
            ->with(['patient:id,name,dob,gender,nik,address,jenis_kartu'])
            ->get();
        $patientIds = $kunjunganData->pluck('patient.id')->filter()->unique()->values();

        // Hitung jumlah kunjungan untuk setiap pasien dalam satu query
        $kunjunganCounts = Kunjungan::whereIn('pasien', $patientIds)->select('pasien', DB::raw('COUNT(*) as total'))->groupBy('pasien')->pluck('total', 'pasien');
        $row = 12;
        $no = 1;

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $targetDiagnosaId = [811, 810, 718];

        foreach ($kunjunganData as $data) {
            $patient = $data->patient;

            if (!$patient || empty($patient->name) || empty($patient->dob) || empty($patient->nik) || empty($patient->address) || !isset($patient->gender) || empty($data->tanggal) || empty($data->poli)) {
                continue;
            }

            $action = Action::where('id_patient', $patient->id)->whereDate('tanggal', $data->tanggal)->first();

            // Lewati jika tidak ada action atau tidak ada diagnosa 600
            if (!$action || !$action->diagnosa) {
                continue;
            }

            // Parse diagnosa
            if (is_string($action->diagnosa)) {
                $diagnosaIds = json_decode($action->diagnosa, true);
            } elseif (is_array($action->diagnosa)) {
                $diagnosaIds = $action->diagnosa;
            } else {
                $diagnosaIds = [];
            }

            $diagnosaIds = array_map('intval', $diagnosaIds);

            if (empty(array_intersect($targetDiagnosaId, $diagnosaIds))) {
                continue;
            }

            $diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();
            $diagnosa = !empty($diagnoses) ? implode(', ', $diagnoses) : '-';

            $kunjunganCount = $kunjunganCounts[$patient->id] ?? 0;
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", Carbon::parse($data->tanggal)->format('d-m-Y'));
            $sheet->setCellValue("C{$row}", $patient->name);
            $sheet
                ->getStyle("D{$row}")
                ->getNumberFormat()
                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $sheet->setCellValueExplicit("D{$row}", $patient->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue("E{$row}", Carbon::parse($patient->dob)->format('d-m-Y'));
            $sheet->setCellValue("F{$row}", Carbon::parse($patient->dob)->age . ' thn');
            $sheet->setCellValue("G{$row}", $patient->gender == 1 ? 'Perempuan' : 'Laki-laki');
            $sheet->setCellValue("H{$row}", $patient->address);
            $sheet->setCellValue("I{$row}", $diagnosa);
            $sheet->setCellValue("J{$row}", $kunjunganCount == 1 ? 'Baru' : 'Lama');

            $sheet->getStyle("A{$row}:J{$row}")->applyFromArray($borderStyle);

            $row++;
            $no++;
        }

        // Tanda tangan dinamis
        $tandaTanganRow = $row + 2;
        $sheet->setCellValue('D' . ($tandaTanganRow + 1), "Makassar, {$tanggal}");
        $sheet->setCellValue('D' . ($tandaTanganRow + 2), 'Mengetahui,');
        $sheet->setCellValue('D' . ($tandaTanganRow + 3), 'Kepala UPT Puskesmas Tamangapa');
        $sheet->setCellValue('D' . ($tandaTanganRow + 5), 'dr. Fatimah M.Kes');
        $sheet->setCellValue('D' . ($tandaTanganRow + 6), 'NIP.198511252011012009');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'laporan-pandu-ptm-hipertensi.xlsx');
    }
    public function reportPanduDiabetes(Request $request)
    {
        $bulanMap = [
            1 => 'JANUARI',
            2 => 'FEBRUARI',
            3 => 'MARET',
            4 => 'APRIL',
            5 => 'MEI',
            6 => 'JUNI',
            7 => 'JULI',
            8 => 'AGUSTUS',
            9 => 'SEPTEMBER',
            10 => 'OKTOBER',
            11 => 'NOVEMBER',
            12 => 'DESEMBER',
        ];

        $angkaBulan = (int) $request->input('bulan');
        $bulan = $bulanMap[$angkaBulan] ?? 'Bulan Tidak Dikenal';
        $tahun = $request->tahun;
        $tanggal = Carbon::now()->translatedFormat('j F Y');

        $templatePath = public_path('assets/report/report-pandu-diabetes.xlsx');
        if (!file_exists($templatePath)) {
            abort(404, 'Template Excel tidak ditemukan.');
        }

        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A9', 'BULAN ' . $bulan . ' TAHUN ' . $tahun);

        $kunjunganData = Kunjungan::whereMonth('tanggal', $angkaBulan)
            ->whereYear('tanggal', $tahun)
            ->whereHas('patient')
            ->with(['patient:id,name,dob,gender,nik,address,jenis_kartu'])
            ->get();
        $patientIds = $kunjunganData->pluck('patient.id')->filter()->unique()->values();

        // Hitung jumlah kunjungan untuk setiap pasien dalam satu query
        $kunjunganCounts = Kunjungan::whereIn('pasien', $patientIds)->select('pasien', DB::raw('COUNT(*) as total'))->groupBy('pasien')->pluck('total', 'pasien');
        $row = 12;
        $no = 1;

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $targetDiagnosaId = [667,668];

        foreach ($kunjunganData as $data) {
            $patient = $data->patient;

            if (!$patient || empty($patient->name) || empty($patient->dob) || empty($patient->nik) || empty($patient->address) || !isset($patient->gender) || empty($data->tanggal) || empty($data->poli)) {
                continue;
            }

            $action = Action::where('id_patient', $patient->id)->whereDate('tanggal', $data->tanggal)->first();

            // Lewati jika tidak ada action atau tidak ada diagnosa 600
            if (!$action || !$action->diagnosa) {
                continue;
            }

            // Parse diagnosa
            if (is_string($action->diagnosa)) {
                $diagnosaIds = json_decode($action->diagnosa, true);
            } elseif (is_array($action->diagnosa)) {
                $diagnosaIds = $action->diagnosa;
            } else {
                $diagnosaIds = [];
            }

            $diagnosaIds = array_map('intval', $diagnosaIds);

            if (empty(array_intersect($targetDiagnosaId, $diagnosaIds))) {
                continue;
            }

            $diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();
            $diagnosa = !empty($diagnoses) ? implode(', ', $diagnoses) : '-';

            $kunjunganCount = $kunjunganCounts[$patient->id] ?? 0;
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", Carbon::parse($data->tanggal)->format('d-m-Y'));
            $sheet->setCellValue("C{$row}", $patient->name);
            $sheet
                ->getStyle("D{$row}")
                ->getNumberFormat()
                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $sheet->setCellValueExplicit("D{$row}", $patient->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue("E{$row}", Carbon::parse($patient->dob)->format('d-m-Y'));
            $sheet->setCellValue("F{$row}", Carbon::parse($patient->dob)->age . ' thn');
            $sheet->setCellValue("G{$row}", $patient->gender == 1 ? 'Perempuan' : 'Laki-laki');
            $sheet->setCellValue("H{$row}", $patient->address);
            $sheet->setCellValue("I{$row}", $diagnosa);
            $sheet->setCellValue("J{$row}", $kunjunganCount == 1 ? 'Baru' : 'Lama');

            $sheet->getStyle("A{$row}:J{$row}")->applyFromArray($borderStyle);

            $row++;
            $no++;
        }

        // Tanda tangan dinamis
        $tandaTanganRow = $row + 2;
        $sheet->setCellValue('D' . ($tandaTanganRow + 1), "Makassar, {$tanggal}");
        $sheet->setCellValue('D' . ($tandaTanganRow + 2), 'Mengetahui,');
        $sheet->setCellValue('D' . ($tandaTanganRow + 3), 'Kepala UPT Puskesmas Tamangapa');
        $sheet->setCellValue('D' . ($tandaTanganRow + 5), 'dr. Fatimah M.Kes');
        $sheet->setCellValue('D' . ($tandaTanganRow + 6), 'NIP.198511252011012009');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'laporan-pandu-ptm-diabetes.xlsx');
    }

    // Helper functions for grouped data
    private function getGroupedData($diagnosaValue, $bulan, $tahun)
    {
        $data = Action::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->filter(function ($action) use ($diagnosaValue) {
                return is_array($action->diagnosa) && !empty(array_intersect($diagnosaValue, $action->diagnosa));
            });

        return [
            'kasusBaru' => $data->where('kasus', 1),
            'kasusLama' => $data->where('kasus', 0),
        ];
    }
    private function getGroupedDataAll($diagnosaValue, $bulan, $tahun)
    {
        $data = Action::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->filter(function ($action) use ($diagnosaValue) {
                return is_array($action->diagnosa) && !empty(array_intersect($diagnosaValue, $action->diagnosa));
            });

        return $data;
    }

    private function groupByAge($actions)
    {
        return $actions
            ->groupBy(function ($action) {
                $dob = Carbon::parse($action->patient->dob);
                $age = Carbon::now()->diffInDays($dob);

                if ($age <= 7) {
                    return '0-7 hari';
                } elseif ($age <= 28) {
                    return '8-28 hari';
                } elseif ($age <= 336) {
                    return '1-11 bulan';
                } elseif ($age <= 1460) {
                    return '1-4 thn';
                } elseif ($age <= 3285) {
                    return '5-9 thn';
                } elseif ($age <= 5110) {
                    return '10-14 thn';
                } elseif ($age <= 6935) {
                    return '15-19 thn';
                } elseif ($age <= 16130) {
                    return '20-44 thn';
                } elseif ($age <= 21590) {
                    return '45-59 thn';
                }
                return '>59 thn';
            })
            ->map->count();
    }
    private function groupByAgeAll($actions)
    {
        return $actions
            ->groupBy(function ($action) {
                $dob = Carbon::parse($action->patient->dob);
                $age = Carbon::now()->diffInDays($dob);

                if ($age <= 7) {
                    return '0-7 hari';
                } elseif ($age <= 28) {
                    return '8-28 hari';
                } elseif ($age <= 336) {
                    return '1-11 bulan';
                } elseif ($age <= 1460) {
                    return '1-4 thn';
                } elseif ($age <= 3285) {
                    return '5-9 thn';
                } elseif ($age <= 5110) {
                    return '10-14 thn';
                } elseif ($age <= 6935) {
                    return '15-19 thn';
                } elseif ($age <= 16130) {
                    return '20-44 thn';
                } elseif ($age <= 19710) {
                    return '45-54 thn';
                } elseif ($age <= 21590) {
                    return '55-59 thn';
                } elseif ($age <= 25220) {
                    return '60-69 thn';
                } else {
                    return '>70 thn';
                }
            })
            ->map->count();
    }

    private function getTotalByGender($actions)
    {
        return $actions
            ->groupBy(function ($action) {
                return $action->patient->gender;
            })
            ->map(function ($group) {
                return $group->count();
            });
    }

    // Excel Writing functions
    private function writeAgeDataToExcel($sheet, $row, $groupedData, $columns)
    {
        foreach ($groupedData as $ageRange => $totalCases) {
            if (isset($columns[$ageRange])) {
                $sheet->setCellValue($columns[$ageRange] . $row, $totalCases);
            }
        }
    }

    private function writeGenderDataToExcel($sheet, $row, $totalKasusBaruPerGender, $totalKasusLamaPerGender, $totalKasusBaru, $totalKasusLama)
    {
        $sheet->setCellValue('N' . $row, $totalKasusBaruPerGender['2'] ?? 0);
        $sheet->setCellValue('O' . $row, $totalKasusBaruPerGender['1'] ?? 0);
        $sheet->setCellValue('Q' . $row, $totalKasusLamaPerGender['2'] ?? 0);
        $sheet->setCellValue('R' . $row, $totalKasusLamaPerGender['1'] ?? 0);
        $sheet->setCellValue('P' . $row, $totalKasusBaru);
        $sheet->setCellValue('S' . $row, $totalKasusLama);
    }
    private function writeGenderDataToExcelStp($sheet, $row, $totalKasusPerGender)
    {
        $sheet->setCellValue('O' . $row, $totalKasusPerGender['2'] ?? 0);
        $sheet->setCellValue('P' . $row, $totalKasusPerGender['1'] ?? 0);
    }

    public function reportLR(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $rujukanQuery = Action::select('rujuk_rs', DB::raw('COUNT(*) as count'))->where('rujuk_rs', '!=', '1');

        if ($bulan && $tahun) {
            $rujukanQuery->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        }

        $rujukan = $rujukanQuery->groupBy('rujuk_rs')->orderByDesc('count')->get();

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
            'patients.jenis_kartu as payment_method', // Menggunakan alias agar lebih jelas
        )
            ->join('patients', 'patients.id', '=', 'actions.id_patient')
            ->where('actions.rujuk_rs', '!=', '1');

        if ($bulan && $tahun) {
            $actionsQuery->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
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
            if (!is_array($diagnosisIds)) {
                continue;
            }

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
                            'pbi' => 0,
                            'askes' => 0,
                            'jkn_mandiri' => 0,
                            'umum' => 0,
                            'jkd' => 0,
                        ],
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
                'jkd' => array_sum(array_column(array_column($topDiagnoses, 'payments'), 'jkd')),
            ],
            'hospitals' => array_fill_keys($hospitalColumns, 0),
        ];

        foreach ($hospitalColumns as $hospital) {
            $totalRow['hospitals'][$hospital] = array_sum(array_column(array_column($topDiagnoses, 'hospitals'), $hospital));
        }

        // Tambahkan total ke hasil akhir
        $topDiagnoses[] = $totalRow;

        return view('content.report.laporan-lr', compact('rujukan', 'topDiagnoses', 'bulan', 'tahun', 'hospitalColumns'));
    }
}
