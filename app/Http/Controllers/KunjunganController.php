<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Kunjungan;
use App\Models\Diagnosis;
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

			// Filtering related patient fields
			$kunjungansQuery->whereHas('patient', function ($query) use ($nik, $name, $dob, $no_rm) {
				if ($nik) {
					$query->where('nik', 'like', '%' . $nik . '%');
				}
				if ($name) {
					$query->where('name', 'like', '%' . $name . '%');
				}
				if ($dob) {
					$query->whereDate('dob', $dob);
				}
				if ($no_rm) {
					$query->where('no_rm', 'like', '%' . $no_rm . '%');
				}
			});

			if ($poli) {
				if (strtolower($poli) == 'ugd') {
					$poli = 'ruang-tindakan';
				}

				if (strtolower($poli) == 'tindakan' || strtolower($poli) == 'ruang tindakan') {
					$poli = 'tindakan';
					$kunjungansQuery->where('kunjungan.poli', $poli);
				}

				$normalizedPoli = str_replace(' ', '-', strtolower($poli));
				$kunjungansQuery->where('kunjungan.poli', 'like', '%' . $normalizedPoli . '%');
			}

			if ($hamil) {
				$hamil = strtolower($hamil) == 'ya' ? 1 : 0;
				$kunjungansQuery->where('hamil', $hamil);
			}

			if ($klaster) {
				if ($klaster == '2') {
					$kunjungansQuery->whereHas('patient', function ($query) {
						$query->where(function ($q) {
							$q->whereDate('dob', '>', now()->subYears(18))->orWhere('hamil', 1);
						});
					});
				} elseif ($klaster == '3') {
					$kunjungansQuery->whereHas('patient', function ($query) {
						$query->where(function ($q) {
							$q->whereDate('dob', '<=', now()->subYears(18))->where('hamil', 0);
						});
					});
				}
			}

			if ($tanggal) {
				$tanggal = Carbon::createFromFormat('Y-m-d', $tanggal)->toDateString();
				$kunjungansQuery->whereDate('tanggal', $tanggal);
			}

			return DataTables::eloquent($kunjungansQuery)
				->filter(function ($query) use ($request) {
					if ($search = $request->input('search.value')) {
						$query->where(function ($q) use ($search) {
							$q->orWhereHas('patient', function ($patientQuery) use ($search) {
								$patientQuery->where('nik', 'like', "%{$search}%")
									->orWhere('name', 'like', "%{$search}%")
									->orWhere('no_rm', 'like', "%{$search}%");
							});
							$q->orWhere('kunjungan.poli', 'like', "%{$search}%")
								->orWhere('tanggal', 'like', "%{$search}%");
						});
					}
				})
				->orderColumn('patient_nik', function ($query, $order) {
					$query->join('patients', 'kunjungan.pasien', '=', 'patients.id')
						  ->orderBy('patients.nik', $order);
				})
				->orderColumn('patient_no_rm', function ($query, $order) {
					$query->join('patients', 'kunjungan.pasien', '=', 'patients.id')
						  ->orderBy('patients.no_rm', $order);
				})
				->orderColumn('patient_name', function ($query, $order) {
					$query->join('patients', 'kunjungan.pasien', '=', 'patients.id')
						  ->orderBy('patients.name', $order);
				})
				->orderColumn('patient_age', function ($query, $order) {
					$query->join('patients', 'kunjungan.pasien', '=', 'patients.id')
						  ->orderBy('patients.dob', $order);
				})
				->orderColumn('poli', function ($query, $order) {
					$query->orderBy('kunjungan.poli', $order);
				})
				->orderColumn('hamil', function ($query, $order) {
					$query->orderBy('hamil', $order);
				})
				->orderColumn('tanggal', function ($query, $order) {
					$query->orderBy('tanggal', $order);
				})
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
				->editColumn('hamil', fn($row) => $row->hamil == 1 ? 'Ya' : 'Tidak')
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

    public function kunjunganDashboard(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
            $endDate = $request->input('end_date') ?? Carbon::today()->toDateString();
            $nik = $request->input('nik');
            $name = $request->input('name');
            $poli = $request->input('poli');
            $dob = $request->input('dob');
            $hamil = $request->input('hamil');
            $klaster = $request->input('klaster');
            $tanggal = $request->input('tanggal');
            $no_rm = $request->input('no_rm');
            $diagnosa = $request->input('diagnosa');
            $icd10 = $request->input('icd10');

            $kunjungansQuery = Kunjungan::with('patient');
            $kunjungansQuery->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate);

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
                if ($klaster == '2') {
                    $kunjungansQuery->whereHas('patient', function ($query) {
                        $query->where(function ($q) {
                            $q->whereDate('dob', '>', now()->subYears(18))->orWhere('hamil', 1);
                        });
                    });
                } elseif ($klaster == '3') {
                    $kunjungansQuery->whereHas('patient', function ($query) {
                        $query->where(function ($q) {
                            $q->whereDate('dob', '<=', now()->subYears(18))->where('hamil', 0);
                        });
                    });
                }
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
            $actions = $kunjungans->map(function ($kunjungan) {
                return Action::with('satuSehatEncounter')->where('id_patient', $kunjungan->pasien)->whereDate('tanggal', $kunjungan->tanggal)->first();
            });
            if ($diagnosa) {
                $kunjungans = $kunjungans->filter(function ($kunjungan) use ($actions, $diagnosa) {
                    $action = $actions->firstWhere('id_patient', $kunjungan->pasien);

                    if (!$action || empty($action->diagnosa)) {
                        return false;
                    }
                    $diagnosaIds = is_array($action->diagnosa) ? $action->diagnosa : explode(',', $action->diagnosa);

                    $diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();
                    return collect($diagnoses)->contains(function ($diagnosis) use ($diagnosa) {
                        return stripos($diagnosis, $diagnosa) !== false;
                    });
                });
            }
            if ($icd10) {
                $kunjungans = $kunjungans->filter(function ($kunjungan) use ($actions, $icd10) {
                    $action = $actions->firstWhere('id_patient', $kunjungan->pasien);

                    if (!$action || empty($action->diagnosa)) {
                        return false;
                    }
                    $diagnosaIds = is_array($action->diagnosa) ? $action->diagnosa : explode(',', $action->diagnosa);

                    $diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('icd10')->toArray();
                    return collect($diagnoses)->contains(function ($diagnosis) use ($icd10) {
                        return stripos($diagnosis, $icd10) !== false;
                    });
                });
            }

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
                ->addColumn('diagnosa', function ($row) use ($actions) {
                    $action = $actions->firstWhere('id_patient', $row->pasien);
                    if (!$action || empty($action->diagnosa)) {
                        return '-';
                    }
                    if (is_array($action->diagnosa)) {
                        $diagnosaIds = $action->diagnosa;
                    } else {
                        $diagnosaIds = explode(',', $action->diagnosa);
                    }

                    $diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();

                    return implode(', ', $diagnoses);
                })
                ->addColumn('icd10', function ($row) use ($actions) {
                    $action = $actions->firstWhere('id_patient', $row->pasien);
                    if (!$action || empty($action->diagnosa)) {
                        return '-';
                    }
                    if (is_array($action->diagnosa)) {
                        $diagnosaIds = $action->diagnosa;
                    } else {
                        $diagnosaIds = explode(',', $action->diagnosa);
                    }

                    $diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('icd10')->toArray();

                    return implode(', ', $diagnoses);
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
				->addColumn('action_id', function ($row) use ($actions) {
					$kunjunganAction = $actions->where('tanggal', $row->tanggal)->where('id_patient', $row->pasien)->first();
					if ($kunjunganAction) {
						return $kunjunganAction->id;
					}
					return null;
                })
				->addColumn('status_satu_sehat', function ($row) use ($actions) {
					$kunjunganAction = $actions->where('tanggal', $row->tanggal)->where('id_patient', $row->pasien)->first();
					if ($kunjunganAction->status_satu_sehat) {
						return 'Berhasil';
					}
					return null;
                })
				->addColumn('satu_sehat_encounter', function ($row) use ($actions) {
					$kunjunganAction = $actions->where('tanggal', $row->tanggal)->where('id_patient', $row->pasien)->first();
					if ($kunjunganAction->satuSehatEncounter) {
						return $kunjunganAction->satuSehatEncounter->encounter_id;
					}
					return null;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
                return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui']);
            }

            return redirect()->back()->with('success', 'Data Berhasil Diedit');
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
        // Temukan Kunjungan berdasarkan ID
        $kunjungan = Kunjungan::findOrFail($id);

        $actions = Action::where('id_patient', $kunjungan->pasien)
                         ->whereDate('tanggal', $kunjungan->tanggal)
                         ->get();

        // Hapus Action yang ditemukan
        foreach ($actions as $action) {
            $action->delete();
        }

        // Hapus data Kunjungan
        $kunjungan->delete();

        // Jika request adalah ajax
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        }

        // Jika tidak ajax, redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    } catch (\Exception $e) {
        // Tangani error jika terjadi
        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }

        return redirect()
            ->route('kunjungan.index')
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

}
