<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Diagnosis;
use App\Models\Disease;
use App\Models\Doctor;
use App\Models\Hospital;
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
}
