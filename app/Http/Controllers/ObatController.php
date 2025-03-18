<?php

namespace App\Http\Controllers;

use App\Models\Obat;
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
            // Log the incoming request data
            Log::info('Attempting to update master data', [
                'id' => $id,
                'name' => $request->name,
                'code' => $request->code,
                'shape' => $request->shape,
            ]);

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

            // Log success
            Log::info('Master data updated successfully', [
                'id' => $id,
                'name' => $obat->name,
                'code' => $obat->code,
                'shape' => $obat->shape,
            ]);

            return redirect()->back()->with('success', 'Data berhasil diedit');
        } catch (Exception $e) {
            // Log the exception message and stack trace
            Log::error('Error updating master data', [
                'exception' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            // Handle specific validation exception
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $errors = $e->errors();

                // Check if specific validation errors exist for 'code'
                if (isset($errors['code'])) {
                    $errorMessage = 'Kode obat tidak boleh sama';
                    Log::warning('Validation error: Code conflict', ['errors' => $errors['code']]);
                    return redirect()
                        ->back()
                        ->withErrors(['code' => $errorMessage]);
                }

                // Log other validation errors
                Log::warning('Validation errors', ['errors' => $errors]);
                return redirect()->back()->withErrors($errors);
            }

            // Log other exceptions
            Log::error('Unexpected error', [
                'exception' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            // Redirect back with a general error message
            return redirect()->back()->withErrors('Eror saat membuat master data obat');
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
                        
                       
                    </div>' .
                    $modal;
            })
            ->make(true);
    }
}
