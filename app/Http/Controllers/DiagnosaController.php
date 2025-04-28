<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
class DiagnosaController extends Controller
{
   public function getDiagnosa()
{
    $diagnosa = Diagnosis::select('id', 'name', 'icd10')->get();
    return response()->json(['diagnosa' => $diagnosa]);
}
}
