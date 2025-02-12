<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $nik = $request->input('nik');
            $name = $request->input('name');
            $poli = $request->input('poli');
            $dob = $request->input('dob');
            $hamil = $request->input('hamil');
            $klaster = $request->input('klaster');
            $tanggal = $request->input('tanggal');
            $no_rm = $request->input('no_rm');

            $kunjungansQuery = Kunjungan::with('patient');

            if ($startDate) {
                $kunjungansQuery->whereDate('tanggal', '>=', $startDate);
            }

            if ($endDate) {
                $kunjungansQuery->whereDate('tanggal', '<=', $endDate);
            }
            if ($nik) {
                $kunjungansQuery->whereHas('patient', function ($query) use ($nik) {
                    $query->where('nik', 'like', '%' . $nik . '%');
                });
            }

            if ($name) {
                $kunjungansQuery->whereHas('patient', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });
            }
            if ($poli) {
                if (strtolower($poli) == 'ugd') {
                    $poli = 'ruang-tindakan';
                }

                if (strtolower($poli) == 'tindakan' || strtolower($poli) == 'ruang tindakan') {
                    $poli = 'tindakan';
                    $kunjungansQuery->where('poli', $poli);
                }

                $normalizedPoli = str_replace(' ', '-', strtolower($poli));
                $kunjungansQuery->where('poli', 'like', '%' . $normalizedPoli . '%');
            }

            if ($dob) {
                $kunjungansQuery->whereHas('patient', function ($query) use ($dob) {
                    $query->whereDate('dob', $dob);
                });
            }

            if ($hamil) {
                if (strtolower($hamil) == 'ya') {
                    $hamil = 1;
                } else {
                    $hamil = 0;
                }

                $kunjungansQuery->where('hamil', $hamil);
            }
            if ($klaster) {
                $kunjungansQuery->whereHas('patient', function ($query) use ($klaster) {
                    $query->where('klaster', $klaster);
                });
            }

            if ($request->has('tanggal') && $request->tanggal) {
                $tanggal = Carbon::createFromFormat('Y-m-d', $request->tanggal)->toDateString();
                $kunjungansQuery->whereDate('tanggal', $tanggal);
            }

            if ($no_rm) {
                $kunjungansQuery->whereHas('patient', function ($query) use ($no_rm) {
                    $query->where('no_rm', 'like', '%' . $no_rm . '%');
                });
            }
            $kunjungansQuery->orderByDesc('tanggal')->orderByDesc('created_at');

            $kunjungans = $kunjungansQuery->get();

            return DataTables::of($kunjungans)
                ->addIndexColumn()
                ->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
                ->addColumn('patient_no_rm', fn($row) => optional($row->patient)->no_rm)
                ->addColumn('patient_name', fn($row) => optional($row->patient)->name)
                ->addColumn('patient_age', function ($row) {
                    $patient = $row->patient;
                    if ($patient) {
                        return $patient->place_birth . ' / ' . $patient->dob . ' (' . $patient->getAgeAttribute() . '-thn)';
                    }
                    return '-';
                })
                ->editColumn('poli', function ($row) {
                    // Check the value of 'poli' and return the corresponding string
                    if ($row->poli == 'poli-umum') {
                        return 'Poli Umum';
                    } elseif ($row->poli == 'poli-gigi') {
                        return 'Poli Gigi';
                    } elseif ($row->poli == 'poli-kia') {
                        return 'Poli KIA';
                    } elseif ($row->poli == 'poli-kb') {
                        return 'Poli KB';
                    } elseif ($row->poli == 'tindakan') {
                        return 'Ruang Tindakan';
                    } else {
                        return 'UGD';
                    }
                })
                ->editColumn('hamil', function ($row) {
                    // Check the value of 'poli' and return the corresponding string
                    if ($row->hamil == 1) {
                        return 'Ya';
                    } else {
                        return 'Tidak';
                    }
                })
                ->addColumn('patient_klaster', function ($row) {
                    $patient = $row->patient;
                    if ($patient) {
                        if ($patient->getAgeAttribute() < 18 || $row->hamil == 1) {
                            return 'Klaster 2';
                        } else {
                            return 'Klaster 3';
                        }
                    }
                })
                ->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('d-m-Y') : '-')
                ->addColumn('action', function ($row) {
                    // Get the doctor list
                    // Render modal edit with route name
                    $editModal = view('component.modal-edit-kunjungan', ['k' => $row])->render();

                    return '<div class="action-buttons">
                                <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editKunjunganModal' .
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
                                     <!-- Delete Button with a Unique ID -->
                        <button type="button" class="btn btn-danger btn-sm text-white font-weight-bold d-flex align-items-center btn-delete" id="delete-button-' .
                        $row->id .
                        '">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                                </form>
                            </div>' .
                        $editModal;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('content.kunjungan.index');
    }

    public function update(Request $request, $id)
    {
        try {
            $kunjungan = Kunjungan::findOrFail($id);

            $validated = $request->validate([
                'poli' => 'nullable',
                'hamil' => 'nullable',
                'tanggal' => 'nullable',
            ]);

            $kunjungan->update([
                'poli' => $validated['poli'] ?? $kunjungan->poli,
                'hamil' => $validated['hamil'] ?? $kunjungan->hamil,
                'tanggal' => $validated['tanggal'] ?? $kunjungan->tanggal,
            ]);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Kunjungan berhasil diperbarui']);
            }

            return redirect()->route('kunjungan.index')->with('success', 'Kunjungan Berhasil Diedit');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
            }

            return redirect()
                ->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $kunjungan = Kunjungan::findOrFail($id);
            $kunjungan->delete();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Kunjungan berhasil dihapus']);
            }

            return redirect()->route('kunjungan.index')->with('success', 'Kunjungan berhasil dihapus');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
            }

            return redirect()
                ->route('kunjungan.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
