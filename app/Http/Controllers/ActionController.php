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
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $actionsQuery = Action::with(['patient', 'hospitalReferral'])
                ->where('tipe', 'poli-umum')
                ->whereNotNull('diagnosa');

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }

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
                ->addColumn('action', function ($row) {
                    $dokter = User::where('role', 'dokter')->get();
                    $rs = Hospital::all();
                    // Menggunakan request() global untuk mendapatkan route name
                    $routeName = request()->route()->getName();
                    // Render modal edit dengan membawa routeName
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
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $actionsQuery = Action::with(['patient', 'hospitalReferral'])
                ->where('tipe', 'poli-gigi') // Adjust the type to 'poli-gigi'
                ->whereNotNull('diagnosa'); // Ensure 'diagnosa' is not null

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }

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
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $actionsQuery = Action::with(['patient', 'hospitalReferral'])
                ->where('tipe', 'ruang-tindakan') // Filter by type for UGDs
                ->whereNotNull('diagnosa');

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }

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
    public function indexRuangTindakanDokter(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $actionsQuery = Action::with(['patient', 'hospitalReferral'])->where('beri_tindakan', 1);

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }

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

        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::all();

        $penyakit = Disease::all();
        $rs = Hospital::all();
        $actionsQuery = Action::where('tipe', 'poli-umum')->whereNotNull('hasil_lab');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();

        $routeName = $request->route()->getName();
        return view('content.action.index-lab', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexGigiLab(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $dokter = User::where('role', 'dokter')->get();
        $diagnosa = Diagnosis::all();

        $penyakit = Disease::all();
        $rs = Hospital::all();

        $actionsQuery = Action::where('tipe', 'poli-gigi')->whereNotNull('hasil_lab');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();
        $routeName = $request->route()->getName();

        return view('content.action.index-lab', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }

    public function indexUgdLab(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dokter = User::where('role', 'dokter')->get();

        $diagnosa = Diagnosis::all();

        $penyakit = Disease::all();
        $rs = Hospital::all();
        $actionsQuery = Action::where('tipe', 'ruang-tindakan')->whereNotNull('hasil_lab');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();
        $routeName = $request->route()->getName();
        return view('content.action.index-lab', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexKiaLab(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dokter = User::where('role', 'dokter')->get();

        $diagnosa = Diagnosis::all();

        $penyakit = Disease::all();
        $rs = Hospital::all();
        $actionsQuery = Action::where('tipe', 'poli-kia')->whereNotNull('hasil_lab');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
        }

        $actions = $actionsQuery->get();
        $routeName = $request->route()->getName();
        return view('content.action.index-lab', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    }
    public function indexKbLab(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dokter = User::where('role', 'dokter')->get();

        $diagnosa = Diagnosis::all();

        $penyakit = Disease::all();
        $rs = Hospital::all();
        $actionsQuery = Action::where('tipe', 'poli-kb')->whereNotNull('hasil_lab');

        $diagnosa = Diagnosis::all();

        $penyakit = Disease::all();
        $rs = Hospital::all();
        $actionsQuery = Action::where('tipe', 'poli-kb')->whereNotNull('hasil_lab');

        if ($startDate) {
            $actionsQuery->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $actionsQuery->whereDate('tanggal', '<=', $endDate);
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

    //     $actions = $actionsQuery->get();
    //     $routeName = $request->route()->getName();
    //     return view('content.action.index-lab', compact('actions', 'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName'));
    // }
    public function indexDokterKia(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $actionsQuery = Action::with(['patient', 'hospitalReferral'])
                ->where('tipe', 'poli-kia') // Filter by type for KIA
                ->whereNotNull('diagnosa'); // Ensure diagnosa exists

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }

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
                ->rawColumns(['action'])
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
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $actionsQuery = Action::with(['patient', 'hospitalReferral'])
                ->where('tipe', 'poli-kb') // Filter by type for KB
                ->whereNotNull('diagnosa'); // Filter for actions that have 'layanan_kb'

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }

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
                ->rawColumns(['action'])
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
        // Ambil parameter filter awal dan akhir dari query string
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Query data dari tabel 'actions'
        $query = Action::query();

        // Jika filter tanggal diberikan, tambahkan kondisi ke query
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }

        // Eksekusi query untuk mendapatkan hasil
        $actions = $query->get();

        // Kirim data ke view
        return view('content.action.print', compact('actions'));
    }

    public function store(Request $request)
    {
        try {
            // Fetch the patient ID based on the provided NIK
            // dd($request->all());
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

            // Validate the request
            $validated = $request->validate([
                'id_patient' => 'required|exists:patients,id',
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
            ]);

            // Save the validated data into the actions table
            $action = Action::create($validated);
            if ($action->tipe === 'poli-umum') {
                $route = 'action.index';
            } elseif ($action->tipe === 'poli-gigi') {
                $route = 'action.index.gigi';
            } elseif ($action->tipe === 'poli-kia') {
                $route = 'action.kia.index';
            } elseif ($action->tipe === 'poli-kb') {
                $route = 'action.kb.index';
            } else {
                $route = 'action.index.ugd';
            }
            return redirect()->route($route)->with('success', 'Action has been successfully created.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
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

            // Format the date and merge the patient ID into the request
            $request->merge([
                'id_patient' => $patient->id,
            ]);

            // Validate the request
            $validated = $request->validate([
                'id_patient' => 'required|exists:patients,id',
                'tanggal' => 'required|date',
                'doctor' => 'required',
                'kunjungan' => 'nullable|string|max:255',
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
            ]);
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
            $action->update($validated);
            if (Auth::user()->role == 'dokter') {
                if ($action->tipe === 'poli-umum') {
                    $route = 'action.dokter.index';
                } elseif ($action->tipe === 'poli-gigi') {
                    $route = 'action.dokter.gigi.index';
                } elseif ($action->tipe === 'poli-kia') {
                    $route = 'action.kia.dokter.index';
                } elseif ($action->tipe === 'poli-kb') {
                    $route = 'action.kb.dokter.index';
                } else {
                    $route = 'action.dokter.ugd.index';
                }
            } elseif (Auth::user()->role == 'lab') {
                if ($action->tipe === 'poli-umum') {
                    $route = 'action.lab.index';
                } elseif ($action->tipe === 'poli-gigi') {
                    $route = 'action.lab.gigi.index';
                } elseif ($action->tipe === 'poli-kia') {
                    $route = 'action.lab.kia.index';
                } elseif ($action->tipe === 'poli-kb') {
                    $route = 'action.lab.kb.index';
                } else {
                    $route = 'action.lab.ugd.index';
                }
            } else {
                if ($action->tipe === 'poli-umum') {
                    $route = 'action.index';
                } elseif ($action->tipe === 'poli-gigi') {
                    $route = 'action.index.gigi';
                } elseif ($action->tipe === 'poli-kia') {
                    $route = 'action.kia.index';
                } elseif ($action->tipe === 'poli-kb') {
                    $route = 'action.kb.index';
                } else {
                    $route = 'action.index.ugd';
                }
            }
            return redirect()->route($route)->with('success', 'Action has been successfully updated.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }
    public function updateDokter(Request $request, $id)
    {
        try {
            $action = Action::find($id);
            if (!$action) {
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
            $action->update($validated);
            if ($action->tipe === 'poli-umum') {
                $route = 'action.dokter.index';
            } elseif ($action->tipe === 'poli-gigi') {
                $route = 'action.dokter.gigi.index';
            } elseif ($action->tipe === 'poli-kia') {
                $route = 'action.kia.dokter.index';
            } elseif ($action->tipe === 'poli-kb') {
                $route = 'action.kb.dokter.index';
            } elseif ($action->tipe == 'ruang-tindakan') {
                $route = 'action.dokter.ugd.index';
            } else {
                $route = 'action.dokter.ruang.tindakan.index';
            }

            return redirect()->route($route)->with('success', 'Action has been successfully updated.');
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
                'hasil_lab' => 'nullable',
            ]);

            $action->update($validated);
            if ($action->tipe === 'poli-umum') {
                $route = 'action.lab.index';
            } elseif ($action->tipe === 'poli-gigi') {
                $route = 'action.lab.gigi.index';
            } elseif ($action->tipe === 'poli-kia') {
                $route = 'action.lab.kia.index';
            } elseif ($action->tipe === 'poli-kb') {
                $route = 'action.lab.kb.index';
            } else {
                $route = 'action.lab.ugd.index';
            }
            return redirect()->route($route)->with('success', 'Action has been successfully updated.');
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
            if ($action->tipe === 'poli-umum') {
                $route = 'action.apotik.index';
            } elseif ($action->tipe === 'poli-gigi') {
                $route = 'action.apotik.gigi.index';
            } elseif ($action->tipe === 'poli-kia') {
                $route = 'action.apotik.kia.index';
            } elseif ($action->tipe === 'poli-kb') {
                $route = 'action.apotik.kb.index';
            } else {
                $route = 'action.apotik.ugd.index';
            }
            return redirect()->route($route)->with('success', 'Action has been successfully updated.');
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

            $actionsQuery = Action::with(['patient'])
                ->where('tipe', 'poli-umum')
                ->whereNotNull('obat');

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
                ->addIndexColumn()
                ->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
                ->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
                ->addColumn('patient_name', fn($row) => optional($row->patient)->name)
                ->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
                ->addColumn('obat', fn($row) => $row->obat)
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
    public function indexGigiApotik(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $actionsQuery = Action::with(['patient'])
                ->where('tipe', 'poli-gigi')
                ->whereNotNull('obat');

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
                ->addIndexColumn()
                ->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
                ->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
                ->addColumn('patient_name', fn($row) => optional($row->patient)->name)
                ->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
                ->addColumn('obat', fn($row) => $row->obat)
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
    public function indexUgdApotik(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $actionsQuery = Action::with(['patient'])
                ->where('tipe', 'ruang-tindakan')
                ->whereNotNull('obat');

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
                ->addIndexColumn()
                ->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
                ->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
                ->addColumn('patient_name', fn($row) => optional($row->patient)->name)
                ->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
                ->addColumn('obat', fn($row) => $row->obat)
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
    public function indexKiaApotik(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $actionsQuery = Action::with(['patient'])
                ->where('tipe', 'poli-kia')
                ->whereNotNull('obat');

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
                ->addIndexColumn()
                ->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
                ->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
                ->addColumn('patient_name', fn($row) => optional($row->patient)->name)
                ->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
                ->addColumn('obat', fn($row) => $row->obat)
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
    public function indexKbApotik(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $actionsQuery = Action::with(['patient'])
                ->where('tipe', 'poli-kb')
                ->whereNotNull('obat');

            if ($startDate) {
                $actionsQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $actionsQuery->whereDate('tanggal', '<=', $endDate);
            }

            $actions = $actionsQuery->get();

            return DataTables::of($actions)
                ->addIndexColumn()
                ->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
                ->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
                ->addColumn('patient_name', fn($row) => optional($row->patient)->name)
                ->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
                ->addColumn('obat', fn($row) => $row->obat)
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

            if (Auth::user()->role == 'dokter') {
                if ($action->tipe === 'poli-umum') {
                    $route = 'action.dokter.index';
                } elseif ($action->tipe === 'poli-gigi') {
                    $route = 'action.dokter.gigi.index';
                } elseif ($action->tipe === 'poli-kia') {
                    $route = 'action.kia.dokter.index';
                } else {
                    $route = 'action.dokter.ugd.index';
                }
            } else {
                if ($action->tipe === 'poli-umum') {
                    $route = 'action.index';
                } elseif ($action->tipe === 'poli-gigi') {
                    $route = 'action.index.gigi';
                } elseif ($action->tipe === 'poli-kia') {
                    $route = 'action.kia.index';
                } elseif ($action->tipe === 'poli-kb') {
                    $route = 'action.kb.index';
                } else {
                    $route = 'action.index.ugd';
                }
            }

            return redirect()->route($route)->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
