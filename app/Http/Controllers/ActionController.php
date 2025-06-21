<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\ActionObat;
use App\Models\Diagnosis;
use App\Models\Disease;
use App\Models\Poli;
use App\Models\SatuSehatEncounter;
use App\Models\TerimaObat;
use App\Helpers\SatuSehatHelper;
use App\Models\User;
use App\Models\Hospital;
use App\Models\Patients;
use App\Models\Kunjungan;
use App\Models\HasilLab;
use App\Models\Obat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class ActionController extends Controller
{
    public function index(Request $request)
    {
        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::all();
        $penyakit = Disease::all();
        $rs = Hospital::all();
        $routeName = $request->route()->getName();
        $obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();

        return view('content.action.index', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName', 'obats'));
    }

    public function indexUgd(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
            $endDate = $request->input('end_date') ?? Carbon::today()->toDateString();

            $actionsQuery = Action::with(['patient', 'hospitalReferral'])->where('tipe', 'ruang-tindakan'); // Ensure 'diagnosa' is not null

            $actionsQuery->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate);

            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            // $actions = $actionsQuery->get();

            return DataTables::of($actionsQuery)
                ->addIndexColumn()
                ->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
                ->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
                ->addColumn('patient_name', fn($row) => optional($row->patient)->name)
                ->addColumn('kartu', fn($row) => optional($row->patient)->jenis_kartu)
                ->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
                ->addColumn('diagnosa', function ($row) {
                    $diagnosa = $row->diagnosa;

                    if (is_string($diagnosa)) {
                        $diagnosaIds = json_decode($diagnosa, true);
                    } elseif (is_array($diagnosa)) {
                        $diagnosaIds = $diagnosa;
                    } else {
                        return '-';
                    }

                    $diagnosaIds = array_map('intval', $diagnosaIds);
                    $diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();

                    return !empty($diagnoses) ? implode(', ', $diagnoses) : '-';
                })
                ->addColumn('kunjungan', function ($row) {
                    $kunjunganCount = Kunjungan::where('pasien', $row->id_patient)->count();

                    return $kunjunganCount == 1 ? 'Baru' : 'Lama';
                })
                ->addColumn('action', function ($row) {
                    // Get the doctor list
                    $rs = Hospital::all();
                    $dokter = User::where('role', 'dokter')->get();
                    $routeName = request()->route()->getName();
                    $obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();

                    // Render modal edit with route name
                    $editModal = view('component.modal-edit-action', ['rs' => $rs, 'action' => $row, 'routeName' => $routeName, 'dokter' => $dokter, 'obats' => $obats])->render();

                    return '<div class="action-buttons">
                                <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editActionModal' .
                        $row->id .
                        '">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="' .
                        route('action.destroy', $row->id) .
                        '" method="POST" class="d-inline">
                                    ' .
                        csrf_field() .
                        method_field('DELETE') .
                        '
                                    <button type="submit" class="btn btn-danger btn-sm text-white" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>' .
                        $editModal;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::all();
        $penyakit = Disease::all();
        $rs = Hospital::all();
        $routeName = $request->route()->getName();
        $obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();

        return view('content.action.index', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName', 'obats'));
    }
    public function indexDokter(Request $request)
    {
		$dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::all();
        $penyakit = Disease::all();
        $rs = Hospital::all();
        $poli = Poli::all();
        $obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();

        $routeName = $request->route()->getName();

        if ($request->ajax()) {
            $startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
            $endDate = $request->input('end_date') ?? Carbon::today()->toDateString();

            $actionsQuery = Action::with(['patient', 'hospitalReferral', 'hasilLab', 'actionObats.obat'])
                ->where('tipe', 'poli-umum')
                ->whereNotNull('diagnosa_primer');

            $actionsQuery->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate);

            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
                ->addIndexColumn()
                ->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
                ->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
                ->addColumn('patient_name', fn($row) => optional($row->patient)->name)
                ->addColumn('kartu', fn($row) => optional($row->patient)->jenis_kartu)
                ->addColumn('obat', function ($row) {
                    $doctorRole = 'dokter';

                    if ($row->actionObats->isNotEmpty()) {
                        $medications = $row->actionObats
                            ->filter(function ($ao) use ($doctorRole) {
                                return $ao->created_by == $doctorRole || $ao->created_by == null;
                            })
                            ->map(function ($ao) {
                                return optional($ao->obat)->name;
                            })
                            ->filter()
                            ->implode(', ');

                        return $medications ?: '-';
                    }

                    return '-';
                })
                ->addColumn('update_obat', function ($row) {
                    $apotikRole = 'apotik';

                    if ($row->actionObats->isNotEmpty()) {
                        $medications = $row->actionObats
                            ->filter(function ($ao) use ($apotikRole) {
                                return $ao->created_by == $apotikRole;
                            })
                            ->map(function ($ao) {
                                return optional($ao->obat)->name;
                            })
                            ->filter()
                            ->implode(', ');

                        return $medications ?: '-';
                    }

                    return '-';
                })
                ->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
                ->addColumn('diagnosa', function ($row) {
                    $diagnosa = $row->diagnosa;

                    if (is_string($diagnosa)) {
                        $diagnosaIds = json_decode($diagnosa, true);
                    } elseif (is_array($diagnosa)) {
                        $diagnosaIds = $diagnosa;
                    } else {
                        return '-';
                    }

                    $diagnosaIds = array_map('intval', $diagnosaIds);
                    $diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();

                    return !empty($diagnoses) ? implode(', ', $diagnoses) : '-';
                })
                ->addColumn('diagnosa_primer', function ($row) {
                    $diagnosaId = $row->diagnosa_primer;

                    $diagnosa = Diagnosis::where('id', $diagnosaId)->first();

                    return !empty($diagnosa) ? $diagnosa->name : '-';
                })
                ->addColumn('kunjungan', function ($row) {
                    $kunjunganCount = Kunjungan::where('pasien', $row->id_patient)->count();

                    return $kunjunganCount == 1 ? 'Baru' : 'Lama';
                })
                ->addColumn('hasil_lab', function ($row) use($dokter, $routeName) {
                    if ($row->hasilLab) {
                        $editModal = view('component.modal-edit-action-lab', [
                            'action' => $row,
                            'routeName' => $routeName,
                            'dokter' => $dokter,
                        ])->render();

                        return '<div class="action-buttons">
                    <button type="button" class="btn btn-success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editActionModalLab' .
                            $row->id .
                            '">
                        Hasil
                    </button>
                    <form action="' .
                            route('action.destroy', $row->id) .
                            '" method="POST" class="d-inline">
                        ' .
                            csrf_field() .
                            '
                        ' .
                            $editModal .
                            '
                    </form>
                </div>';
                    } else {
                        return '-'; // Jika tidak ada hasil lab, tampilkan tanda minus atau pesan lain
                    }
                })

                ->addColumn('kunjungan', function ($row) {
                    $kunjunganCount = Kunjungan::where('pasien', $row->id_patient)->count();

                    return $kunjunganCount == 1 ? 'Baru' : 'Lama';
                })

                ->addColumn('action', function ($row) use($dokter, $rs, $routeName, $obats) {
                    $editModal = view('component.modal-edit-action', ['action' => $row, 'routeName' => $routeName, 'dokter' => $dokter, 'rs' => $rs, 'obats' => $obats])->render();
                    return '<div class="action-buttons">
                                <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editActionModal' .
                        $row->id .
                        '">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="' .
                        route('action.destroy', $row->id) .
                        '" method="POST" class="d-inline">
                                    ' .
                        csrf_field() .
                        method_field('DELETE') .
                        '
                                    <button type="submit" class="btn btn-danger btn-sm text-white" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>' .
                        $editModal;
                })

                ->rawColumns(['action', 'hasil_lab'])
                ->make(true);
        }
        return view('content.action.index-dokter', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName', 'obats', 'poli'));
    }
    public function indexGigiDokter(Request $request)
    {
		// For the non-AJAX case, provide the necessary data for the view
        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::all();
        $penyakit = Disease::all();
        $rs = Hospital::all();
        $routeName = $request->route()->getName();
        $poli = Poli::all();
        $obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();

        if ($request->ajax()) {
            $startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
            $endDate = $request->input('end_date') ?? Carbon::today()->toDateString();

            $actionsQuery = Action::with(['patient', 'hospitalReferral', 'hasilLab', 'actionObats.obat'])
                ->where('tipe', 'poli-gigi') // Adjust the type to 'poli-gigi'
                ->whereNotNull('diagnosa_primer'); // Ensure 'diagnosa' is not null

            $actionsQuery->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate);

            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
                ->addIndexColumn()
                ->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
                ->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
                ->addColumn('patient_name', fn($row) => optional($row->patient)->name)
                ->addColumn('kartu', fn($row) => optional($row->patient)->jenis_kartu)
                ->addColumn('obat', function ($row) {
                    $doctorRole = 'dokter';

                    if ($row->actionObats->isNotEmpty()) {
                        $medications = $row->actionObats
                            ->filter(function ($ao) use ($doctorRole) {
                                return $ao->created_by == $doctorRole || $ao->created_by == null;
                            })
                            ->map(function ($ao) {
                                return optional($ao->obat)->name;
                            })
                            ->filter()
                            ->implode(', ');

                        return $medications ?: '-';
                    }

                    return '-';
                })
                ->addColumn('update_obat', function ($row) {
                    $apotikRole = 'apotik';

                    if ($row->actionObats->isNotEmpty()) {
                        $medications = $row->actionObats
                            ->filter(function ($ao) use ($apotikRole) {
                                return $ao->created_by == $apotikRole;
                            })
                            ->map(function ($ao) {
                                return optional($ao->obat)->name;
                            })
                            ->filter()
                            ->implode(', ');

                        return $medications ?: '-';
                    }

                    return '-';
                })
                ->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
                ->addColumn('diagnosa', function ($row) {
                    $diagnosa = $row->diagnosa;

                    if (is_string($diagnosa)) {
                        $diagnosaIds = json_decode($diagnosa, true);
                    } elseif (is_array($diagnosa)) {
                        $diagnosaIds = $diagnosa;
                    } else {
                        return '-';
                    }

                    $diagnosaIds = array_map('intval', $diagnosaIds);
                    $diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();

                    return !empty($diagnoses) ? implode(', ', $diagnoses) : '-';
                })
                ->addColumn('diagnosa_primer', function ($row) {
                    $diagnosaId = $row->diagnosa_primer;

                    $diagnosa = Diagnosis::where('id', $diagnosaId)->first();

                    return !empty($diagnosa) ? $diagnosa->name : '-';
                })
                ->addColumn('kunjungan', function ($row) {
                    $kunjunganCount = Kunjungan::where('pasien', $row->id_patient)->count();

                    return $kunjunganCount == 1 ? 'Baru' : 'Lama';
                })
                ->addColumn('status_satu_sehat', function ($row) {
                    $status = $row->status_satu_sehat;

                    return $status == 1 ? 'Berhasil' : 'Belum';
                })
                ->addColumn('hasil_lab', function ($row) {
                    if ($row->hasilLab) {
                        $dokter = User::where('role', 'dokter')->get();
                        $routeName = request()->route()->getName();
                        $editModal = view('component.modal-edit-action-lab', [
                            'action' => $row,
                            'routeName' => $routeName,
                            'dokter' => $dokter,
                        ])->render();

                        return '<div class="action-buttons">
                    <button type="button" class="btn btn-success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editActionModalLab' .
                            $row->id .
                            '">
                        Hasil
                    </button>
                    <form action="' .
                            route('action.destroy', $row->id) .
                            '" method="POST" class="d-inline">
                        ' .
                            csrf_field() .
                            '
                        ' .
                            $editModal .
                            '
                    </form>
                </div>';
                    } else {
                        return '-'; // Jika tidak ada hasil lab, tampilkan tanda minus atau pesan lain
                    }
                })

                ->addColumn('action', function ($row) use($rs, $dokter, $routeName, $obats) {
                    $editModal = view('component.modal-edit-action', ['rs' => $rs, 'action' => $row, 'routeName' => $routeName, 'dokter' => $dokter, 'obats' => $obats])->render();

                    return '<div class="action-buttons">
                                <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editActionModal' .
                        $row->id .
                        '">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="' .
                        route('action.destroy', $row->id) .
                        '" method="POST" class="d-inline">
                                    ' .
                        csrf_field() .
                        method_field('DELETE') .
                        '
                                    <button type="submit" class="btn btn-danger btn-sm text-white" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>' .
                        $editModal;
                })
                ->rawColumns(['action', 'hasil_lab'])
                ->make(true);
        }
        return view('content.action.index-dokter', compact('dokter', 'penyakit', 'rs', 'obats', 'diagnosa', 'routeName', 'poli'));
    }
    public function indexUgdDokter(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
            $endDate = $request->input('end_date') ?? Carbon::today()->toDateString();

            $actionsQuery = Action::with(['patient', 'hospitalReferral', 'hasilLab', 'actionObats.obat'])
                ->where('tipe', 'ruang-tindakan')
                ->whereNotNull('tindakan');

            $actionsQuery->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate);
            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
                ->addIndexColumn()
                ->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
                ->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
                ->addColumn('patient_name', fn($row) => optional($row->patient)->name)
                ->addColumn('kartu', fn($row) => optional($row->patient)->jenis_kartu)
                ->addColumn('obat', function ($row) {
                    $doctorRole = 'dokter';
                    $tindakanRole = 'tindakan';

                    if ($row->actionObats->isNotEmpty()) {
                        $medications = $row->actionObats
                            ->filter(function ($ao) use ($doctorRole, $tindakanRole) {
                                return $ao->created_by == $doctorRole || $ao->created_by == null || $ao->created_by == $tindakanRole;
                            })
                            ->map(function ($ao) {
                                return optional($ao->obat)->name;
                            })
                            ->filter()
                            ->implode(', ');

                        return $medications ?: '-';
                    }

                    return '-';
                })
                ->addColumn('update_obat', function ($row) {
                    $apotikRole = 'apotik';

                    if ($row->actionObats->isNotEmpty()) {
                        $medications = $row->actionObats
                            ->filter(function ($ao) use ($apotikRole) {
                                return $ao->created_by == $apotikRole;
                            })
                            ->map(function ($ao) {
                                return optional($ao->obat)->name;
                            })
                            ->filter()
                            ->implode(', ');

                        return $medications ?: '-';
                    }

                    return '-';
                })
                ->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
                ->addColumn('diagnosa', function ($row) {
                    $diagnosa = $row->diagnosa;

                    if (is_string($diagnosa)) {
                        $diagnosaIds = json_decode($diagnosa, true);
                    } elseif (is_array($diagnosa)) {
                        $diagnosaIds = $diagnosa;
                    } else {
                        return '-';
                    }

                    $diagnosaIds = array_map('intval', $diagnosaIds);
                    $diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();

                    return !empty($diagnoses) ? implode(', ', $diagnoses) : '-';
                })
                ->addColumn('diagnosa_primer', function ($row) {
                    $diagnosaId = $row->diagnosa_primer;

                    $diagnosa = Diagnosis::where('id', $diagnosaId)->first();

                    return !empty($diagnosa) ? $diagnosa->name : '-';
                })
                ->addColumn('kunjungan', function ($row) {
                    $kunjunganCount = Kunjungan::where('pasien', $row->id_patient)->count();

                    return $kunjunganCount == 1 ? 'Baru' : 'Lama';
                })
                ->addColumn('status_satu_sehat', function ($row) {
                    $status = $row->status_satu_sehat;

                    return $status == 1 ? 'Berhasil' : 'Belum';
                })
                ->addColumn('hasil_lab', function ($row) {
                    if ($row->hasilLab) {
                        $dokter = User::where('role', 'dokter')->get();
                        $routeName = request()->route()->getName();
                        $editModal = view('component.modal-edit-action-lab', [
                            'action' => $row,
                            'routeName' => $routeName,
                            'dokter' => $dokter,
                        ])->render();

                        return '<div class="action-buttons">
                    <button type="button" class="btn btn-success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editActionModalLab' .
                            $row->id .
                            '">
                        Hasil
                    </button>
                    <form action="' .
                            route('action.destroy', $row->id) .
                            '" method="POST" class="d-inline">
                        ' .
                            csrf_field() .
                            '
                        ' .
                            $editModal .
                            '
                    </form>
                </div>';
                    } else {
                        return '-'; // Jika tidak ada hasil lab, tampilkan tanda minus atau pesan lain
                    }
                })

                ->addColumn('action', function ($row) {
                    // Get the doctor list
                    $dokter = User::where('role', 'dokter')->get();
                    $routeName = request()->route()->getName();
                    $rs = Hospital::all();
                    $obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();
                    // Render modal edit with route name
                    $editModal = view('component.modal-edit-action', ['action' => $row, 'routeName' => $routeName, 'dokter' => $dokter, 'rs' => $rs, 'obats' => $obats])->render();

                    return '<div class="action-buttons">
                            <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editActionModal' .
                        $row->id .
                        '">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="' .
                        route('action.destroy', $row->id) .
                        '" method="POST" class="d-inline">
                                ' .
                        csrf_field() .
                        method_field('DELETE') .
                        '
                                <button type="submit" class="btn btn-danger btn-sm text-white" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>' .
                        $editModal;
                })
                ->rawColumns(['action', 'hasil_lab'])
                ->make(true);
        }

        // Non-AJAX request handling
        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::all();
        $penyakit = Disease::all();
        $rs = Hospital::all();
        $routeName = $request->route()->getName();
        $poli = Poli::all();
        $obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();

        return view('content.action.index-dokter', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName', 'obats', 'poli'));
    }
    public function indexRuangTindakanDokter(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
            $endDate = $request->input('end_date') ?? Carbon::today()->toDateString();

            $actionsQuery = Action::with(['patient', 'hospitalReferral', 'actionObats.obat'])->whereNotNull('tindakan_ruang_tindakan');

            $actionsQuery->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate);

            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
                ->addIndexColumn()
                ->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
                ->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
                ->addColumn('patient_name', fn($row) => optional($row->patient)->name)
                ->addColumn('kartu', fn($row) => optional($row->patient)->jenis_kartu)
                ->addColumn('obat', function ($row) {
                    $doctorRole = 'dokter';
                    $tindakanRole = 'tindakan';

                    if ($row->actionObats->isNotEmpty()) {
                        $medications = $row->actionObats
                            ->filter(function ($ao) use ($doctorRole, $tindakanRole) {
                                return $ao->created_by == $doctorRole || $ao->created_by == null || $ao->created_by == $tindakanRole;
                            })
                            ->map(function ($ao) {
                                return optional($ao->obat)->name;
                            })
                            ->filter()
                            ->implode(', ');

                        return $medications ?: '-';
                    }

                    return '-';
                })
                ->addColumn('update_obat', function ($row) {
                    $apotikRole = 'apotik';

                    if ($row->actionObats->isNotEmpty()) {
                        $medications = $row->actionObats
                            ->filter(function ($ao) use ($apotikRole) {
                                return $ao->created_by == $apotikRole;
                            })
                            ->map(function ($ao) {
                                return optional($ao->obat)->name;
                            })
                            ->filter()
                            ->implode(', ');

                        return $medications ?: '-';
                    }

                    return '-';
                })
                ->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
                ->addColumn('diagnosa', function ($row) {
                    $diagnosa = $row->diagnosa;

                    if (is_string($diagnosa)) {
                        $diagnosaIds = json_decode($diagnosa, true);
                    } elseif (is_array($diagnosa)) {
                        $diagnosaIds = $diagnosa;
                    } else {
                        return '-';
                    }

                    $diagnosaIds = array_map('intval', $diagnosaIds);
                    $diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();

                    return !empty($diagnoses) ? implode(', ', $diagnoses) : '-';
                })
                ->addColumn('diagnosa_primer', function ($row) {
                    $diagnosaId = $row->diagnosa_primer;

                    $diagnosa = Diagnosis::where('id', $diagnosaId)->first();

                    return !empty($diagnosa) ? $diagnosa->name : '-';
                })
                ->addColumn('kunjungan', function ($row) {
                    $kunjunganCount = Kunjungan::where('pasien', $row->id_patient)->count();

                    return $kunjunganCount == 1 ? 'Baru' : 'Lama';
                })
                ->addColumn('status_satu_sehat', function ($row) {
                    $status = $row->status_satu_sehat;

                    return $status == 1 ? 'Berhasil' : 'Belum';
                })
                ->addColumn('action', function ($row) {
                    // Get the doctor list
                    $dokter = User::where('role', 'dokter')->get();
                    $routeName = request()->route()->getName();
                    $rs = Hospital::all();
                    $obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();
                    // Render modal edit with route name
                    $editModal = view('component.modal-edit-action', ['action' => $row, 'routeName' => $routeName, 'dokter' => $dokter, 'rs' => $rs, 'obats' => $obats])->render();

                    return '<div class="action-buttons">
                            <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editActionModal' .
                        $row->id .
                        '">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="' .
                        route('action.destroy', $row->id) .
                        '" method="POST" class="d-inline">
                                ' .
                        csrf_field() .
                        method_field('DELETE') .
                        '
                                <button type="submit" class="btn btn-danger btn-sm text-white" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>' .
                        $editModal;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Non-AJAX request handling
        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::all();
        $penyakit = Disease::all();
        $rs = Hospital::all();
        $routeName = $request->route()->getName();
        $poli = Poli::all();
        $obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();

        return view('content.action.index-dokter', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName', 'obats', 'poli'));
    }
    public function indexLab(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $poli = $request->input('poli');

        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::all();

        $penyakit = Disease::all();
        $rs = Hospital::all();
        $actionsQuery = Action::with('hasilLab')
            ->whereNotNull('hasil_lab')
            ->orWhereHas('hasilLab', function ($q) {
                $q->whereNotNull('gdp')->orWhereNotNull('gdp_2_jam_pp')->orWhereNotNull('cholesterol')->orWhereNotNull('asam_urat')->orWhereNotNull('leukosit')->orWhereNotNull('eritrosit')->orWhereNotNull('trombosit')->orWhereNotNull('hemoglobin')->orWhereNotNull('sifilis')->orWhereNotNull('hiv')->orWhereNotNull('golongan_darah')->orWhereNotNull('widal')->orWhereNotNull('malaria')->orWhereNotNull('albumin')->orWhereNotNull('reduksi')->orWhereNotNull('urinalisa')->orWhereNotNull('tes_kehamilan')->orWhereNotNull('telur_cacing')->orWhereNotNull('bta')->orWhereNotNull('igm_dbd')->orWhereNotNull('igm_typhoid')->orWhereNotNull('tcm');
            });

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }
        if ($poli) {
            $actionsQuery->where('tipe', $poli);
        }

        $actions = $actionsQuery->orderBy('created_at', 'desc')->get();

        $routeName = $request->route()->getName();
        return view('content.action.index-lab', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }

    public function indexDokterKia(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
            $endDate = $request->input('end_date') ?? Carbon::today()->toDateString();

            $actionsQuery = Action::with(['patient', 'hospitalReferral', 'hasilLab', 'actionObats.obat'])
                ->where('tipe', 'poli-kia') // Filter by type for KIA
                ->whereNotNull('diagnosa_primer'); // Ensure diagnosa exists

            $actionsQuery->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate);
            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
                ->addIndexColumn()
                ->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
                ->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
                ->addColumn('patient_name', fn($row) => optional($row->patient)->name)
                ->addColumn('kartu', fn($row) => optional($row->patient)->jenis_kartu)
                ->addColumn('obat', function ($row) {
                    $doctorRole = 'dokter';

                    if ($row->actionObats->isNotEmpty()) {
                        $medications = $row->actionObats
                            ->filter(function ($ao) use ($doctorRole) {
                                return $ao->created_by == $doctorRole || $ao->created_by == null;
                            })
                            ->map(function ($ao) {
                                return optional($ao->obat)->name;
                            })
                            ->filter()
                            ->implode(', ');

                        return $medications ?: '-';
                    }

                    return '-';
                })
                ->addColumn('update_obat', function ($row) {
                    $apotikRole = 'apotik';

                    if ($row->actionObats->isNotEmpty()) {
                        $medications = $row->actionObats
                            ->filter(function ($ao) use ($apotikRole) {
                                return $ao->created_by == $apotikRole;
                            })
                            ->map(function ($ao) {
                                return optional($ao->obat)->name;
                            })
                            ->filter()
                            ->implode(', ');

                        return $medications ?: '-';
                    }

                    return '-';
                })
                ->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
                ->addColumn('diagnosa', function ($row) {
                    $diagnosa = $row->diagnosa;

                    if (is_string($diagnosa)) {
                        $diagnosaIds = json_decode($diagnosa, true);
                    } elseif (is_array($diagnosa)) {
                        $diagnosaIds = $diagnosa;
                    } else {
                        return '-';
                    }

                    $diagnosaIds = array_map('intval', $diagnosaIds);
                    $diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();

                    return !empty($diagnoses) ? implode(', ', $diagnoses) : '-';
                })
                ->addColumn('diagnosa_primer', function ($row) {
                    $diagnosaId = $row->diagnosa_primer;

                    $diagnosa = Diagnosis::where('id', $diagnosaId)->first();

                    return !empty($diagnosa) ? $diagnosa->name : '-';
                })
                ->addColumn('kunjungan', function ($row) {
                    $kunjunganCount = Kunjungan::where('pasien', $row->id_patient)->count();

                    return $kunjunganCount == 1 ? 'Baru' : 'Lama';
                })
                ->addColumn('status_satu_sehat', function ($row) {
                    $status = $row->status_satu_sehat;

                    return $status == 1 ? 'Berhasil' : 'Belum';
                })
                ->addColumn('hasil_lab', function ($row) {
                    if ($row->hasilLab) {
                        $dokter = User::where('role', 'dokter')->get();
                        $routeName = request()->route()->getName();
                        $editModal = view('component.modal-edit-action-lab', [
                            'action' => $row,
                            'routeName' => $routeName,
                            'dokter' => $dokter,
                        ])->render();

                        return '<div class="action-buttons">
                    <button type="button" class="btn btn-success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editActionModalLab' .
                            $row->id .
                            '">
                        Hasil
                    </button>
                    <form action="' .
                            route('action.destroy', $row->id) .
                            '" method="POST" class="d-inline">
                        ' .
                            csrf_field() .
                            '
                        ' .
                            $editModal .
                            '
                    </form>
                </div>';
                    } else {
                        return '-'; // Jika tidak ada hasil lab, tampilkan tanda minus atau pesan lain
                    }
                })

                ->addColumn('action', function ($row) {
                    // Render action buttons
                    $rs = Hospital::all();
                    $dokter = User::where('role', 'dokter')->get();
                    $routeName = request()->route()->getName();
                    $obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();
                    // Render modal for edit
                    $editModal = view('component.modal-edit-action-kia', ['action' => $row, 'routeName' => $routeName, 'dokter' => $dokter, 'rs' => $rs, 'obats' => $obats])->render();

                    return '<div class="action-buttons">
                                <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editActionModal' .
                        $row->id .
                        '">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="' .
                        route('action.destroy', $row->id) .
                        '" method="POST" class="d-inline">
                                    ' .
                        csrf_field() .
                        method_field('DELETE') .
                        '
                                    <button type="submit" class="btn btn-danger btn-sm text-white" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>' .
                        $editModal;
                })
                ->rawColumns(['action', 'hasil_lab'])
                ->make(true);
        }

        // Non-AJAX request handling
        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::all();
        $penyakit = Disease::all();
        $rs = Hospital::all();
        $routeName = $request->route()->getName();
        $obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();
        $poli = Poli::all();
        return view('content.action.index-kia', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName', 'obats', 'poli'));
    }

    public function indexDokterKb(Request $request)
    {
		$dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::all();
        $penyakit = Disease::all();
        $rs = Hospital::all();
        $routeName = $request->route()->getName();
        $obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();
        $poli = Poli::all();

        if ($request->ajax()) {
            $startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
            $endDate = $request->input('end_date') ?? Carbon::today()->toDateString();

            $actionsQuery = Action::with(['patient', 'hospitalReferral', 'hasilLab', 'actionObats.obat'])
                ->where('tipe', 'poli-kb') // Filter by type for KB
                ->whereNotNull('diagnosa_primer'); // Filter for actions that have 'layanan_kb'

            $actionsQuery->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate);

            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
                ->addIndexColumn()
                ->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
                ->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
                ->addColumn('patient_name', fn($row) => optional($row->patient)->name)
                ->addColumn('kartu', fn($row) => optional($row->patient)->jenis_kartu)
                ->addColumn('obat', function ($row) {
                    $doctorRole = 'dokter';

                    if ($row->actionObats->isNotEmpty()) {
                        $medications = $row->actionObats
                            ->filter(function ($ao) use ($doctorRole) {
                                return $ao->created_by == $doctorRole || $ao->created_by == null;
                            })
                            ->map(function ($ao) {
                                return optional($ao->obat)->name;
                            })
                            ->filter()
                            ->implode(', ');

                        return $medications ?: '-';
                    }

                    return '-';
                })
                ->addColumn('update_obat', function ($row) {
                    $apotikRole = 'apotik';

                    if ($row->actionObats->isNotEmpty()) {
                        $medications = $row->actionObats
                            ->filter(function ($ao) use ($apotikRole) {
                                return $ao->created_by == $apotikRole;
                            })
                            ->map(function ($ao) {
                                return optional($ao->obat)->name;
                            })
                            ->filter()
                            ->implode(', ');

                        return $medications ?: '-';
                    }

                    return '-';
                })
                ->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
                ->addColumn('diagnosa', function ($row) {
                    $diagnosa = $row->diagnosa;

                    if (is_string($diagnosa)) {
                        $diagnosaIds = json_decode($diagnosa, true);
                    } elseif (is_array($diagnosa)) {
                        $diagnosaIds = $diagnosa;
                    } else {
                        return '-';
                    }

                    $diagnosaIds = array_map('intval', $diagnosaIds);
                    $diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();

                    return !empty($diagnoses) ? implode(', ', $diagnoses) : '-';
                })
                ->addColumn('diagnosa_primer', function ($row) {
                    $diagnosaId = $row->diagnosa_primer;

                    $diagnosa = Diagnosis::where('id', $diagnosaId)->first();

                    return !empty($diagnosa) ? $diagnosa->name : '-';
                })
                ->addColumn('kunjungan', function ($row) {
                    $kunjunganCount = Kunjungan::where('pasien', $row->id_patient)->count();

                    return $kunjunganCount == 1 ? 'Baru' : 'Lama';
                })
                ->addColumn('status_satu_sehat', function ($row) {
                    $status = $row->status_satu_sehat;

                    return $status == 1 ? 'Berhasil' : 'Belum';
                })
                ->addColumn('hasil_lab', function ($row) {
                    if ($row->hasilLab) {
                        $dokter = User::where('role', 'dokter')->get();
                        $routeName = request()->route()->getName();
                        $editModal = view('component.modal-edit-action-lab', [
                            'action' => $row,
                            'routeName' => $routeName,
                            'dokter' => $dokter,
                        ])->render();

                        return '<div class="action-buttons">
                    <button type="button" class="btn btn-success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editActionModalLab' .
                            $row->id .
                            '">
                        Hasil
                    </button>
                    <form action="' .
                            route('action.destroy', $row->id) .
                            '" method="POST" class="d-inline">
                        ' .
                            csrf_field() .
                            '
                        ' .
                            $editModal .
                            '
                    </form>
                </div>';
                    } else {
                        return '-'; // Jika tidak ada hasil lab, tampilkan tanda minus atau pesan lain
                    }
                })

                ->addColumn('action', function ($row) use($rs, $dokter, $routeName, $obats) {
                    $editModal = view('component.modal-edit-action-kb', ['action' => $row, 'routeName' => $routeName, 'dokter' => $dokter, 'rs' => $rs, 'obats' => $obats])->render();

                    return '<div class="action-buttons">
                            <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editActionModal' .
                        $row->id .
                        '">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="' .
                        route('action.destroy', $row->id) .
                        '" method="POST" class="d-inline">
                                ' .
                        csrf_field() .
                        method_field('DELETE') .
                        '
                                <button type="submit" class="btn btn-danger btn-sm text-white" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>' .
                        $editModal;
                })
                ->rawColumns(['action', 'hasil_lab'])
                ->make(true);
        }
        return view('content.action.index-kb', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName', 'obats', 'poli'));
    }

    public function actionReport(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $poli = $request->query('poli_report');

        $query = Action::query();

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        } else {
            $startDate = Action::min('tanggal');
            $endDate = Action::max('tanggal');
        }
        if ($poli && $poli !== 'all') {
            if ($poli === 'tindakan') {
                $query->where(function ($query) {
                    $query->where('beri_tindakan', 1)
                          ->orWhere('tipe', 'tindakan');
                });
            } else {
                $query->where('tipe', $poli);
            }
        }

        $query->orderBy('tanggal', 'asc');
        $query->select([
            'id', 'tanggal', 'id_patient',
            'tinggiBadan', 'beratBadan', 'lingkarPinggang',
            'kasus', 'tipe', 'keluhan', 'diagnosa_primer',
            'tindakan', 'tindakan_ruang_tindakan', 'rujuk_rs',
            'keterangan', 'doctor', 'beri_tindakan','diagnosa','diagnosa_primer','sistol','diastol'
        ]);
        $query->with([
            'patient:id,no_rm,nik,name,dob,jenis_kartu,nomor_kartu,address,rw,gender',
            'patient.genderName:id,name',
            'diagnosaPrimer:id,name,icd10',
            'hospitalReferral:id,name'
        ]);
        $actions = $query->get();

        return view('content.action.print', compact('actions', 'startDate', 'endDate'));
    }

    public function store(Request $request)
    {
        try {
            // Fetch the patient ID based on the provided NIK
            // dd($request->all());
            $patient = Patients::where('nik', $request->nik)->first();
            if (!$patient) {
                return response()->json(['error' => 'Patient with the provided NIK does not exist.'], 422);
            }
            // Merge the request with the formatted tanggal and id_patient
            $request->merge([
                'id_patient' => $patient->id,
            ]);

            // Validate the request
            $validated = $request->validate([
                'id_patient' => 'required|exists:patients,id',
                'tanggal' => 'required',
                'doctor' => 'nullable',
                'kasus' => 'nullable',
                'faskes' => 'nullable|string|max:255',
                'sistol' => 'nullable|numeric',
                'diastol' => 'nullable|numeric',
                'beratBadan' => 'nullable|numeric',
                'tinggiBadan' => 'nullable|numeric',
                'lingkarPinggang' => 'nullable|numeric',
                'gula' => 'nullable|numeric',
                'merokok' => 'nullable|string|max:255',
                'fisik' => 'nullable|string|max:255',
                'garam' => 'nullable|string|max:255',
                'gula_lebih' => 'nullable|string|max:255',
                'lemak' => 'nullable|string|max:255',
                'alkohol' => 'nullable|string|max:255',
                'hidup' => 'nullable|string|max:255',
                'buah_sayur' => 'nullable|string|max:255',
                'hasil_iva' => 'nullable|string|max:255',
                'tindak_iva' => 'nullable|string|max:255',
                'hasil_sadanis' => 'nullable|string|max:255',
                'tindak_sadanis' => 'nullable|string|max:255',
                'konseling' => 'nullable|string|max:255',
                'car' => 'nullable|string|max:255',
                'rujuk_ubm' => 'nullable|string|max:255',
                'kondisi' => 'nullable|string|max:255',
                'edukasi' => 'nullable|string|max:255',
                'keluhan' => 'nullable|string|max:255',
                'diagnosa' => 'nullable',
                'tindakan' => 'nullable',
                'beri_tindakan' => 'nullable',
                'rujuk_rs' => 'nullable|exists:hospitals,id',
                'keterangan' => 'nullable|string|max:255',
                'nadi' => 'nullable|numeric',
                'nafas' => 'nullable|numeric',
                'suhu' => 'nullable|numeric',
                'mata_anemia' => 'nullable|string|max:255',
                'pupil' => 'nullable|string|max:255',
                'ikterus' => 'nullable|string|max:255',
                'udem_palpebral' => 'nullable|string|max:255',
                'nyeri_tekan' => 'nullable|string|max:255',
                'peristaltik' => 'nullable|string|max:255',
                'ascites' => 'nullable|string|max:255',
                'lokasi_abdomen' => 'nullable|string|max:255',
                'thorax' => 'nullable|string|max:255',
                'thorax_bj' => 'nullable|string|max:255',
                'suara_nafas' => 'nullable|string|max:255',
                'ronchi' => 'nullable|string|max:255',
                'wheezing' => 'nullable|string|max:255',
                'ekstremitas' => 'nullable|string|max:255',
                'edema' => 'nullable|string|max:255',
                'tonsil' => 'nullable|string|max:255',
                'fharing' => 'nullable|string|max:255',
                'kelenjar' => 'nullable|string|max:255',
                'genetalia' => 'nullable|string|max:255',
                'warna_kulit' => 'nullable|string|max:255',
                'turgor' => 'nullable|string|max:255',
                'neurologis' => 'nullable|string|max:255',
                'hasil_lab' => 'nullable|string|max:255',
                'obat' => 'nullable',
                'riwayat_penyakit_sekarang' => 'nullable',
                'riwayat_penyakit_keluarga' => 'nullable',
                'riwayat_penyakit_dulu' => 'nullable',
                'riwayat_penyakit_lainnya' => 'nullable',
                'riwayat_penyakit_lainnya_keluarga' => 'nullable',
                'riwayat_pengobatan' => 'nullable',
                'riwayat_alergi' => 'nullable',
                'pemeriksaan_penunjang' => 'nullable',
                'usia_kehamilan' => 'nullable',
                'jenis_anc' => 'nullable',
                'nilai_hb' => 'nullable',
                'lingkar_lengan_atas' => 'nullable',
                'tinggi_fundus_uteri' => 'nullable',
                'presentasi_janin' => 'nullable',
                'denyut_jantung' => 'nullable',
                'kaki_bengkak' => 'nullable',
                'imunisasi_tt' => 'nullable',
                'tablet_fe' => 'nullable',
                'gravida' => 'nullable',
                'partus' => 'nullable',
                'abortus' => 'nullable',
                'proteinuria' => 'nullable',
                'hiv' => 'nullable',
                'sifilis' => 'nullable',
                'hepatitis' => 'nullable',
                'periksa_usg' => 'nullable',
                'hasil_usg' => 'nullable',
                'treatment_anc' => 'nullable',
                'kesimpulan' => 'nullable',
                'tanggal_kembali' => 'nullable',
                'layanan_kb' => 'nullable',
                'jmlh_anak_laki' => 'nullable',
                'jmlh_anak_perempuan' => 'nullable',
                'status_kb' => 'nullable',
                'tgl_lahir_anak_bungsu' => 'nullable',
                'kb_terakhir' => 'nullable',
                'tgl_kb_terakhir' => 'nullable',
                'keadaan_umum' => 'nullable',
                'informed_concern' => 'nullable',
                'sakit_kuning' => 'nullable',
                'pendarahan_vagina' => 'nullable',
                'tumor' => 'nullable',
                'diabetes' => 'nullable',
                'pembekuan_darah' => 'nullable',
                'tipe' => 'nullable',
                'tindakan_ruang_tindakan' => 'nullable',
                'id_rujuk_poli' => 'nullable',
                'diagnosa_primer' => 'nullable',
            ]);
            $existingAction = Action::where('id_patient', $validated['id_patient'])->where('tanggal', $validated['tanggal'])->where('tipe', $validated['tipe'])->first();
            if ($existingAction) {
                return;
            }
            if ($request->has('tindakan_ruang_tindakan')) {
                $validated['tindakan_ruang_tindakan'] = implode(',', $request->tindakan_ruang_tindakan);
            }
            if ($request->has('tindakan')) {
                $validated['tindakan'] = implode(',', $request->tindakan);
            }

            $medications = json_decode($request->medications, true);

            // Jika tidak ada ID, buat data baru
            $action = Action::create($validated);

            if (!empty($request->jenis_pemeriksaan)) {
                HasilLab::create([
                    'id_action' => $action->id,
                    'jenis_pemeriksaan' => json_encode($request->jenis_pemeriksaan), // Simpan sebagai JSON
                ]);
            }

            // Ensure medications is an array before using foreach
            if (is_array($medications)) {
                foreach ($medications as $medication) {
                    // Process each medication
                    $shapes = [
                        'Tablet' => 1,
                        'Botol' => 2,
                        'Pcs' => 3,
                        'Suppositoria' => 4,
                        'Ovula' => 5,
                        'Drop' => 6,
                        'Tube' => 7,
                        'Pot' => 8,
                        'Injeksi' => 9,
                        'Kapsul' => 10,
                        'Ampul' => 11,
                        'Sachet' => 12,
                        'Paket' => 13,
                        'Vial' => 14,
                        'Bungkus' => 15,
                        'Strip' => 16,
                        'Test' => 17,
                        'Lbr' => 18,
                        'Tabung' => 19,
                        'Buah' => 20,
                        'Lembar' => 21,
                    ];

                    ActionObat::create([
                        'id_action' => $action->id,
                        'number' => $medication['number'],
                        'name' => $medication['name'],
                        'dose' => $medication['dose'],
                        'amount' => $medication['quantity'],
                        'shape' => $shapes[$medication['shape']] ?? null, // Konversi teks ke angka
                        'id_obat' => $medication['idObat'],
                    ]);

                    $obats = TerimaObat::where('id_obat', $medication['idObat'])->get();

                    if ($obats->isEmpty()) {
                        return response()->json(['error' => 'Obat tidak ditemukan'], 404);
                    }

                    $remainingQuantity = $medication['quantity'];

                    foreach ($obats as $obat) {
                        if ($remainingQuantity <= 0) {
                            break; // Jika sudah cukup, keluar dari loop
                        }

                        if ($obat->amount >= $remainingQuantity) {
                            $obat->amount -= $remainingQuantity;
                            $obat->save();
                            $remainingQuantity = 0; // Semua jumlah sudah dikurangi
                        } else {
                            $remainingQuantity -= $obat->amount;
                            $obat->amount = 0;
                            $obat->save();
                        }
                    }

                    if ($remainingQuantity > 0) {
                        return response()->json(['error' => 'Stok tidak mencukupi'], 400);
                    }
                }
            }
            return response()->json(['success' => 'Action has been successfully created.', 'data' => $action]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    public function update(Request $request, $id = null)
    {
        try {
            $patient = Patients::where('nik', $request->nikEdit)->first();
            if (!$patient) {
                return response()->json(['error' => 'Patient with the provided NIK does not exist.'], 422);
            }
            // Merge the request with the formatted tanggal and id_patient
            $request->merge([
                'id_patient' => $patient->id,
            ]);
            $userRole = Auth::user()->role;

            // Validate the request
            $validated = $request->validate([
                'id_patient' => 'required',
                'tanggal' => 'required',
                'doctor' => 'required',
                'kasus' => 'nullable|string|max:255',
                'faskes' => 'nullable|string|max:255',
                'sistol' => 'nullable|numeric',
                'diastol' => 'nullable|numeric',
                'beratBadan' => 'nullable|numeric',
                'tinggiBadan' => 'nullable|numeric',
                'lingkarPinggang' => 'nullable|numeric',
                'gula' => 'nullable|numeric',
                'merokok' => 'nullable|string|max:255',
                'fisik' => 'nullable|string|max:255',
                'garam' => 'nullable|string|max:255',
                'gula_lebih' => 'nullable|string|max:255',
                'lemak' => 'nullable|string|max:255',
                'alkohol' => 'nullable|string|max:255',
                'hidup' => 'nullable|string|max:255',
                'buah_sayur' => 'nullable|string|max:255',
                'hasil_iva' => 'nullable|string|max:255',
                'tindak_iva' => 'nullable|string|max:255',
                'hasil_sadanis' => 'nullable|string|max:255',
                'tindak_sadanis' => 'nullable|string|max:255',
                'konseling' => 'nullable|string|max:255',
                'car' => 'nullable|string|max:255',
                'rujuk_ubm' => 'nullable|string|max:255',
                'kondisi' => 'nullable|string|max:255',
                'edukasi' => 'nullable|string|max:255',
                'keluhan' => 'nullable|string|max:255',
                'diagnosa' => 'nullable',
                'tindakan' => 'nullable',
                'beri_tindakan' => 'nullable',
                'rujuk_rs' => 'nullable|exists:hospitals,id',
                'keterangan' => 'nullable|string|max:255',
                'nadi' => 'nullable|numeric',
                'nafas' => 'nullable|numeric',
                'suhu' => 'nullable|numeric',
                'mata_anemia' => 'nullable|string|max:255',
                'pupil' => 'nullable|string|max:255',
                'ikterus' => 'nullable|string|max:255',
                'udem_palpebral' => 'nullable|string|max:255',
                'nyeri_tekan' => 'nullable|string|max:255',
                'peristaltik' => 'nullable|string|max:255',
                'ascites' => 'nullable|string|max:255',
                'lokasi_abdomen' => 'nullable|string|max:255',
                'thorax' => 'nullable|string|max:255',
                'thorax_bj' => 'nullable|string|max:255',
                'suara_nafas' => 'nullable|string|max:255',
                'ronchi' => 'nullable|string|max:255',
                'wheezing' => 'nullable|string|max:255',
                'ekstremitas' => 'nullable|string|max:255',
                'edema' => 'nullable|string|max:255',
                'tonsil' => 'nullable|string|max:255',
                'fharing' => 'nullable|string|max:255',
                'kelenjar' => 'nullable|string|max:255',
                'genetalia' => 'nullable|string|max:255',
                'warna_kulit' => 'nullable|string|max:255',
                'turgor' => 'nullable|string|max:255',
                'neurologis' => 'nullable|string|max:255',
                'hasil_lab' => 'nullable|string|max:255',
                'obat' => 'nullable',
                'riwayat_penyakit_sekarang' => 'nullable',
                'riwayat_penyakit_keluarga' => 'nullable',
                'riwayat_penyakit_dulu' => 'nullable',
                'riwayat_penyakit_lainnya' => 'nullable',
                'riwayat_penyakit_lainnya_keluarga' => 'nullable',
                'riwayat_pengobatan' => 'nullable',
                'riwayat_alergi' => 'nullable',
                'pemeriksaan_penunjang' => 'nullable',
                'usia_kehamilan' => 'nullable',
                'jenis_anc' => 'nullable',
                'nilai_hb' => 'nullable',
                'lingkar_lengan_atas' => 'nullable',
                'tinggi_fundus_uteri' => 'nullable',
                'presentasi_janin' => 'nullable',
                'denyut_jantung' => 'nullable',
                'kaki_bengkak' => 'nullable',
                'imunisasi_tt' => 'nullable',
                'tablet_fe' => 'nullable',
                'gravida' => 'nullable',
                'partus' => 'nullable',
                'abortus' => 'nullable',
                'proteinuria' => 'nullable',
                'hiv' => 'nullable',
                'sifilis' => 'nullable',
                'hepatitis' => 'nullable',
                'periksa_usg' => 'nullable',
                'hasil_usg' => 'nullable',
                'treatment_anc' => 'nullable',
                'kesimpulan' => 'nullable',
                'tanggal_kembali' => 'nullable',
                'layanan_kb' => 'nullable',
                'jmlh_anak_laki' => 'nullable',
                'jmlh_anak_perempuan' => 'nullable',
                'status_kb' => 'nullable',
                'tgl_lahir_anak_bungsu' => 'nullable',
                'kb_terakhir' => 'nullable',
                'tgl_kb_terakhir' => 'nullable',
                'keadaan_umum' => 'nullable',
                'informed_concern' => 'nullable',
                'sakit_kuning' => 'nullable',
                'pendarahan_vagina' => 'nullable',
                'tumor' => 'nullable',
                'diabetes' => 'nullable',
                'pembekuan_darah' => 'nullable',
                'tindakan_ruang_tindakan' => 'nullable',
                'id_rujuk_poli' => 'nullable',
                'diagnosa_primer' => 'nullable',
            ]);
            $validated['lingkar_lengan_atas'] = $validated['lingkar_lengan_atas'] ?? 0;
            $validated['tinggi_fundus_uteri'] = $validated['tinggi_fundus_uteri'] ?? 0;
            $validated['denyut_jantung'] = $validated['denyut_jantung'] ?? 0;
            $validated['kaki_bengkak'] = $validated['kaki_bengkak'] ?? 0;
            $validated['imunisasi_tt'] = $validated['imunisasi_tt'] ?? 0;
            $validated['tablet_fe'] = $validated['tablet_fe'] ?? 0;
            $validated['proteinuria'] = $validated['proteinuria'] ?? 0;
            $validated['periksa_usg'] = $validated['periksa_usg'] ?? 0;
            $medications = json_decode($request->medications, true);
            // dd($request->medications);
            $validated['alergi'] = $medications[0]['alergi'] ?? null;
            $validated['usia_kehamilan'] = $medications[0]['hamil'] ?? 0;
            $validated['gangguan_ginjal'] = $medications[0]['gangguan_ginjal'] ?? null;
            $validated['menyusui'] = $medications[0]['menyusui'] ?? 0;
            // dd($validated);
            if ($request->has('tindakan_ruang_tindakan')) {
                $validated['tindakan_ruang_tindakan'] = implode(',', $request->tindakan_ruang_tindakan);
            }
            if ($request->has('tindakan')) {
                $validated['tindakan'] = implode(',', $request->tindakan);
            }
            if ($id != null) {
                // Jika ID diberikan, update data yang sudah ada
                $action = Action::find($id);
                $action = Action::updateOrCreate(['id' => $request->id], $validated);

                if (!empty($request->jenis_pemeriksaan)) {
                    $dataLab = [
                        'id_action' => $action->id,
                        'jenis_pemeriksaan' => json_encode($request->jenis_pemeriksaan),
                    ];

                    // Cek apakah sudah ada hasil lab untuk action ini
                    $existingLab = HasilLab::where('id_action', $action->id)->first();

                    if ($existingLab) {
                        $existingLab->update($dataLab);
                    } else {
                        HasilLab::create($dataLab);
                    }
                }

                $medications = json_decode($request->medications, true);
                // dd($medications);

                // Ensure medications is an array before using foreach
                if (is_array($medications)) {
                    foreach ($medications as $medication) {
                        // Process each medication
                        $shapes = [
                            'Tablet' => 1,
                            'Botol' => 2,
                            'Pcs' => 3,
                            'Suppositoria' => 4,
                            'Ovula' => 5,
                            'Drop' => 6,
                            'Tube' => 7,
                            'Pot' => 8,
                            'Injeksi' => 9,
                            'Kapsul' => 10,
                            'Ampul' => 11,
                            'Sachet' => 12,
                            'Paket' => 13,
                            'Vial' => 14,
                            'Bungkus' => 15,
                            'Strip' => 16,
                            'Test' => 17,
                            'Lbr' => 18,
                            'Tabung' => 19,
                            'Buah' => 20,
                            'Lembar' => 21,
                        ];
                        // dd($medication['shape'] );
                        ActionObat::create([
                            'id_action' => $action->id,
                            'number' => $medication['number'],
                            'name' => $medication['name'],
                            'dose' => $medication['dose'],
                            'amount' => $medication['quantity'],
                            'shape' => $shapes[$medication['shape']] ?? null, // Konversi teks ke angka
                            'id_obat' => $medication['idObat'],
                            'created_by' => $userRole,
                        ]);

                        $obats = TerimaObat::where('id_obat', $medication['idObat'])->get();

                        if ($obats->isEmpty()) {
                            return response()->json(['error' => 'Obat tidak ditemukan'], 404);
                        }

                        $remainingQuantity = $medication['quantity'];

                        foreach ($obats as $obat) {
                            if ($remainingQuantity <= 0) {
                                break; // Jika sudah cukup, keluar dari loop
                            }

                            if ($obat->amount >= $remainingQuantity) {
                                $obat->amount -= $remainingQuantity;
                                $obat->save();
                                $remainingQuantity = 0; // Semua jumlah sudah dikurangi
                            } else {
                                $remainingQuantity -= $obat->amount;
                                $obat->amount = 0;
                                $obat->save();
                            }
                        }

                        if ($remainingQuantity > 0) {
                            return response()->json(['error' => 'Stok tidak mencukupi'], 400);
                        }
                    }
                }

                if (!$action) {
                    return response()->json(['error' => 'Action not found'], 404);
                }
                $action->update($validated);
                return response()->json(['success' => 'Action has been successfully updated.']);
            } else {
                $medications = json_decode($request->medications, true);

                // Jika tidak ada ID, buat data baru
                $action = Action::create($validated);
                if (!empty($request->jenis_pemeriksaan)) {
                    HasilLab::create([
                        'id_action' => $action->id,
                        'jenis_pemeriksaan' => json_encode($request->jenis_pemeriksaan), // Simpan sebagai JSON
                    ]);
                }

                // Ensure medications is an array before using foreach
                if (is_array($medications)) {
                    foreach ($medications as $medication) {
                        // Process each medication
                        $shapes = [
                            'Tablet' => 1,
                            'Botol' => 2,
                            'Pcs' => 3,
                            'Suppositoria' => 4,
                            'Ovula' => 5,
                            'Drop' => 6,
                            'Tube' => 7,
                            'Pot' => 8,
                            'Injeksi' => 9,
                            'Kapsul' => 10,
                            'Ampul' => 11,
                            'Sachet' => 12,
                            'Paket' => 13,
                            'Vial' => 14,
                            'Bungkus' => 15,
                            'Strip' => 16,
                            'Test' => 17,
                            'Lbr' => 18,
                            'Tabung' => 19,
                            'Buah' => 20,
                            'Lembar' => 21,
                        ];

                        ActionObat::create([
                            'id_action' => $action->id,
                            'number' => $medication['number'],
                            'name' => $medication['name'],
                            'dose' => $medication['dose'],
                            'amount' => $medication['quantity'],
                            'shape' => $shapes[$medication['shape']] ?? null, // Konversi teks ke angka
                            'id_obat' => $medication['idObat'],
                            'created_by' => $userRole,
                        ]);

                        $obats = TerimaObat::where('id_obat', $medication['idObat'])->get();

                        if ($obats->isEmpty()) {
                            return response()->json(['error' => 'Obat tidak ditemukan'], 404);
                        }

                        $remainingQuantity = $medication['quantity'];

                        foreach ($obats as $obat) {
                            if ($remainingQuantity <= 0) {
                                break;
                            }

                            if ($obat->amount >= $remainingQuantity) {
                                $obat->amount -= $remainingQuantity;
                                $obat->save();
                                $remainingQuantity = 0;
                            } else {
                                $remainingQuantity -= $obat->amount;
                                $obat->amount = 0;
                                $obat->save();
                            }
                        }

                        if ($remainingQuantity > 0) {
                            return response()->json(['error' => 'Stok tidak mencukupi'], 400);
                        }
                    }
                }
                return response()->json(['success' => 'Action has been successfully created.', 'data' => $action]);
            }
        } catch (\Exception $e) {
            Log::error('Error in updating action: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
            ]);

            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    public function updateDokter(Request $request, $id = null)
    {
        try {
            $patient = Patients::where('nik', $request->nik)->first();
            if (!$patient) {
                return response()->json(['error' => 'Patient with the provided NIK does not exist.'], 422);
            }
            // Merge the request with the formatted tanggal and id_patient
            $request->merge([
                'id_patient' => $patient->id,
            ]);

            $userRole = Auth::user()->role;
            // Validate the request
            $validated = $request->validate([
                'id_patient' => 'required',
                'tanggal' => 'required',
                'doctor' => 'required',
                'kasus' => 'required|nullable|string|max:255',
                'faskes' => 'nullable|string|max:255',
                'sistol' => 'nullable|numeric',
                'diastol' => 'nullable|numeric',
                'beratBadan' => 'nullable|numeric',
                'tinggiBadan' => 'nullable|numeric',
                'lingkarPinggang' => 'nullable|numeric',
                'gula' => 'nullable|numeric',
                'merokok' => 'nullable|string|max:255',
                'fisik' => 'nullable|string|max:255',
                'garam' => 'nullable|string|max:255',
                'gula_lebih' => 'nullable|string|max:255',
                'lemak' => 'nullable|string|max:255',
                'alkohol' => 'nullable|string|max:255',
                'hidup' => 'nullable|string|max:255',
                'buah_sayur' => 'nullable|string|max:255',
                'hasil_iva' => 'nullable|string|max:255',
                'tindak_iva' => 'nullable|string|max:255',
                'hasil_sadanis' => 'nullable|string|max:255',
                'tindak_sadanis' => 'nullable|string|max:255',
                'konseling' => 'nullable|string|max:255',
                'car' => 'nullable|string|max:255',
                'rujuk_ubm' => 'nullable|string|max:255',
                'kondisi' => 'nullable|string|max:255',
                'edukasi' => 'nullable|string|max:255',
                'keluhan' => 'nullable|string|max:255',
                'diagnosa' => 'nullable',
                'tindakan' => 'nullable',
                'beri_tindakan' => 'nullable',
                'rujuk_rs' => 'nullable|exists:hospitals,id',
                'keterangan' => 'nullable|string|max:255',
                'nadi' => 'nullable|numeric',
                'nafas' => 'nullable|numeric',
                'suhu' => 'nullable|numeric',
                'mata_anemia' => 'nullable|string|max:255',
                'pupil' => 'nullable|string|max:255',
                'ikterus' => 'nullable|string|max:255',
                'udem_palpebral' => 'nullable|string|max:255',
                'nyeri_tekan' => 'nullable|string|max:255',
                'peristaltik' => 'nullable|string|max:255',
                'ascites' => 'nullable|string|max:255',
                'lokasi_abdomen' => 'nullable|string|max:255',
                'thorax' => 'nullable|string|max:255',
                'thorax_bj' => 'nullable|string|max:255',
                'suara_nafas' => 'nullable|string|max:255',
                'ronchi' => 'nullable|string|max:255',
                'wheezing' => 'nullable|string|max:255',
                'ekstremitas' => 'nullable|string|max:255',
                'edema' => 'nullable|string|max:255',
                'tonsil' => 'nullable|string|max:255',
                'fharing' => 'nullable|string|max:255',
                'kelenjar' => 'nullable|string|max:255',
                'genetalia' => 'nullable|string|max:255',
                'warna_kulit' => 'nullable|string|max:255',
                'turgor' => 'nullable|string|max:255',
                'neurologis' => 'nullable|string|max:255',
                'hasil_lab' => 'nullable|string|max:255',
                'obat' => 'nullable',
                'riwayat_penyakit_sekarang' => 'nullable',
                'riwayat_penyakit_keluarga' => 'nullable',
                'riwayat_penyakit_dulu' => 'nullable',
                'riwayat_penyakit_lainnya' => 'nullable',
                'riwayat_penyakit_lainnya_keluarga' => 'nullable',
                'riwayat_pengobatan' => 'nullable',
                'riwayat_alergi' => 'nullable',
                'pemeriksaan_penunjang' => 'nullable',
                'usia_kehamilan' => 'nullable',
                'jenis_anc' => 'nullable',
                'nilai_hb' => 'nullable',
                'lingkar_lengan_atas' => 'nullable',
                'tinggi_fundus_uteri' => 'nullable',
                'presentasi_janin' => 'nullable',
                'denyut_jantung' => 'nullable',
                'kaki_bengkak' => 'nullable',
                'imunisasi_tt' => 'nullable',
                'tablet_fe' => 'nullable',
                'gravida' => 'nullable',
                'partus' => 'nullable',
                'abortus' => 'nullable',
                'proteinuria' => 'nullable',
                'hiv' => 'nullable',
                'sifilis' => 'nullable',
                'hepatitis' => 'nullable',
                'periksa_usg' => 'nullable',
                'hasil_usg' => 'nullable',
                'treatment_anc' => 'nullable',
                'kesimpulan' => 'nullable',
                'tanggal_kembali' => 'nullable',
                'layanan_kb' => 'nullable',
                'jmlh_anak_laki' => 'nullable',
                'jmlh_anak_perempuan' => 'nullable',
                'status_kb' => 'nullable',
                'tgl_lahir_anak_bungsu' => 'nullable',
                'kb_terakhir' => 'nullable',
                'tgl_kb_terakhir' => 'nullable',
                'keadaan_umum' => 'nullable',
                'informed_concern' => 'nullable',
                'sakit_kuning' => 'nullable',
                'pendarahan_vagina' => 'nullable',
                'tumor' => 'nullable',
                'diabetes' => 'nullable',
                'pembekuan_darah' => 'nullable',
                'tindakan_ruang_tindakan' => 'nullable',
                'id_rujuk_poli' => 'nullable',
                'diagnosa_primer' => 'nullable',
            ]);
            $validated['lingkar_lengan_atas'] = $validated['lingkar_lengan_atas'] ?? 0;
            $validated['tinggi_fundus_uteri'] = $validated['tinggi_fundus_uteri'] ?? 0;
            $validated['denyut_jantung'] = $validated['denyut_jantung'] ?? 0;
            $validated['kaki_bengkak'] = $validated['kaki_bengkak'] ?? 0;
            $validated['imunisasi_tt'] = $validated['imunisasi_tt'] ?? 0;
            $validated['tablet_fe'] = $validated['tablet_fe'] ?? 0;
            $validated['proteinuria'] = $validated['proteinuria'] ?? 0;
            $validated['periksa_usg'] = $validated['periksa_usg'] ?? 0;
            $medications = json_decode($request->medications, true);
            // dd($request->medications);
            $validated['alergi'] = $medications[0]['alergi'] ?? null;
            $validated['usia_kehamilan'] = $medications[0]['hamil'] ?? 0;
            $validated['gangguan_ginjal'] = $medications[0]['gangguan_ginjal'] ?? null;
            $validated['menyusui'] = $medications[0]['menyusui'] ?? 0;

            // dd($validated);
            if ($request->has('tindakan_ruang_tindakan')) {
                $validated['tindakan_ruang_tindakan'] = implode(',', $request->tindakan_ruang_tindakan);
            }
            if ($request->has('tindakan')) {
                $validated['tindakan'] = implode(',', $request->tindakan);
            }
            if ($id != null) {
                $action = Action::find($id);
                if (!empty($request->jenis_pemeriksaan)) {
                    HasilLab::create([
                        'id_action' => $action->id,
                        'jenis_pemeriksaan' => json_encode($request->jenis_pemeriksaan),
                    ]);
                }
                $medications = json_decode($request->medications, true);

                // Ensure medications is an array before using foreach
                if (is_array($medications)) {
                    foreach ($medications as $medication) {
                        // Process each medication
                        $shapes = [
                            'Tablet' => 1,
                            'Botol' => 2,
                            'Pcs' => 3,
                            'Suppositoria' => 4,
                            'Ovula' => 5,
                            'Drop' => 6,
                            'Tube' => 7,
                            'Pot' => 8,
                            'Injeksi' => 9,
                            'Kapsul' => 10,
                            'Ampul' => 11,
                            'Sachet' => 12,
                            'Paket' => 13,
                            'Vial' => 14,
                            'Bungkus' => 15,
                            'Strip' => 16,
                            'Test' => 17,
                            'Lbr' => 18,
                            'Tabung' => 19,
                            'Buah' => 20,
                            'Lembar' => 21,
                        ];

                        ActionObat::create([
                            'id_action' => $action->id,
                            'number' => $medication['number'],
                            'name' => $medication['name'],
                            'dose' => $medication['dose'],
                            'amount' => $medication['quantity'],
                            'shape' => $shapes[$medication['shape']] ?? null, // Konversi teks ke angka
                            'id_obat' => $medication['idObat'],
                            'created_by' => $userRole,
                        ]);

                        $obats = TerimaObat::where('id_obat', $medication['idObat'])->get();

                        if ($obats->isEmpty()) {
                            return response()->json(['error' => 'Obat tidak ditemukan'], 404);
                        }

                        $remainingQuantity = $medication['quantity'];

                        foreach ($obats as $obat) {
                            if ($remainingQuantity <= 0) {
                                break; // Jika sudah cukup, keluar dari loop
                            }

                            if ($obat->amount >= $remainingQuantity) {
                                $obat->amount -= $remainingQuantity;
                                $obat->save();
                                $remainingQuantity = 0; // Semua jumlah sudah dikurangi
                            } else {
                                $remainingQuantity -= $obat->amount;
                                $obat->amount = 0;
                                $obat->save();
                            }
                        }

                        if ($remainingQuantity > 0) {
                            return response()->json(['error' => 'Stok tidak mencukupi'], 400);
                        }
                    }
                }

                if (!$action) {
                    return response()->json(['error' => 'Action not found'], 404);
                }
                $action->update($validated);
                return response()->json(['success' => 'Action has been successfully updated.']);
            } else {
                $medications = json_decode($request->medications, true);

                // Jika tidak ada ID, buat data baru
                $action = Action::create($validated);
                if (!empty($request->jenis_pemeriksaan)) {
                    HasilLab::create([
                        'id_action' => $action->id,
                        'jenis_pemeriksaan' => json_encode($request->jenis_pemeriksaan), // Simpan sebagai JSON
                    ]);
                }

                // Ensure medications is an array before using foreach
                if (is_array($medications)) {
                    foreach ($medications as $medication) {
                        // Process each medication
                        $shapes = [
                            'Tablet' => 1,
                            'Botol' => 2,
                            'Pcs' => 3,
                            'Suppositoria' => 4,
                            'Ovula' => 5,
                            'Drop' => 6,
                            'Tube' => 7,
                            'Pot' => 8,
                            'Injeksi' => 9,
                            'Kapsul' => 10,
                            'Ampul' => 11,
                            'Sachet' => 12,
                            'Paket' => 13,
                            'Vial' => 14,
                            'Bungkus' => 15,
                            'Strip' => 16,
                            'Test' => 17,
                            'Lbr' => 18,
                            'Tabung' => 19,
                            'Buah' => 20,
                            'Lembar' => 21,
                        ];

                        ActionObat::create([
                            'id_action' => $action->id,
                            'number' => $medication['number'],
                            'name' => $medication['name'],
                            'dose' => $medication['dose'],
                            'amount' => $medication['quantity'],
                            'shape' => $shapes[$medication['shape']] ?? null, // Konversi teks ke angka
                            'id_obat' => $medication['idObat'],
                            'created_by' => $userRole,
                        ]);

                        $obats = TerimaObat::where('id_obat', $medication['idObat'])->get();

                        if ($obats->isEmpty()) {
                            return response()->json(['error' => 'Obat tidak ditemukan'], 404);
                        }

                        $remainingQuantity = $medication['quantity'];

                        foreach ($obats as $obat) {
                            if ($remainingQuantity <= 0) {
                                break; // Jika sudah cukup, keluar dari loop
                            }

                            if ($obat->amount >= $remainingQuantity) {
                                $obat->amount -= $remainingQuantity;
                                $obat->save();
                                $remainingQuantity = 0; // Semua jumlah sudah dikurangi
                            } else {
                                $remainingQuantity -= $obat->amount;
                                $obat->amount = 0;
                                $obat->save();
                            }
                        }

                        if ($remainingQuantity > 0) {
                            return response()->json(['error' => 'Stok tidak mencukupi'], 400);
                        }
                    }
                }
                return response()->json(['success' => 'Action has been successfully created.', 'data' => $action]);
            }
        } catch (\Exception $e) {
            Log::error('Error in updating action: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
            ]);

            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    public function updateTindakan(Request $request, $id)
    {
        try {
            $action = Action::find($id);
            if (!$action) {
                Log::warning("Action dengan ID {$id} tidak ditemukan");
                return redirect()->back()->with('error', 'Action not found');
            }

            // Fetch the patient ID based on the provided NIK
            $patient = Patients::where('nik', $request->nik)->first();

            if (!$patient) {
                return redirect()
                    ->back()
                    ->withErrors(['nik' => 'Patient with the provided NIK does not exist.'])
                    ->withInput();
            }

            // Merge the request with the formatted tanggal and id_patient
            $request->merge([
                'id_patient' => $patient->id,
            ]);
            // dd($request->);
            // Validate the request
            $validated = $request->validate([
                'id_patient' => 'required',
                'tanggal' => 'required',
                'doctor' => 'required',
                'kunjungan' => 'nullable|string|max:255',
                'faskes' => 'nullable|string|max:255',
                'sistol' => 'nullable|numeric',
                'diastol' => 'nullable|numeric',
                'beratBadan' => 'nullable|numeric',
                'tinggiBadan' => 'nullable|numeric',
                'lingkarPinggang' => 'nullable|numeric',
                'gula' => 'nullable|numeric',
                'merokok' => 'nullable|string|max:255',
                'fisik' => 'nullable|string|max:255',
                'garam' => 'nullable|string|max:255',
                'gula_lebih' => 'nullable|string|max:255',
                'lemak' => 'nullable|string|max:255',
                'alkohol' => 'nullable|string|max:255',
                'hidup' => 'nullable|string|max:255',
                'buah_sayur' => 'nullable|string|max:255',
                'hasil_iva' => 'nullable|string|max:255',
                'tindak_iva' => 'nullable|string|max:255',
                'hasil_sadanis' => 'nullable|string|max:255',
                'tindak_sadanis' => 'nullable|string|max:255',
                'konseling' => 'nullable|string|max:255',
                'car' => 'nullable|string|max:255',
                'rujuk_ubm' => 'nullable|string|max:255',
                'kondisi' => 'nullable|string|max:255',
                'edukasi' => 'nullable|string|max:255',
                'keluhan' => 'nullable|string|max:255',
                'diagnosa' => 'nullable',
                'tindakan' => 'nullable',
                'beri_tindakan' => 'nullable',
                'rujuk_rs' => 'nullable|exists:hospitals,id',
                'keterangan' => 'nullable|string|max:255',
                'nadi' => 'nullable|numeric',
                'nafas' => 'nullable|numeric',
                'suhu' => 'nullable|numeric',
                'mata_anemia' => 'nullable|string|max:255',
                'pupil' => 'nullable|string|max:255',
                'ikterus' => 'nullable|string|max:255',
                'udem_palpebral' => 'nullable|string|max:255',
                'nyeri_tekan' => 'nullable|string|max:255',
                'peristaltik' => 'nullable|string|max:255',
                'ascites' => 'nullable|string|max:255',
                'lokasi_abdomen' => 'nullable|string|max:255',
                'thorax' => 'nullable|string|max:255',
                'thorax_bj' => 'nullable|string|max:255',
                'suara_nafas' => 'nullable|string|max:255',
                'ronchi' => 'nullable|string|max:255',
                'wheezing' => 'nullable|string|max:255',
                'ekstremitas' => 'nullable|string|max:255',
                'edema' => 'nullable|string|max:255',
                'tonsil' => 'nullable|string|max:255',
                'fharing' => 'nullable|string|max:255',
                'kelenjar' => 'nullable|string|max:255',
                'genetalia' => 'nullable|string|max:255',
                'warna_kulit' => 'nullable|string|max:255',
                'turgor' => 'nullable|string|max:255',
                'neurologis' => 'nullable|string|max:255',
                'hasil_lab' => 'nullable|string|max:255',
                'obat' => 'nullable',
                'riwayat_penyakit_sekarang' => 'nullable',
                'riwayat_penyakit_keluarga' => 'nullable',
                'riwayat_penyakit_dulu' => 'nullable',
                'riwayat_penyakit_lainnya' => 'nullable',
                'riwayat_penyakit_lainnya_keluarga' => 'nullable',
                'riwayat_pengobatan' => 'nullable',
                'riwayat_alergi' => 'nullable',
                'pemeriksaan_penunjang' => 'nullable',
                'usia_kehamilan' => 'nullable',
                'jenis_anc' => 'nullable',
                'nilai_hb' => 'nullable',
                'lingkar_lengan_atas' => 'nullable',
                'tinggi_fundus_uteri' => 'nullable',
                'presentasi_janin' => 'nullable',
                'denyut_jantung' => 'nullable',
                'kaki_bengkak' => 'nullable',
                'imunisasi_tt' => 'nullable',
                'tablet_fe' => 'nullable',
                'gravida' => 'nullable',
                'partus' => 'nullable',
                'abortus' => 'nullable',
                'proteinuria' => 'nullable',
                'hiv' => 'nullable',
                'sifilis' => 'nullable',
                'hepatitis' => 'nullable',
                'periksa_usg' => 'nullable',
                'hasil_usg' => 'nullable',
                'treatment_anc' => 'nullable',
                'kesimpulan' => 'nullable',
                'tanggal_kembali' => 'nullable',
                'layanan_kb' => 'nullable',
                'jmlh_anak_laki' => 'nullable',
                'jmlh_anak_perempuan' => 'nullable',
                'status_kb' => 'nullable',
                'tgl_lahir_anak_bungsu' => 'nullable',
                'kb_terakhir' => 'nullable',
                'tgl_kb_terakhir' => 'nullable',
                'keadaan_umum' => 'nullable',
                'informed_concern' => 'nullable',
                'sakit_kuning' => 'nullable',
                'pendarahan_vagina' => 'nullable',
                'tumor' => 'nullable',
                'diabetes' => 'nullable',
                'pembekuan_darah' => 'nullable',
                'tindakan_ruang_tindakan' => 'nullable',
            ]);
            if ($request->has('tindakan_ruang_tindakan')) {
                $validated['tindakan_ruang_tindakan'] = implode(',', $request->tindakan_ruang_tindakan);
            }

            $validated['lingkar_lengan_atas'] = $validated['lingkar_lengan_atas'] ?? 0;
            $validated['usia_kehamilan'] = $validated['usia_kehamilan'] ?? 0;
            $validated['tinggi_fundus_uteri'] = $validated['tinggi_fundus_uteri'] ?? 0;
            $validated['denyut_jantung'] = $validated['denyut_jantung'] ?? 0;
            $validated['kaki_bengkak'] = $validated['kaki_bengkak'] ?? 0;
            $validated['imunisasi_tt'] = $validated['imunisasi_tt'] ?? 0;
            $validated['tablet_fe'] = $validated['tablet_fe'] ?? 0;
            $validated['proteinuria'] = $validated['proteinuria'] ?? 0;
            $validated['periksa_usg'] = $validated['periksa_usg'] ?? 0;
            $action->update($validated);
            // dd($validated);

            Log::info('Memulai update data tindakan', ['update_data' => $validated]);

            $action->update($validated);

            Log::info("Update berhasil untuk Action ID: $id");
            $medications = json_decode($request->medications, true);
            // dd($request->medications);
            $validated['alergi'] = $medications[0]['alergi'] ?? null;
            $validated['usia_kehamilan'] = $medications[0]['hamil'] ?? 0;
            $validated['gangguan_ginjal'] = $medications[0]['gangguan_ginjal'] ?? null;
            $validated['menyusui'] = $medications[0]['menyusui'] ?? 0;
            // dd($validated);
            if ($request->has('tindakan_ruang_tindakan')) {
                $validated['tindakan_ruang_tindakan'] = implode(',', $request->tindakan_ruang_tindakan);
            }
            if ($request->has('tindakan')) {
                $validated['tindakan'] = implode(',', $request->tindakan);
            }
            if ($id != null) {
                // Jika ID diberikan, update data yang sudah ada
                $action = Action::find($id);
                if (!empty($request->jenis_pemeriksaan)) {
                    HasilLab::create([
                        'id_action' => $action->id,
                        'jenis_pemeriksaan' => json_encode($request->jenis_pemeriksaan), // Simpan sebagai JSON
                    ]);
                }
                $medications = json_decode($request->medications, true);
                // dd($medications);

                // Ensure medications is an array before using foreach
                if (is_array($medications)) {
                    foreach ($medications as $medication) {
                        // Process each medication
                        $shapes = [
                            'Tablet' => 1,
                            'Botol' => 2,
                            'Pcs' => 3,
                            'Suppositoria' => 4,
                            'Ovula' => 5,
                            'Drop' => 6,
                            'Tube' => 7,
                            'Pot' => 8,
                            'Injeksi' => 9,
                            'Kapsul' => 10,
                            'Ampul' => 11,
                            'Sachet' => 12,
                            'Paket' => 13,
                            'Vial' => 14,
                            'Bungkus' => 15,
                            'Strip' => 16,
                            'Test' => 17,
                            'Lbr' => 18,
                            'Tabung' => 19,
                            'Buah' => 20,
                            'Lembar' => 21,
                        ];

                        ActionObat::create([
                            'id_action' => $action->id,
                            'number' => $medication['number'],
                            'name' => $medication['name'],
                            'dose' => $medication['dose'],
                            'amount' => $medication['quantity'],
                            'shape' => $shapes[$medication['shape']] ?? null, // Konversi teks ke angka
                            'id_obat' => $medication['idObat'],
                        ]);

                        $obats = TerimaObat::where('id_obat', $medication['idObat'])->get();

                        if ($obats->isEmpty()) {
                            return response()->json(['error' => 'Obat tidak ditemukan'], 404);
                        }

                        $remainingQuantity = $medication['quantity'];

                        foreach ($obats as $obat) {
                            if ($remainingQuantity <= 0) {
                                break; // Jika sudah cukup, keluar dari loop
                            }

                            if ($obat->amount >= $remainingQuantity) {
                                $obat->amount -= $remainingQuantity;
                                $obat->save();
                                $remainingQuantity = 0; // Semua jumlah sudah dikurangi
                            } else {
                                $remainingQuantity -= $obat->amount;
                                $obat->amount = 0;
                                $obat->save();
                            }
                        }

                        if ($remainingQuantity > 0) {
                            return response()->json(['error' => 'Stok tidak mencukupi'], 400);
                        }
                    }
                }

                if (!$action) {
                    return response()->json(['error' => 'Action not found'], 404);
                }
                $action->update($validated);
                return response()->json(['success' => 'Action has been successfully updated.']);
            } else {
                $medications = json_decode($request->medications, true);

                // Jika tidak ada ID, buat data baru
                $action = Action::create($validated);
                if (!empty($request->jenis_pemeriksaan)) {
                    HasilLab::create([
                        'id_action' => $action->id,
                        'jenis_pemeriksaan' => json_encode($request->jenis_pemeriksaan), // Simpan sebagai JSON
                    ]);
                }

                // Ensure medications is an array before using foreach
                if (is_array($medications)) {
                    foreach ($medications as $medication) {
                        // Process each medication
                        $shapes = [
                            'Tablet' => 1,
                            'Botol' => 2,
                            'Pcs' => 3,
                            'Suppositoria' => 4,
                            'Ovula' => 5,
                            'Drop' => 6,
                            'Tube' => 7,
                            'Pot' => 8,
                            'Injeksi' => 9,
                            'Kapsul' => 10,
                            'Ampul' => 11,
                            'Sachet' => 12,
                            'Paket' => 13,
                            'Vial' => 14,
                            'Bungkus' => 15,
                            'Strip' => 16,
                            'Test' => 17,
                            'Lbr' => 18,
                            'Tabung' => 19,
                            'Buah' => 20,
                            'Lembar' => 21,
                        ];

                        ActionObat::create([
                            'id_action' => $action->id,
                            'number' => $medication['number'],
                            'name' => $medication['name'],
                            'dose' => $medication['dose'],
                            'amount' => $medication['quantity'],
                            'shape' => $shapes[$medication['shape']] ?? null, // Konversi teks ke angka
                            'id_obat' => $medication['idObat'],
                        ]);

                        $obats = TerimaObat::where('id_obat', $medication['idObat'])->get();

                        if ($obats->isEmpty()) {
                            return response()->json(['error' => 'Obat tidak ditemukan'], 404);
                        }

                        $remainingQuantity = $medication['quantity'];

                        foreach ($obats as $obat) {
                            if ($remainingQuantity <= 0) {
                                break; // Jika sudah cukup, keluar dari loop
                            }

                            if ($obat->amount >= $remainingQuantity) {
                                $obat->amount -= $remainingQuantity;
                                $obat->save();
                                $remainingQuantity = 0; // Semua jumlah sudah dikurangi
                            } else {
                                $remainingQuantity -= $obat->amount;
                                $obat->amount = 0;
                                $obat->save();
                            }
                        }

                        if ($remainingQuantity > 0) {
                            return response()->json(['error' => 'Stok tidak mencukupi'], 400);
                        }
                    }
                }
                return response()->json(['success' => 'Action has been successfully created.', 'data' => $action]);
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }
    public function updateLab(Request $request, $id)
    {
        try {
            $action = Action::findOrFail($id);
            $patient = Patients::where('nik', $request->nik)->first();

            if (!$patient) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Patient with the provided NIK does not exist.',
                        'errors' => ['nik' => 'Patient with the provided NIK does not exist.'],
                    ],
                    422,
                );
            }

            $request->merge([
                'id_patient' => $patient->id,
            ]);

            $validated = $request->validate([
                'id_patient' => 'required',
                'hasil_lab' => 'nullable|string',
                'gds' => 'nullable|string',
                'gdp' => 'nullable|string',
                'gdp_2_jam_pp' => 'nullable|string',
                'cholesterol' => 'nullable|string',
                'asam_urat' => 'nullable|string',
                'leukosit' => 'nullable|string',
                'eritrosit' => 'nullable|string',
                'trombosit' => 'nullable|string',
                'hemoglobin' => 'nullable|string',
                'sifilis' => 'nullable|string',
                'hiv' => 'nullable|string',
                'golongan_darah' => 'nullable|string',
                'widal' => 'nullable|string',
                'malaria' => 'nullable|string',
                'albumin' => 'nullable|string',
                'reduksi' => 'nullable|string',
                'urinalisa' => 'nullable|string',
                'tes_kehamilan' => 'nullable|string',
                'telur_cacing' => 'nullable|string',
                'bta' => 'nullable|string',
                'tcm' => 'nullable|string',
                'igm_dbd' => 'nullable|string',
                'igm_typhoid' => 'nullable|string',
            ]);

            $hasilLab = HasilLab::where('id_action', $id)->first();

            if (!$hasilLab) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Hasil lab not found.',
                    ],
                    404,
                );
            }

            foreach ($validated as $key => $value) {
                if (in_array($key, ['gds', 'gdp', 'gdp_2_jam_pp', 'cholesterol', 'asam_urat', 'leukosit', 'eritrosit', 'trombosit', 'hemoglobin', 'sifilis', 'hiv', 'golongan_darah', 'widal', 'malaria', 'albumin', 'reduksi', 'urinalisa', 'tes_kehamilan', 'telur_cacing', 'bta', 'tcm', 'igm_dbd', 'igm_typhoid']) && $request->has($key)) {
                    $hasilLab->$key = $value;
                }
            }

            $hasilLab->save();
            $action->update($validated);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Action has been successfully updated.',
                    'data' => [
                        'action' => $action,
                        'hasil_lab' => $hasilLab,
                    ],
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'An error occurred.',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }
    public function updateLabEdit(Request $request, $id)
    {
        try {
            $action = Action::findOrFail($id);
            $patient = Patients::where('nik', $request->nik)->first();

            if (!$patient) {
                return redirect()
                    ->back()
                    ->withErrors(['nik' => 'Patient with the provided NIK does not exist.'])
                    ->withInput();
            }

            $request->merge([
                'id_patient' => $patient->id,
            ]);

            $validated = $request->validate([
                'id_patient' => 'required',
                'hasil_lab' => 'nullable|string',
                'gds' => 'nullable|string',
                'gdp' => 'nullable|string',
                'gdp_2_jam_pp' => 'nullable|string',
                'cholesterol' => 'nullable|string',
                'asam_urat' => 'nullable|string',
                'leukosit' => 'nullable|string',
                'eritrosit' => 'nullable|string',
                'trombosit' => 'nullable|string',
                'hemoglobin' => 'nullable|string',
                'sifilis' => 'nullable|string',
                'hiv' => 'nullable|string',
                'golongan_darah' => 'nullable|string',
                'widal' => 'nullable|string',
                'malaria' => 'nullable|string',
                'albumin' => 'nullable|string',
                'reduksi' => 'nullable|string',
                'urinalisa' => 'nullable|string',
                'tes_kehamilan' => 'nullable|string',
                'telur_cacing' => 'nullable|string',
                'bta' => 'nullable|string',
                'tcm' => 'nullable|string',
                'igm_dbd' => 'nullable|string',
                'igm_typhoid' => 'nullable|string',
            ]);

            $hasilLab = HasilLab::where('id_action', $id)->first();

            if (!$hasilLab) {
                return redirect()->back()->with('error', 'Hasil lab not found.');
            }

            foreach ($validated as $key => $value) {
                if (in_array($key, ['gds', 'gdp', 'gdp_2_jam_pp', 'cholesterol', 'asam_urat', 'leukosit', 'eritrosit', 'trombosit', 'hemoglobin', 'sifilis', 'hiv', 'golongan_darah', 'widal', 'malaria', 'albumin', 'reduksi', 'urinalisa', 'tes_kehamilan', 'telur_cacing', 'bta', 'tcm', 'igm_dbd', 'igm_typhoid']) && $request->has($key)) {
                    $hasilLab->$key = $value;
                }
            }

            $hasilLab->save();
            $action->update($validated);

            return redirect()->back()->with('success', 'Data lab berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function updateApotik(Request $request, $id)
    {
        try {
            $action = Action::findOrFail($id);

            $patient = Patients::where('nik', $request->nik)->first();

            if (!$patient) {
                return response()->json(['error' => 'Patient with the provided NIK does not exist.'], 404);
            }

            $request->merge([
                'id_patient' => $patient->id,
            ]);

            $validated = $request->validate([
                'id_patient' => 'required',
                'update_obat' => 'nullable',
                'verifikasi_awal' => 'array',
                'verifikasi_akhir' => 'array',
                'informasi_obat' => 'array',
                'diagnosa' => 'array',
            ]);

            $action->update($validated);
            $medications = json_decode($request->medications, true);

            $validated['alergi'] = $medications[0]['alergi'] ?? null;
            $validated['usia_kehamilan'] = $medications[0]['hamil'] ?? 0;
            $validated['gangguan_ginjal'] = $medications[0]['gangguan_ginjal'] ?? null;
            $validated['menyusui'] = (int) ($medications[0]['menyusui'] ?? 0);

            if (!empty($request->jenis_pemeriksaan)) {
                HasilLab::create([
                    'id_action' => $action->id,
                    'jenis_pemeriksaan' => json_encode($request->jenis_pemeriksaan),
                ]);
            }

            if (is_array($medications)) {
                foreach ($medications as $medication) {
                    if ($medication['idObat'] == null) {
                        continue;
                    }
                    $shapes = [
                        'Tablet' => 1,
                        'Botol' => 2,
                        'Pcs' => 3,
                        'Suppositoria' => 4,
                        'Ovula' => 5,
                        'Drop' => 6,
                        'Tube' => 7,
                        'Pot' => 8,
                        'Injeksi' => 9,
                        'Kapsul' => 10,
                        'Ampul' => 11,
                        'Sachet' => 12,
                        'Paket' => 13,
                        'Vial' => 14,
                        'Bungkus' => 15,
                        'Strip' => 16,
                        'Test' => 17,
                        'Lbr' => 18,
                        'Tabung' => 19,
                        'Buah' => 20,
                        'Lembar' => 21,
                    ];
                    $userRole = Auth::user()->role;

                    $actionObat = ActionObat::create([
                        'id_action' => $action->id,
                        'number' => $medication['number'],
                        'name' => $medication['name'],
                        'dose' => $medication['dose'],
                        'amount' => $medication['quantity'],
                        'shape' => $shapes[$medication['shape']] ?? null,
                        'id_obat' => $medication['idObat'],
                        'created_by' => $userRole,
                    ]);

                    $obats = TerimaObat::where('id_obat', $medication['idObat'])->get();

                    if ($obats->isEmpty()) {
                        return response()->json(['error' => 'Obat tidak ditemukan'], 404);
                    }

                    $remainingQuantity = $medication['quantity'];

                    foreach ($obats as $obat) {
                        if ($remainingQuantity <= 0) {
                            break;
                        }

                        if ($obat->amount >= $remainingQuantity) {
                            $obat->amount -= $remainingQuantity;
                            $obat->save();
                            $remainingQuantity = 0;
                        } else {
                            $remainingQuantity -= $obat->amount;
                            $obat->amount = 0;
                            $obat->save();
                        }
                    }

                    if ($remainingQuantity > 0) {
                        return response()->json(['error' => 'Stok tidak mencukupi'], 400);
                    }
                }
            }

            $action->update($validated);

            return response()->json(['success' => 'Action has been successfully updated.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function indexApotik(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $poli = $request->input('poli');

            $actionsQuery = Action::with(['patient', 'actionObats.obat'])->where(function ($q) {
                $q->WhereHas('actionObats')->WhereNotNull('verifikasi_awal');
            });

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }
            if ($poli) {
                $actionsQuery->where('tipe', $poli);
            }

            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
                ->addIndexColumn()
                ->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
                ->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
                ->addColumn('patient_name', fn($row) => optional($row->patient)->name)
                ->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
                ->addColumn('obat', function ($row) {
                    $doctorRole = 'dokter';
                    $tindakanRole = 'tindakan';

                    if ($row->actionObats->isNotEmpty()) {
                        $medications = $row->actionObats
                            ->filter(function ($ao) use ($doctorRole, $tindakanRole) {
                                return $ao->created_by == $doctorRole || $ao->created_by == null || $ao->created_by == $tindakanRole;
                            })
                            ->map(function ($ao) {
                                return optional($ao->obat)->name;
                            })
                            ->filter()
                            ->implode(', ');

                        return $medications ?: '-';
                    }

                    return '-';
                })

                ->addColumn('update_obat', function ($row) {
                    $apotikRole = 'apotik';

                    if ($row->actionObats->isNotEmpty()) {
                        $medications = $row->actionObats
                            ->filter(function ($ao) use ($apotikRole) {
                                return $ao->created_by == $apotikRole;
                            })
                            ->map(function ($ao) {
                                return optional($ao->obat)->name;
                            })
                            ->filter()
                            ->implode(', ');

                        return $medications ?: '-';
                    }

                    return '-';
                })
                ->addColumn('tipe', function ($row) {
                    if ($row->tipe === 'poli-umum') {
                        return 'Poli Umum';
                    } elseif ($row->tipe === 'poli-kb') {
                        return 'Poli KB';
                    } elseif ($row->tipe === 'poli-kia') {
                        return 'Poli KIA';
                    } elseif ($row->tipe === 'ruang-tindakan') {
                        return 'UGD';
                    } else {
                        return 'Poli Gigi';
                    }
                })

                ->addColumn('action', function ($row) {
                    // Get the doctor list
                    $dokter = User::where('role', 'dokter')->get();
                    $routeName = request()->route()->getName();
                    $rs = Hospital::all();
                    $obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();
                    // Render modal edit with route name
                    $editModal = view('component.modal-edit-action-apotik', ['action' => $row, 'routeName' => $routeName, 'dokter' => $dokter, 'rs' => $rs, 'obats' => $obats])->render();

                    return '<div class="d-grid gap-2 d-md-block">
                <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editActionModal' .
                        $row->id .
                        '">
                        <i class="fas fa-edit"></i>
                    </button>
                    <a class="btn btn-warning" style="padding:6px; padding-right: 13px;" href="' . route('print-prescription', ['id' => $row->id]) . '" role="button" target="_blank"><i class="fas fa-print ms-2"></i></a>
            </div>' .
                        $editModal;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Non-AJAX request handling
        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::all();
        $penyakit = Disease::all();
        $rs = Hospital::all();
        $routeName = $request->route()->getName();
        $obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();

        return view('content.action.index-apotik', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName', 'obats'));
    }
    public function destroy($id)
    {
        try {
            $action = Action::findOrFail($id);
            $action->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    public function destroyPatientAction(Request $request)
    {
        try {
            if (!$request->has('idPasien') || !$request->has('tanggal')) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Tanggal atau ID Pasien tidak diberikan.',
                    ],
                    400,
                );
            }

            if ($request->id) {
                $action = Action::where('id', $request->id)->whereDate('tanggal', $request->tanggal)->first();

                if (!$action) {
                    return response()->json(
                        [
                            'success' => false,
                            'message' => 'Data tindakan tidak ditemukan.',
                        ],
                        404,
                    );
                }

                $action->delete();
            }

            $kunjungan = Kunjungan::where('pasien', $request->idPasien)->whereDate('tanggal', $request->tanggal)->first();

            if (!$kunjungan) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Data kunjungan tidak ditemukan.',
                    ],
                    404,
                );
            }

            $kunjungan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function sendToSatuSehat(Request $request)
    {
        $successActions = [];
        $failedActions = [];
        // dd($request->actions);
        foreach ($request->actions as $actionId) {
            try {
                if (SatuSehatEncounter::where('action_id', $actionId)->exists()) {
                    \Log::info("Action ID $actionId sudah pernah dikirim, skip.");
                    $failedActions[] = [
                        'action_id' => $actionId,
                        'reason' => 'Sudah pernah dikirim',
                    ];
                    continue;
                }

                $action = Action::findOrFail($actionId);
                $docter = User::where('name', $action->doctor)->first();

                $patientSatuSehat = SatuSehatHelper::getPatientByNik($action->patient->nik);
                $docterSatuSehat = SatuSehatHelper::getDocterByNik($docter->nik);

                $currentTime = Carbon::now()->subHours(8); // UTC offset
                $formattedTime = $currentTime->format('Y-m-d\TH:i:s\+00:00');

                $locationReference = 'Location/26f39285-649e-4d6e-b8e5-ed54013082a0';
                $locationDisplay = 'Ruang Poli Gigi';

                if ($action->tipe == 'poli-gigi') {
                    $locationReference = 'Location/26f39285-649e-4d6e-b8e5-ed54013082a0';
                    $locationDisplay = 'Ruang Poli Gigi';
                }
                else if ($action->tipe == 'poli-umum') {
                    $locationReference = 'Location/0d2f9518-a37f-43e2-bfa6-0e6999f69bc4';
                    $locationDisplay = 'Ruang Poli Umum';
                }
                else if ($action->tipe == 'poli-kia') {
                    $locationReference = 'Location/a7c53d57-e940-4601-84f2-1e0be61e4638';
                    $locationDisplay = 'Ruang Poli Kia';
                }
                else if ($action->tipe == 'poli-kb') {
                    $locationReference = 'Location/3933c54e-14f7-4233-bcd9-2f71a8cdf651';
                    $locationDisplay = 'Ruang Poli Kb';
                }
                else if ($action->tipe == 'ruang-tindakan') {
                    $locationReference = 'Location/4185d73b-62e2-4bbb-80c9-578e65c2b567';
                    $locationDisplay = 'Ruang UGD';
                }
                else if ($action->tipe == 'tindakan') {
                    $locationReference = 'Location/a711d42b-b946-48a7-97c1-e6c22c1d558d';
                    $locationDisplay = 'Ruang Tindakan';
                }

                $encounterBody = [
                    'resourceType' => 'Encounter',
                    'identifier' => [
                        [
                            'system' => 'http://sys-ids.kemkes.go.id/encounter/' . env('Organization_ID_SANDBOX'),
                            'value' => (string) $action->id . '-' . now()->format('d-m-Y'),
                        ],
                    ],
                    'status' => 'arrived',
                    'class' => [
                        'system' => 'http://terminology.hl7.org/CodeSystem/v3-ActCode',
                        'code' => 'AMB',
                        'display' => 'ambulatory',
                    ],
                    'subject' => [
                        'reference' => 'Patient/' . $patientSatuSehat['id'],
                        'display' => $action->patient->name,
                    ],
                    'participant' => [
                        [
                            'type' => [
                                [
                                    'coding' => [
                                        [
                                            'system' => 'http://terminology.hl7.org/CodeSystem/v3-ParticipationType',
                                            'code' => 'ATND',
                                            'display' => 'attender',
                                        ],
                                    ],
                                ],
                            ],
                            'individual' => [
                                'reference' => 'Practitioner/' . $docterSatuSehat['id'],
                                'display' => $docter->name,
                            ],
                        ],
                    ],
                    'period' => [
                        'start' => $formattedTime,
                    ],
                    'location' => [
                        [
                            'location' => [
                                'reference' => $locationReference,
                                'display' => $locationDisplay,
                            ],
                            'period' => [
                                'start' => $formattedTime,
                            ],
                            'extension' => [
                                [
                                    'url' => 'https://fhir.kemkes.go.id/r4/StructureDefinition/ServiceClass',
                                    'extension' => [
                                        [
                                            'url' => 'value',
                                            'valueCodeableConcept' => [
                                                'coding' => [
                                                    [
                                                        'system' => 'http://terminology.kemkes.go.id/CodeSystem/locationServiceClass-Outpatient',
                                                        'code' => 'reguler',
                                                        'display' => 'Kelas Reguler',
                                                    ],
                                                ],
                                            ],
                                        ],
                                        [
                                            'url' => 'upgradeClassIndicator',
                                            'valueCodeableConcept' => [
                                                'coding' => [
                                                    [
                                                        'system' => 'http://terminology.kemkes.go.id/CodeSystem/locationUpgradeClass',
                                                        'code' => 'kelas-tetap',
                                                        'display' => 'Kelas Tetap Perawatan',
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'statusHistory' => [
                        [
                            'status' => 'arrived',
                            'period' => [
                                'start' => $formattedTime,
                            ],
                        ],
                    ],
                    'serviceProvider' => [
                        'reference' => 'Organization/' . env('Organization_ID_SANDBOX'),
                    ],
                ];

                \Log::info('Request Body: ' . json_encode($encounterBody));

                $response = SatuSehatHelper::postEncounterToSatuSehat($encounterBody);

                if (($response['status'] ?? '') !== 'success') {
                    throw new \Exception('Gagal mengirim ke Satu Sehat');
                }

                SatuSehatEncounter::create([
                    'action_id' => $action->id,
                    'encounter_id' => $response['data']['id'] ?? null,
                ]);

                $successActions[] = $action->patient->nik;
                $action->update([
                    'status_satu_sehat' => 1,
                ]);
            } catch (\Exception $e) {
                \Log::error("Gagal kirim Action ID {$action->patient->nik}: " . $e->getMessage());
                $failedActions[] = [
                    'action_id' => $action->patient->nik,
                    'reason' => $e->getMessage(),
                ];
                continue;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Proses selesai',
            'sent' => $successActions,
            'failed' => $failedActions,
        ]);
    }
}
