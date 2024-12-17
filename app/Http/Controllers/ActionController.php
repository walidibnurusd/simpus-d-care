<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Diagnosis;
use App\Models\Disease;
use App\Models\Doctor;
use App\Models\Hospital;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function index()
    {
        $actions = Action::all();
        $dokter = Doctor::all();
        $penyakit = Disease::all();
        $rs = Hospital::all();
        $diagnosa = Diagnosis::all();
        return view('content.action.index', compact('actions','dokter','penyakit','rs','diagnosa'));
    }
    public function actionReport()
{
    $actions = Action::all(); // Ganti dengan query sesuai kebutuhan
    return view('content.action.print', compact('actions'));
}
public function store(Request $request)
    { 
        $request->merge([
            'tanggal' => Carbon::createFromFormat('d-m-Y', $request->tanggal)->format('Y-m-d'),
        ]);
    
        // dd($request->all());
        $validatedData = $request->validate([
            'id_patient' => 'required|exists:patients,id',
            'tanggal' => 'required|date',
            'id_doctor' => 'required|exists:doctors,id',
            'kunjungan' => 'nullable|string',
            'kartu' => 'nullable|string',
            'nomor' => 'nullable|string',
            'faskes' => 'nullable|string',
            'sistol' => 'nullable|integer',
            'diastol' => 'nullable|integer',
            'beratBadan' => 'nullable|numeric',
            'tinggiBadan' => 'nullable|numeric',
            'lingkarPinggang' => 'nullable|numeric',
            'gula' => 'nullable|numeric',
            'merokok' => 'nullable',
            'fisik' => 'nullable|string',
            'gula_lebih' => 'nullable|string',
            'alkohol' => 'nullable|string',
            'garam' => 'nullable|string',
            'hidup' => 'nullable|string',
            'lemak' => 'nullable|string',
            'buah_sayur' => 'nullable|string',
            'hasil_iva' => 'nullable|string',
            'tindak_iva' => 'nullable|string',
            'hasil_sadanis' => 'nullable|string',
            'tindak_sadanis' => 'nullable|string',
            'konseling' => 'nullable|string',
            'car' => 'nullable|string',
            'rujuk_ubm' => 'nullable|string',
            'kondisi' => 'nullable|string',
            'edukasi' => 'nullable|string',
            'riwayat_penyakit_keluarga' => 'nullable|exists:diseases,id',
            'riwayat_penyakit_tidak_menular' => 'nullable|exists:diseases,id',
            'keluhan' => 'nullable|string',
            'diagnosa' => 'nullable|exists:diagnosis,id',
            'tindakan' => 'nullable|string',
            'rujuk_rs' => 'nullable|exists:hospitals,id',
            'keterangan' => 'nullable|string',
        ]);

        Action::create($validatedData);

        return redirect()->route('action.index')->with('success', 'Action has been successfully created.');
    }
    public function update(Request $request, $id)
{
    $request->merge([
        'tanggal' => Carbon::createFromFormat('d-m-Y', $request->tanggal)->format('Y-m-d'),
    ]);

    $validatedData = $request->validate([
        'id_patient' => 'required|exists:patients,id',
        'tanggal' => 'required|date',
        'id_doctor' => 'required|exists:doctors,id',
        'kunjungan' => 'nullable|string',
        'kartu' => 'nullable|string',
        'nomor' => 'nullable|string',
        'faskes' => 'nullable|string',
        'sistol' => 'nullable|integer',
        'diastol' => 'nullable|integer',
        'beratBadan' => 'nullable|numeric',
        'tinggiBadan' => 'nullable|numeric',
        'lingkarPinggang' => 'nullable|numeric',
        'gula' => 'nullable|numeric',
        'merokok' => 'nullable',
        'fisik' => 'nullable|string',
        'gula_lebih' => 'nullable|string',
        'alkohol' => 'nullable|string',
        'garam' => 'nullable|string',
        'hidup' => 'nullable|string',
        'lemak' => 'nullable|string',
        'buah_sayur' => 'nullable|string',
        'hasil_iva' => 'nullable|string',
        'tindak_iva' => 'nullable|string',
        'hasil_sadanis' => 'nullable|string',
        'tindak_sadanis' => 'nullable|string',
        'konseling' => 'nullable|string',
        'car' => 'nullable|string',
        'rujuk_ubm' => 'nullable|string',
        'kondisi' => 'nullable|string',
        'edukasi' => 'nullable|string',
        'riwayat_penyakit_keluarga' => 'nullable|exists:diseases,id',
        'riwayat_penyakit_tidak_menular' => 'nullable|exists:diseases,id',
        'keluhan' => 'nullable|string',
        'diagnosa' => 'nullable|exists:diagnosis,id',
        'tindakan' => 'nullable|string',
        'rujuk_rs' => 'nullable|exists:hospitals,id',
        'keterangan' => 'nullable|string',
    ]);

    $action = Action::findOrFail($id);
    $action->update($validatedData);

    return redirect()->route('action.index')->with('success', 'Action has been successfully updated.');
}
public function destroy($id)
{
    $action = Action::findOrFail($id);
    $action->delete();

    return redirect()->route('action.index')->with('success', 'Action has been successfully deleted.');
}

}
