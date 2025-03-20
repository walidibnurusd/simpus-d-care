<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\TerimaObat;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;

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
    public function storeMasterData(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255|unique:obat,code',
                'shape' => 'required|integer|max:1',
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
    public function destroyMasterData($id)
    {
        try {
            $obat = Obat::findOrFail($id);
            $obat->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    public function getObatMasterData(Request $request)
    {
        $obats = Obat::all();

        // Return the datatables response
        return datatables()
            ->of($obats)
            ->addIndexColumn()
            ->editColumn('name', function ($row) {
                return $row->name;
            })
            ->editColumn('code', function ($row) {
                return $row->code ?? '';
            })
            ->editColumn('shape', function ($row) {
                // Check the value of shape and return appropriate value
                switch ($row->shape) {
                    case 1:
                        return 'Tablet';
                    case 2:
                        return 'Botol';
                    case 3:
                        return 'Pcs';
                    case 4:
                        return 'Suppositoria';
                    case 5:
                        return 'Ovula';
                    case 6:
                        return 'Drop';
                    case 7:
                        return 'Tube';
                    case 8:
                        return 'Pot';
                    case 9:
                        return 'Injeksi';
                    default:
                        return '';
                }
            })

            ->addColumn('action', function ($row) {
                // Render the modal HTML for this specific row
                $modal = view('component.modal-edit-master-obat', ['obat' => $row])->render();

                return '<div class="action-buttons">
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-primary btn-sm text-white font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#editMasterObatModal' .
                    $row->id .
                    '">
                            <i class="fas fa-edit"></i>
                        </button>
                        
                             <form action="' .
                    route('destroy-obat-master-data', $row->id) .
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
                    $modal;
            })
            ->make(true);
    }

    public function storeTerimaObat(Request $request)
    {
        try {
            Log::info('Received request: ', $request->all());

            // Validate the request data
            $validatedData = $request->validate([
                'id_obat' => 'required',
                'date' => 'required|date',
                'amount' => 'required|integer',
            ]);

            $obat = new TerimaObat();
            $obat->id_obat = $request->id_obat;
            $obat->amount = $request->amount;
            $obat->date = $request->date;
            $obat->save();

            Log::info('Data saved successfully.');

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
            $obat->save();

            return redirect()->back()->with('success', 'Data berhasil diedit');
        } catch (Exception $e) {
            // Redirect back with a general error message
            return redirect()->back()->withErrors('Eror saat membuat terima obat');
        }
    }

    public function destroyTerimaObat($id)
    {
        try {
            $obat = TerimaObat::findOrFail($id);
            $obat->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    public function getTerimaObat(Request $request)
    {
        $obats = TerimaObat::with('obat')->get();

        // Return the datatables response
        return datatables()
            ->of($obats)
            ->addIndexColumn()
            ->editColumn('date', function ($row) {
                return \Carbon\Carbon::parse($row->date)->format('d-m-Y') ?? '';
            })

            ->addColumn('code', function ($row) {
                return $row->obat->code;
            })
            ->addColumn('name', function ($row) {
                return ucwords(strtolower($row->obat->name));
            })

            ->addColumn('shape', function ($row) {
                // Check the value of shape and return appropriate value
                switch ($row->obat->shape) {
                    case 1:
                        return 'Tablet';
                    case 2:
                        return 'Botol';
                    case 3:
                        return 'Pcs';
                    case 4:
                        return 'Suppositoria';
                    case 5:
                        return 'Ovula';
                    case 6:
                        return 'Drop';
                    case 7:
                        return 'Tube';
                    case 8:
                        return 'Pot';
                    case 9:
                        return 'Injeksi';
                    default:
                        return '';
                }
            })
            ->addColumn('amount', function ($row) {
                return $row->amount;
            })

            ->addColumn('action', function ($row) {
                // Render the modal HTML for this specific row
                $modal = view('component.modal-edit-terima-obat', ['obat' => $row])->render();

                return '<div class="action-buttons">
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-primary btn-sm text-white font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#editTerimaObatModal' .
                    $row->id .
                    '">
                            <i class="fas fa-edit"></i>
                        </button>
                         <form action="' .
                    route('destroy-terima-obat', $row->id) .
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
                    $modal;
            })
            ->make(true);
    }
}
