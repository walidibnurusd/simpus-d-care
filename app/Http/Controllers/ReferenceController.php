<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Poli;
use App\Models\Diagnosis;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class ReferenceController extends Controller
{
    public function indexDoctor() {
        return view('content.reference.doctor');
    }

    public function indexDataDoctor(Request $request) {
        $query = User::where('role', 'dokter')->orderBy('created_at', 'desc');
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('actions', function ($user) {
                return '
                    <button class="btn btn-sm btn-primary edit-user" 
                        data-id="' . $user->id . '" 
                        data-name="' . htmlspecialchars($user->name) . '" 
                        data-email="' . htmlspecialchars($user->email) . '"
                        data-nip="'. htmlspecialchars($user->nip) .'"
                        data-address="'. htmlspecialchars($user->address) .'"
                        data-phone_number="'. htmlspecialchars($user->no_hp) .'"
                        data-nik="'. htmlspecialchars($user->nik) .'">Edit</button>
                    <button class="btn btn-sm btn-danger delete-user" data-id="' . $user->id . '">Delete</button>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function updateDoctor(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'nip' => 'required|unique:users,nip,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'required',
            'address' => 'required'
        ]);

        $user = User::find($id);
        $user->name = $validated['name'];
        $user->nip = $validated['nip'];
        $user->email = $validated['email'];
        $user->no_hp = $validated['phone_number'];
        $user->address = $validated['address'];
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response()->json(['message' => 'Updated']);
    }

    public function destroyDoctor($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    public function storeDoctor(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'nip' => 'required|unique:users,nip',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'phone_number' => 'required',
            'address' => 'required'
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->nip = $validated['nip'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->no_hp = $validated['phone_number'];
        $user->address = $validated['address'];
        $user->role = 'dokter';
        $user->save();

        return response()->json(['message' => 'Data user succesfully added!']);
    }

    // ======================================================================================= POLI

    public function indexPoli() {
        return view('content.reference.poli');
    }

    public function indexDataPoli(Request $request) {
        $query = Poli::orderBy('updated_at', 'desc');
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('actions', function ($poli) {
                return '
                    <button class="btn btn-sm btn-primary edit-poli" 
                        data-id="' . $poli->id . '" 
                        data-name="' . htmlspecialchars($poli->name) . '">Edit</button>
                    <button class="btn btn-sm btn-danger delete-poli" data-id="' . $poli->id . '">Delete</button>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function updatePoli(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);

        $poli = Poli::find($id);
        $poli->name = $validated['name'];
        $poli->save();
        return response()->json(['message' => 'Updated']);
    }

    public function storePoli(Request $request) {
        $validated = $request->validate([
            'name' => 'required'
        ]);

        $poli = new Poli();
        $poli->name = $validated['name'];
        $poli->save();

        return response()->json(['message' => 'Data poli succesfully added!']);
    }

    public function destroyPoli($id)
    {
        Poli::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    // ======================================================================================= DIAGNOSIS

    public function indexDiagnosis() {
        return view('content.reference.diagnosis');
    }

    public function indexDataDiagnosis(Request $request) {
        $query = Diagnosis::orderBy('updated_at', 'desc');
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('actions', function ($diagnosis) {
                return '
                    <button class="btn btn-sm btn-primary edit-diagnosis" 
                        data-id="' . $diagnosis->id . '" 
                        data-name="' . htmlspecialchars($diagnosis->name) . '"
                        data-icd10="' . htmlspecialchars($diagnosis->icd10) . '">Edit</button>
                    <button class="btn btn-sm btn-danger delete-diagnosis" data-id="' . $diagnosis->id . '">Delete</button>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function updateDiagnosis(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'icd10' => 'required'
        ]);

        $diagnosis = Diagnosis::find($id);
        $diagnosis->name = $validated['name'];
        $diagnosis->icd10 = $validated['icd10'];
        $diagnosis->save();
        return response()->json(['message' => 'Updated']);
    }

    public function storeDiagnosis(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'icd10' => 'required'
        ]);

        $diagnosis = new Diagnosis();
        $diagnosis->name = $validated['name'];
        $diagnosis->icd10 = $validated['icd10'];
        $diagnosis->save();

        return response()->json(['message' => 'Data diagnosis succesfully added!']);
    }

    public function destroyDiagnosis($id)
    {
        Diagnosis::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

}
