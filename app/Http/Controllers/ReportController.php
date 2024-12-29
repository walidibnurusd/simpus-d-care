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
    public function reportPTM()
    {
        return view('content.report.laporan-ptm');
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
