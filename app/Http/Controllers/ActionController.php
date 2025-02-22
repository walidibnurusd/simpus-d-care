<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Diagnosis;
use App\Models\Disease;
use App\Models\Doctor;
use App\Models\Kia;
use App\Models\User;
use App\Models\Hospital;
use App\Models\Patients;
use App\Models\Kunjungan;
use App\Models\HasilLab;
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

        return view('content.action.index', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $actionsQuery = Action::with(['patient', 'hospitalReferral'])->where('tipe', 'poli-umum'); // Ensure 'diagnosa' is not null

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

        $actions = $actionsQuery->get();

        return DataTables::of($actions)
            ->addIndexColumn()
            ->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
            ->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
            ->addColumn('patient_name', fn($row) => optional($row->patient)->name)
            ->addColumn('kartu', fn($row) => optional($row->patient)->jenis_kartu)
            ->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
            ->addColumn('diagnosa', function ($row) {
                if (!is_string($row->diagnosa)) {
                    return '-';
                }
                $diagnosaIds = explode(',', $row->diagnosa);
                $diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();
                return implode(', ', $diagnoses);
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

                // Render modal edit with route name
                $editModal = view('component.modal-edit-action', ['rs' => $rs, 'action' => $row, 'routeName' => $routeName, 'dokter' => $dokter])->render();

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

    public function indexPoliGigi(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $actionsQuery = Action::with(['patient', 'hospitalReferral'])->where('tipe', 'poli-gigi'); // Ensure 'diagnosa' is not null

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }

            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
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

                    // Render modal edit with route name
                    $editModal = view('component.modal-edit-action', ['rs' => $rs, 'action' => $row, 'routeName' => $routeName, 'dokter' => $dokter])->render();

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

        return view('content.action.index', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexUgd(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $actionsQuery = Action::with(['patient', 'hospitalReferral'])->where('tipe', 'ruang-tindakan'); // Ensure 'diagnosa' is not null

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }

            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
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

                    // Render modal edit with route name
                    $editModal = view('component.modal-edit-action', ['rs' => $rs, 'action' => $row, 'routeName' => $routeName, 'dokter' => $dokter])->render();

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

        return view('content.action.index', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexDokter(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
            $endDate = $request->input('end_date') ?? Carbon::today()->toDateString();

            $actionsQuery = Action::with(['patient', 'hospitalReferral', 'hasilLab'])
                ->where('tipe', 'poli-umum')
                ->whereNotNull('diagnosa');

            $actionsQuery->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate);

            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
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

                ->addColumn('kunjungan', function ($row) {
                    $kunjunganCount = Kunjungan::where('pasien', $row->id_patient)->count();

                    return $kunjunganCount == 1 ? 'Baru' : 'Lama';
                })

                ->addColumn('action', function ($row) {
                    $dokter = User::where('role', 'dokter')->get();
                    $rs = Hospital::all();
                    $routeName = request()->route()->getName();
                    $editModal = view('component.modal-edit-action', ['action' => $row, 'routeName' => $routeName, 'dokter' => $dokter, 'rs' => $rs])->render();
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

        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::all();
        $penyakit = Disease::all();
        $rs = Hospital::all();
        $routeName = $request->route()->getName();
        // dd(  $routeName);

        return view('content.action.index-dokter', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }

    public function indexGigiDokter(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
            $endDate = $request->input('end_date') ?? Carbon::today()->toDateString();

            $actionsQuery = Action::with(['patient', 'hospitalReferral', 'hasilLab'])
                ->where('tipe', 'poli-gigi') // Adjust the type to 'poli-gigi'
                ->whereNotNull('diagnosa'); // Ensure 'diagnosa' is not null

            $actionsQuery->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate);

            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
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
                    $rs = Hospital::all();
                    $dokter = User::where('role', 'dokter')->get();
                    $routeName = request()->route()->getName();

                    // Render modal edit with route name
                    $editModal = view('component.modal-edit-action', ['rs' => $rs, 'action' => $row, 'routeName' => $routeName, 'dokter' => $dokter])->render();

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

        // For the non-AJAX case, provide the necessary data for the view
        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::all();
        $penyakit = Disease::all();
        $rs = Hospital::all();
        $routeName = $request->route()->getName();

        return view('content.action.index-dokter', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }

    public function indexUgdDokter(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
            $endDate = $request->input('end_date') ?? Carbon::today()->toDateString();

            $actionsQuery = Action::with(['patient', 'hospitalReferral', 'hasilLab'])
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

                    // Render modal edit with route name
                    $editModal = view('component.modal-edit-action', ['action' => $row, 'routeName' => $routeName, 'dokter' => $dokter, 'rs' => $rs])->render();

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

        return view('content.action.index-dokter', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexRuangTindakanDokter(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
            $endDate = $request->input('end_date') ?? Carbon::today()->toDateString();

            $actionsQuery = Action::with(['patient', 'hospitalReferral'])->whereNotNull('tindakan_ruang_tindakan');

            $actionsQuery->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate);

            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
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
                    $dokter = User::where('role', 'dokter')->get();
                    $routeName = request()->route()->getName();
                    $rs = Hospital::all();

                    // Render modal edit with route name
                    $editModal = view('component.modal-edit-action', ['action' => $row, 'routeName' => $routeName, 'dokter' => $dokter, 'rs' => $rs])->render();

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

        return view('content.action.index-dokter', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
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
                $q->whereNotNull('gdp')->orWhereNotNull('gdp_2_jam_pp')->orWhereNotNull('cholesterol')->orWhereNotNull('asam_urat')->orWhereNotNull('leukosit')->orWhereNotNull('eritrosit')->orWhereNotNull('trombosit')->orWhereNotNull('hemoglobin')->orWhereNotNull('sifilis')->orWhereNotNull('hiv')->orWhereNotNull('golongan_darah')->orWhereNotNull('widal')->orWhereNotNull('malaria')->orWhereNotNull('albumin')->orWhereNotNull('reduksi')->orWhereNotNull('urinalisa')->orWhereNotNull('tes_kehamilan')->orWhereNotNull('telur_cacing')->orWhereNotNull('bta')->orWhereNotNull('igm_dbd')->orWhereNotNull('igm_typhoid');
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

        $actions = $actionsQuery->get();

        $routeName = $request->route()->getName();
        return view('content.action.index-lab', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }

    // public function indexDokterKia(Request $request)
    // {
    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');
    //     $dokter = User::where('role', 'dokter')->get();
    //     $actionsQuery = Action::where('tipe', 'poli-kia')->where('usia_kehamilan', '!=', 0);
    //     if ($startDate) {
    //         $actionsQuery->whereDate('tanggal', '>=', $startDate);
    //     }

    //     if ($endDate) {
    //         $actionsQuery->whereDate('tanggal', '<=', $endDate);
    //     }

    //   $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

    // $actions = $actionsQuery->get();
    //     $routeName = $request->route()->getName();
    //     return view('content.action.index-lab', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    // }
    public function indexDokterKia(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
            $endDate = $request->input('end_date') ?? Carbon::today()->toDateString();

            $actionsQuery = Action::with(['patient', 'hospitalReferral', 'hasilLab'])
                ->where('tipe', 'poli-kia') // Filter by type for KIA
                ->whereNotNull('diagnosa'); // Ensure diagnosa exists

            $actionsQuery->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate);
            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
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

                    // Render modal for edit
                    $editModal = view('component.modal-edit-action-kia', ['action' => $row, 'routeName' => $routeName, 'dokter' => $dokter, 'rs' => $rs])->render();

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

        return view('content.action.index-kia', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }

    public function indexDokterKb(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
            $endDate = $request->input('end_date') ?? Carbon::today()->toDateString();

            $actionsQuery = Action::with(['patient', 'hospitalReferral', 'hasilLab'])
                ->where('tipe', 'poli-kb') // Filter by type for KB
                ->whereNotNull('diagnosa'); // Filter for actions that have 'layanan_kb'

            $actionsQuery->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate);

            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
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

                    // Render modal for edit
                    $editModal = view('component.modal-edit-action-kb', ['action' => $row, 'routeName' => $routeName, 'dokter' => $dokter, 'rs' => $rs])->render();

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

        return view('content.action.index-kb', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }

    public function indexKia(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $actionsQuery = Action::with(['patient', 'hospitalReferral'])->where('tipe', 'poli-kia'); // Ensure 'diagnosa' is not null

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }

            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
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

                    // Render modal edit with route name
                    $editModal = view('component.modal-edit-action', ['rs' => $rs, 'action' => $row, 'routeName' => $routeName, 'dokter' => $dokter])->render();

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

        return view('content.action.index', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexKb(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $actionsQuery = Action::with(['patient', 'hospitalReferral'])->where('tipe', 'poli-kb'); // Ensure 'diagnosa' is not null

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }

            $actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
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

                    // Render modal edit with route name
                    $editModal = view('component.modal-edit-action', ['rs' => $rs, 'action' => $row, 'routeName' => $routeName, 'dokter' => $dokter])->render();

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

        return view('content.action.index', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function actionReport(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Action::query();

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        } else {
            $startDate = Action::min('tanggal');
            $endDate = Action::max('tanggal');
        }
        $query->orderBy('tanggal', 'asc');

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
            $action = Action::create($validated);
            if (!empty($request->jenis_pemeriksaan)) {
                HasilLab::create([
                    'id_action' => $action->id,
                    'jenis_pemeriksaan' => json_encode($request->jenis_pemeriksaan), // Simpan sebagai JSON
                ]);
            }
            return response()->json(['success' => 'Action has been successfully created.', 'data' => $action]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Find the action record to be updated
            $action = Action::findOrFail($id);

            // Fetch the patient ID based on the provided NIK
            $patient = Patients::where('nik', $request->nikEdit)->first();

            if (!$patient) {
                return redirect()
                    ->back()
                    ->withErrors(['nik' => 'Patient with the provided NIK does not exist.'])
                    ->withInput();
            }

            Log::info('NIK provided:', ['nik' => $request->nikEdit]);

            // Format the date and merge the patient ID into the request
            $request->merge([
                'id_patient' => $patient->id,
            ]);

            // Validate the request
            $validated = $request->validate([
                'id_patient' => 'required|exists:patients,id',
                'tanggal' => 'required|date',
                'doctor' => 'required',
                'kasus' => 'nullable|string|max:255',
                'faskes' => 'nullable|string|max:255',
                'sistol' => 'nullable|numeric',
                'diastol' => 'nullable|numeric',
                'beratBadan' => 'nullable|numeric',
                'tinggiBadan' => 'nullable|numeric',
                'lingkarPinggang' => 'nullable|numeric',
                'riwayat_penyakit_sekarang' => 'nullable',
                'riwayat_penyakit_dulu' => 'nullable',
                'riwayat_penyakit_lainnya' => 'nullable',
                'riwayat_penyakit_keluarga' => 'nullable',
                'riwayat_penyakit_lainnya_keluarga' => 'nullable',
                'riwayat_pengobatan' => 'nullable',
                'riwayat_alergi' => 'nullable',
                'keluhan' => 'nullable|string|max:255',
                'diagnosa' => 'nullable',
                'tindakan' => 'nullable',
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
                'pemeriksaan_penunjang' => 'nullable',
                'usia_kehamilan' => 'nullable',
                'jenis_anc' => 'nullable',
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
                'nilai_hb' => 'nullable',
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
                'beri_tindakan' => 'nullable',
                'tindakan_ruang_tindakan' => 'nullable',
            ]);
            if ($request->has('tindakan_ruang_tindakan')) {
                $validated['tindakan_ruang_tindakan'] = implode(',', $request->tindakan_ruang_tindakan);
            }
            if ($request->has('tindakan')) {
                $validated['tindakan'] = implode(',', $request->tindakan);
            }
            $validatedData['lingkar_lengan_atas'] = $validatedData['lingkar_lengan_atas'] ?? 0;
            $validatedData['usia_kehamilan'] = $validatedData['usia_kehamilan'] ?? 0;
            $validatedData['tinggi_fundus_uteri'] = $validatedData['tinggi_fundus_uteri'] ?? 0;
            $validatedData['denyut_jantung'] = $validatedData['denyut_jantung'] ?? 0;
            $validatedData['kaki_bengkak'] = $validatedData['kaki_bengkak'] ?? 0;
            $validatedData['imunisasi_tt'] = $validatedData['imunisasi_tt'] ?? 0;
            $validatedData['tablet_fe'] = $validatedData['tablet_fe'] ?? 0;
            $validatedData['proteinuria'] = $validatedData['proteinuria'] ?? 0;
            $validatedData['periksa_usg'] = $validatedData['periksa_usg'] ?? 0;
            // Update the action with the validated data
            // Update the action with the validated data
            if (!empty($request->jenis_pemeriksaan)) {
                // Cek apakah HasilLab dengan id_action sudah ada
                $hasilLab = HasilLab::where('id_action', $action->id)->first();

                if ($hasilLab) {
                    // Jika sudah ada, update jenis_pemeriksaan
                    $hasilLab->update([
                        'jenis_pemeriksaan' => json_encode($request->jenis_pemeriksaan), // Update sebagai JSON
                    ]);
                } else {
                    // Jika belum ada, buat entri baru
                    HasilLab::create([
                        'id_action' => $action->id,
                        'jenis_pemeriksaan' => json_encode($request->jenis_pemeriksaan), // Simpan sebagai JSON
                    ]);
                }
            }
            $action->update($validated);

            return redirect()->back()->with('success', 'Action has been successfully updated.');
        } catch (\Exception $e) {
            Log::error('Error in updating action: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
            ]);

            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
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
            ]);
            $validated['lingkar_lengan_atas'] = $validated['lingkar_lengan_atas'] ?? 0;
            $validated['usia_kehamilan'] = $validated['usia_kehamilan'] ?? 0;
            $validated['tinggi_fundus_uteri'] = $validated['tinggi_fundus_uteri'] ?? 0;
            $validated['denyut_jantung'] = $validated['denyut_jantung'] ?? 0;
            $validated['kaki_bengkak'] = $validated['kaki_bengkak'] ?? 0;
            $validated['imunisasi_tt'] = $validated['imunisasi_tt'] ?? 0;
            $validated['tablet_fe'] = $validated['tablet_fe'] ?? 0;
            $validated['proteinuria'] = $validated['proteinuria'] ?? 0;
            $validated['periksa_usg'] = $validated['periksa_usg'] ?? 0;
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

                if (!$action) {
                    return response()->json(['error' => 'Action not found'], 404);
                }
                $action->update($validated);
                return response()->json(['success' => 'Action has been successfully updated.']);
            } else {
                // Jika tidak ada ID, buat data baru
                $action = Action::create($validated);
                if (!empty($request->jenis_pemeriksaan)) {
                    HasilLab::create([
                        'id_action' => $action->id,
                        'jenis_pemeriksaan' => json_encode($request->jenis_pemeriksaan), // Simpan sebagai JSON
                    ]);
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

            return redirect()->route('action.dokter.ruang.tindakan.index')->with('success', 'Action tindakan has been successfully updated.');
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
            // Find the action record to be updated
            $action = Action::findOrFail($id);

            // Fetch the patient ID based on the provided NIK
            $patient = Patients::where('nik', $request->nik)->first();

            if (!$patient) {
                return redirect()
                    ->back()
                    ->withErrors(['nik' => 'Patient with the provided NIK does not exist.'])
                    ->withInput();
            }

            // Format the date and merge the patient ID into the request
            $request->merge([
                'id_patient' => $patient->id,
            ]);

            // dd($request->);
            // Validate the request
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
                'igm_dbd' => 'nullable|string',
                'igm_typhoid' => 'nullable|string',
            ]);
            $hasilLab = HasilLab::where('id_action', $id)->first();

            if ($request->has('gds')) {
                $hasilLab->gds = $request->gds;
            }
            if ($request->has('gdp')) {
                $hasilLab->gdp = $request->gdp;
            }
            if ($request->has('gdp_2_jam_pp')) {
                $hasilLab->gdp_2_jam_pp = $request->gdp_2_jam_pp;
            }
            if ($request->has('cholesterol')) {
                $hasilLab->cholesterol = $request->cholesterol;
            }
            if ($request->has('asam_urat')) {
                $hasilLab->asam_urat = $request->asam_urat;
            }
            if ($request->has('leukosit')) {
                $hasilLab->leukosit = $request->leukosit;
            }
            if ($request->has('eritrosit')) {
                $hasilLab->eritrosit = $request->eritrosit;
            }
            if ($request->has('trombosit')) {
                $hasilLab->trombosit = $request->trombosit;
            }
            if ($request->has('hemoglobin')) {
                $hasilLab->hemoglobin = $request->hemoglobin;
            }
            if ($request->has('sifilis')) {
                $hasilLab->sifilis = $request->sifilis;
            }
            if ($request->has('hiv')) {
                $hasilLab->hiv = $request->hiv;
            }
            if ($request->has('golongan_darah')) {
                $hasilLab->golongan_darah = $request->golongan_darah;
            }
            if ($request->has('widal')) {
                $hasilLab->widal = $request->widal;
            }
            if ($request->has('malaria')) {
                $hasilLab->malaria = $request->malaria;
            }
            if ($request->has('albumin')) {
                $hasilLab->albumin = $request->albumin;
            }
            if ($request->has('reduksi')) {
                $hasilLab->reduksi = $request->reduksi;
            }
            if ($request->has('urinalisa')) {
                $hasilLab->urinalisa = $request->urinalisa;
            }
            if ($request->has('tes_kehamilan')) {
                $hasilLab->tes_kehamilan = $request->tes_kehamilan;
            }
            if ($request->has('telur_cacing')) {
                $hasilLab->telur_cacing = $request->telur_cacing;
            }
            if ($request->has('bta')) {
                $hasilLab->bta = $request->bta;
            }
            if ($request->has('igm_dbd')) {
                $hasilLab->igm_dbd = $request->igm_dbd;
            }
            if ($request->has('igm_typhoid')) {
                $hasilLab->igm_typhoid = $request->igm_typhoid;
            }

            $hasilLab->save();

            $action->update($validated);

            return redirect()->back()->with('success', 'Action has been successfully updated.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }
    public function updateApotik(Request $request, $id)
    {
        try {
            // Find the action record to be updated
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
                'update_obat' => 'nullable',
            ]);

            $action->update($validated);

            return redirect()->back()->with('success', 'Action has been successfully updated.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }
    public function indexApotik(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $poli = $request->input('poli');

            $actionsQuery = Action::with(['patient'])->whereNotNull('obat');

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
                ->addColumn('obat', fn($row) => $row->obat)
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

                    // Render modal edit with route name
                    $editModal = view('component.modal-edit-action-apotik', ['action' => $row, 'routeName' => $routeName, 'dokter' => $dokter, 'rs' => $rs])->render();

                    return '<div class="action-buttons">
                <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editActionModal' .
                        $row->id .
                        '">
                        <i class="fas fa-edit"></i>
                    </button>
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

        return view('content.action.index-apotik', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
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
}
