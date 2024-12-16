<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;

class PatientsController extends Controller
{
    public function getPatients(Request $request)
{
    $patients = Patients::all();

    // Return data in the format required by DataTables
    return response()->json(['data' => $patients]);
}
    public function index()
    {
        $patients = Patients::all();
        return view('content.patients.index', compact('patients'));
    }
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'nik' => 'required|string|max:16',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'gender' => 'required|integer',
                'place_birth' => 'required|string|max:255',
                'dob' => 'required|date',
                'no_rm' => 'required|string|max:255',
                'marriage_status' => 'required|integer',
                'blood_type' => 'required|string|max:2',
                'education' => 'required|integer',
                'occupation' => 'required|integer',
                'province' => 'required|integer',
                'city' => 'required|integer',
                'district' => 'required|integer',
                'village' => 'required|integer',
                'rw' => 'required|integer',
                'address' => 'required|string|max:255',
            ]);
    
            // Create a new patient record
            $patient = new Patients();
            $patient->nik = $validatedData['nik'];
            $patient->name = $validatedData['name'];
            $patient->phone = $validatedData['phone'];
            $patient->gender = $validatedData['gender'];
            $patient->place_birth = $validatedData['place_birth'];
            $patient->dob = $validatedData['dob'];
            $patient->no_rm = $validatedData['no_rm'];
            $patient->marrital_status = $validatedData['marriage_status'];
            $patient->blood_type = $validatedData['blood_type'];
            $patient->education = $validatedData['education'];
            $patient->occupation = $validatedData['occupation'];
            $patient->indonesia_province_id = $validatedData['province'];
            $patient->indonesia_city_id = $validatedData['city'];
            $patient->indonesia_district_id = $validatedData['district'];
            $patient->indonesia_village_id = $validatedData['village'];
            $patient->rw = $validatedData['rw'];
            $patient->address = $validatedData['address'];
    // dd($patient);
            $patient->save();
    
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Patient data added successfully.');
    
        } catch (Exception $e) {
            // Log the error
            Log::error('Error adding patient: ' . $e->getMessage());
    
            // Redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while adding the patient. Please try again.');
        }
    }
    

    public function update(Request $request, $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'nik' => 'required|string|max:16',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'gender' => 'required|integer',
                'place_birth' => 'required|string|max:255',
                'dob' => 'required|date',
                'no_rm' => 'required|string|max:255',
                'marriage_status' => 'required|integer',
                'blood_type' => 'required|string|max:2',
                'education' => 'required|integer',
                'occupation' => 'required|integer',
                'province' => 'required|integer',
                'city' => 'required|integer',
                'district' => 'required|integer',
                'village' => 'required|integer',
                'rw' => 'required|integer',
                'address' => 'required|string|max:255',
            ]);
    
            // Find the patient record by ID
            $patient = Patients::findOrFail($id);
    
            // Update the patient record with validated data
            $patient->nik = $validatedData['nik'];
            $patient->name = $validatedData['name'];
            $patient->phone = $validatedData['phone'];
            $patient->gender = $validatedData['gender'];
            $patient->place_birth = $validatedData['place_birth'];
            $patient->dob = $validatedData['dob'];
            $patient->no_rm = $validatedData['no_rm'];
            $patient->marrital_status = $validatedData['marriage_status'];
            $patient->blood_type = $validatedData['blood_type'];
            $patient->education = $validatedData['education'];
            $patient->occupation = $validatedData['occupation'];
            $patient->indonesia_province_id = $validatedData['province'];
            $patient->indonesia_city_id = $validatedData['city'];
            $patient->indonesia_district_id = $validatedData['district'];
            $patient->indonesia_village_id = $validatedData['village'];
            $patient->rw = $validatedData['rw'];
            $patient->address = $validatedData['address'];
    
            // Save the updated patient record
            $patient->save();
    
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Patient data updated successfully.');
    
        } catch (Exception $e) {
            // Log the error
            Log::error('Error updating patient: ' . $e->getMessage());
    
            // Redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while updating the patient. Please try again.');
        }
    }
    
// PatientController.php
public function destroy($id)
{
    // Find the patient by ID or fail
    $patient = Patients::findOrFail($id);

    // Delete the patient
    $patient->delete();

    // Redirect with a success message
    return redirect()->route('patient.index')->with('success', 'Patient deleted successfully.');
}
public function patientReport()
{
    $patients = Patients::all(); // Ganti dengan query sesuai kebutuhan
    return view('content.patients.print', compact('patients'));
}


}
