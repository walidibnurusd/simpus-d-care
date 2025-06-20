<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\PengeluaranObatLain;
use App\Models\TerimaObat;
use App\Models\Patients;
use App\Models\Action;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    public function indexMasterData()
    {
        return view('content.obat.master-data');
    }

    public function indexTerimaObat()
    {
        $obats = Obat::all();
        return view('content.obat.terima-obat', compact('obats'));
    }
    public function indexPengeluaranObat()
    {
        $obats = Obat::all();
        return view('content.obat.pengeluaran-obat', compact('obats'));
    }
    public function indexStokObat()
    {
        return view('content.obat.stok-obat');
    }
    public function getStock($id)
    {
        $stock = TerimaObat::where('id_obat', $id)->sum('amount');
        return response()->json(['stock' => $stock]);
    }

    public function storeMasterData(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255|unique:obat,code',
                'shape' => 'required|integer',
            ]);

            $obat = new Obat();
            $obat->name = $request->name;
            $obat->code = $request->code;
            $obat->shape = $request->shape;
            $obat->save();

            return redirect()->back()->with('success', 'Data berhasil tersimpan');
        } catch (Exception $e) {
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $errors = $e->errors();

                // Check if specific validation errors exist for 'code'
                if (isset($errors['code'])) {
                    $errorMessage = 'Kode obat tidak boleh sama';
                    return redirect()
                        ->back()
                        ->withErrors(['code' => $errorMessage]);
                }

                // Return all other validation errors
                return redirect()->back()->withErrors($errors);
            }

            // Redirect back with an error message
            return redirect()->back()->withErrors('Eror saat membuat master data obat');
        }
    }

    public function updateMasterData(Request $request, $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
                'shape' => 'required|integer',
            ]);

            // Find and update the record
            $obat = Obat::find($id);

            if (!$obat) {
                Log::warning('Obat not found', ['id' => $id]);
                return redirect()->back()->withErrors('Data tidak ditemukan');
            }

            $obat->name = $request->name;
            $obat->code = $request->code;
            $obat->shape = $request->shape;
            $obat->save();

            return redirect()->back()->with('success', 'Data berhasil diedit');
        } catch (Exception $e) {
            // Handle specific validation exception
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $errors = $e->errors();

                // Check if specific validation errors exist for 'code'
                if (isset($errors['code'])) {
                    $errorMessage = 'Kode obat tidak boleh sama';
                    return redirect()
                        ->back()
                        ->withErrors(['code' => $errorMessage]);
                }

                return redirect()->back()->withErrors($errors);
            }

            // Redirect back with a general error message
            return redirect()->back()->withErrors('Eror saat membuat master data obat');
        }
    }

    public function getObatMasterData(Request $request)
    {
        $obats = Obat::query();

        return datatables()
            ->eloquent($obats)
            ->addIndexColumn()

            ->editColumn('name', fn($row) => $row->name)
            ->editColumn('code', fn($row) => $row->code ?? '-')

            ->editColumn('shape', fn($row) => $row->shapeLabel)

            ->addColumn('action', function ($row) {
                $modal = view('component.modal-edit-master-obat', ['obat' => $row])->render();

                return <<<HTML
                    <div class="action-buttons">
                        <button type="button" class="btn btn-primary btn-sm text-white font-weight-bold text-xs"
                            data-bs-toggle="modal" data-bs-target="#editMasterObatModal{$row->id}">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    {$modal}
                HTML;
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function storeTerimaObat(Request $request)
    {
        try {
            $obat = new TerimaObat();
            $obat->id_obat = $request->id_obat;
            $obat->amount = $request->amount;
            $obat->date = $request->date;
            $obat->save();

            return redirect()->back()->with('success', 'Data berhasil tersimpan');
        } catch (Exception $e) {
            Log::error('Error while saving data: ' . $e->getMessage());
            return redirect()->back()->withErrors('Eror saat membuat terima obat');
        }
    }

    public function updateTerimaObat(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'id_obat' => 'required',
                'date' => 'required|date',
                'amount' => 'required|integer',
            ]);

            // Find and update the record
            $obat = TerimaObat::find($id);

            if (!$obat) {
                return redirect()->back()->withErrors('Data tidak ditemukan');
            }

            $obat->id_obat = $request->id_obat;
            $obat->amount = $request->amount;
            $obat->date = $request->date;
            $obat->date = $request->date;
            $obat->date = $request->date;
            $obat->save();

            return redirect()->back()->with('success', 'Data berhasil diedit');
        } catch (Exception $e) {
            // Redirect back with a general error message
            return redirect()->back()->withErrors('Eror saat membuat terima obat');
        }
    }
    public function getTerimaObat(Request $request)
    {
        $obats = TerimaObat::select(
            'terima_obat.*',
            'obat.name as obat_name',
            'obat.code as obat_code',
            'obat.shape as obat_shape'
        )
        ->join('obat', 'obat.id', '=', 'terima_obat.id_obat');

        return datatables()->eloquent($obats)
        ->addIndexColumn()
        ->filterColumn('name', function ($query, $keyword) {
            $query->where('obat.name', 'like', "%{$keyword}%");
        })
        ->filterColumn('code', function ($query, $keyword) {
            $query->where('obat.code', 'like', "%{$keyword}%");
        })
        ->filterColumn('shape', function ($query, $keyword) {
            $query->where('obat.shape', 'like', "%{$keyword}%");
        })
        ->editColumn('name', fn($row) => $row->obat_name)
        ->editColumn('code', fn($row) => $row->obat_code ?? '')
        ->editColumn('amount', fn($row) => $row->amount ?? '')
        ->editColumn('shape', fn($row) => $row->obat->shapeLabel)
        ->editColumn('date', fn($row) => $row->date)
        ->addColumn('action', function ($row) {
            $modal = view('component.modal-edit-terima-obat', ['obat' => $row])->render();
            return '<div class="action-buttons">
                        <button type="button" class="btn btn-primary btn-sm text-white font-weight-bold text-xs"
                            data-bs-toggle="modal" data-bs-target="#editTerimaObatModal' . $row->id . '">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>' . $modal;
        })
        ->rawColumns(['action'])
        ->make(true);

    }

    public function getStokObat(Request $request)
    {
        $obats = Obat::select('obat.*',
                DB::raw('MAX(terima_obat.updated_at) as last_updated'),
                DB::raw('SUM(terima_obat.amount) as total_amount')
            )
            ->join('terima_obat', 'terima_obat.id_obat', '=', 'obat.id')
            ->groupBy('obat.id')
            ->orderByDesc('last_updated');

        return datatables()
            ->eloquent($obats)
            ->addIndexColumn()
            ->editColumn('name', fn ($row) => $row->name)
            ->editColumn('code', fn ($row) => $row->code ?? '')
            ->editColumn('amount', fn ($row) => $row->total_amount)
            ->editColumn('updated_at', fn ($row) => $row->last_updated ? Carbon::parse($row->last_updated)->format('d-m-Y H:i:s') : '-')
            ->editColumn('shape', fn ($row) => $row->shape_label)
            ->make(true);
    }

    public function storePengeluaranObat(Request $request)
    {
        try {
            $obat = new PengeluaranObatLain();
            $obat->id_obat = $request->id_obat;
            $obat->amount = $request->amount;
            $obat->date = $request->date;
            $obat->remarks = $request->remarks;
            $obat->unit = $request->unit;
            $obat->save();
            $terimaObat = TerimaObat::where('id_obat', $request->id_obat)->first();

            if ($terimaObat) {
                $newAmount = $terimaObat->amount - $request->amount;

                if ($newAmount < 0) {
                    throw new Exception('Stok tidak cukup');
                }
                $terimaObat->amount = $newAmount;
                $terimaObat->save();
            } else {
                throw new Exception('Obat tidak ditemukan');
            }
            return redirect()->back()->with('success', 'Data berhasil tersimpan');
        } catch (Exception $e) {
            Log::error('Error while saving data: ' . $e->getMessage());
            return redirect()->back()->withErrors('Eror saat membuat pengeluaran obat');
        }
    }
    public function updatePengeluaranObat(Request $request, $id)
    {
        $obat = PengeluaranObatLain::find($id);

        if (!$obat) {
            return redirect()->back()->withErrors('Data tidak ditemukan');
        }

        $previousAmount = $obat->amount;
        $previousObatId = $obat->id_obat;
        $previousDate = $obat->date;

        // Update PengeluaranObatLain data
        $obat->id_obat = $request->id_obat;
        $obat->amount = $request->amount;
        $obat->date = $request->date;
        $obat->remarks = $request->remarks;
        $obat->unit = $request->unit;
        $obat->save();

        try {
            // Jika obat berubah
            if ($previousObatId !== $request->id_obat) {
                //Kembalikan stok untuk obat lama (Obat A)
                $previousTerimaObat = TerimaObat::where('id_obat', $previousObatId)
                    ->whereDate('date', '<=', $previousDate) // Periksa apakah stok yang dimaksud adalah stok sebelum update
                    ->orderBy('date', 'desc') // Ambil yang terakhir berdasarkan tanggal
                    ->first();

                if ($previousTerimaObat) {
                    // Kembalikan stok dengan menambahkan jumlah sebelumnya
                    $previousTerimaObat->amount += $previousAmount;
                    $previousTerimaObat->save();
                }

                //Kurangi stok untuk obat baru (Obat B)
                $terimaObat = TerimaObat::where('id_obat', $request->id_obat)->first();

                if ($terimaObat) {
                    // Hitung stok yang baru setelah dikurangi dengan jumlah baru yang dimasukkan
                    $newAmount = $terimaObat->amount - $request->amount;

                    if ($newAmount < 0) {
                        throw new Exception('Stok tidak cukup');
                    }

                    $terimaObat->amount = $newAmount;
                    $terimaObat->save();
                } else {
                    throw new Exception('Obat baru tidak ditemukan');
                }
            } else {
                // Jika obat tidak berubah, cukup perbarui stok obat yang sama
                $terimaObat = TerimaObat::where('id_obat', $previousObatId)->first();

                if ($terimaObat) {
                    // Hitung stok yang baru setelah perubahan jumlah
                    $newAmount = $terimaObat->amount - ($request->amount - $previousAmount);

                    if ($newAmount < 0) {
                        throw new Exception('Stok tidak cukup');
                    }

                    $terimaObat->amount = $newAmount;
                    $terimaObat->save();
                } else {
                    throw new Exception('Obat tidak ditemukan');
                }
            }

            return redirect()->back()->with('success', 'Data berhasil diedit');
        } catch (Exception $e) {
            // Menangkap error dan redirect kembali dengan pesan error
            return redirect()
                ->back()
                ->withErrors('Error saat mengedit data: ' . $e->getMessage());
        }
    }

    public function getPengeluaranObat(Request $request)
    {
        $obats = PengeluaranObatLain::select(
            'pengeluaran_obat_lain.*',
            'obat.name as obat_name',
            'obat.code as obat_code',
            'obat.shape as obat_shape'
        )
        ->join('obat', 'obat.id', '=', 'pengeluaran_obat_lain.id_obat');;

        return datatables()
            ->eloquent($obats)
            ->addIndexColumn()
            ->filterColumn('name', function ($query, $keyword) {
            $query->where('obat.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('code', function ($query, $keyword) {
                $query->where('obat.code', 'like', "%{$keyword}%");
            })
            ->filterColumn('shape', function ($query, $keyword) {
                $query->where('obat.shape', 'like', "%{$keyword}%");
            })
            ->editColumn('date', function ($row) {
                return $row->date;
            })
            ->editColumn('name', function ($row) {
                return $row->obat_name;
            })
            ->editColumn('code', function ($row) {
                return $row->obat_code ?? '';
            })
            ->editColumn('amount', function ($row) {
                return $row->amount ?? '';
            })
            ->editColumn('shape', function ($row) {
                return $row->obat->shapeLabel;
            })
            ->editColumn('unit', function ($row) {
                switch ($row->unit) {
                    case 1:
                        return 'Home Care';
                    case 2:
                        return 'P3K';
                    case 3:
                        return 'Pustu';
                    case 4:
                        return 'Puskel';
                    case 5:
                        return 'IGD';
                    case 6:
                        return 'Lab';
                    case 7:
                        return 'Lansia';
                    case 8:
                        return 'Poli Gigi';
                    default:
                        return '';
                }
            })

            ->addColumn('action', function ($row) {
                $modal = view('component.modal-edit-pengeluaran-obat', ['obat' => $row])->render();

                return '<div class="action-buttons">
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-primary btn-sm text-white font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#editPengeluaranObatModal' .
                    $row->id .
                    '">
                            <i class="fas fa-edit"></i>
                        </button>
                        
                       
                    </div>' .
                    $modal;
            })
            ->make(true);
    }

    public function generatePrescription($id)
    {
        $action = Action::with('patient', 'actionObats.obat', 'diagnosaPrimer')->find($id);
        $pdf = Pdf::loadView('pdf.prescription', compact('action'));
        $pdf->setPaper([0, 0, 297.64, 419.53]);
        return $pdf->stream('invoice.pdf');
    }

    public function indexPrescription() {
        return view('content.obat.resep-obat-pasien');
    }

    public function indexDataPrescription(Request $request) {
        $query = Patients::whereHas('actions.actionObats')->orderBy('created_at', 'desc');
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('gender', function ($row) {
                return $row->genderName ? $row->genderName->name : '-';
            })
            ->addColumn('actions', function ($user) {
                return '
                    <a class="btn btn-sm btn-primary" href="' . route('obat-pasien-detail', ['id' => $user->id]) . '" role="button">Detail</a>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function indexPrescriptionDetail($id) {
        $patient = Patients::where('id', $id)
        ->whereHas('actions', function ($query) {
            $query->whereHas('actionObats')
                ->orWhereNotNull('obat')
                ->orWhere('obat', '!=', '');
        })
        ->with(['actions' => function ($query) {
            $query->whereHas('actionObats')
                ->orWhereNotNull('obat')
                ->orWhere('obat', '!=', '');
        }, 'actions.actionObats'])
        ->first();
        return view('content.obat.detail-resep-obat-pasien', compact('patient'));
    }
}
