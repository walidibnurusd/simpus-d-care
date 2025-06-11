<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Action;
use App\Models\Hospital;
use App\Models\User;
use App\Models\Obat;
use App\Models\Poli;
use App\Models\Diagnosis;

class LoadModalController extends Controller
{
	public function editKajianAwal(Request $request, Action $action)
	{
		$routeName = $request->query('routeName');
		$action->load([
			'patient',
			'hospitalReferral'
		]);
		$rs = Hospital::all();
		$dokter = User::where('role', 'dokter')->get();
		$obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();
		$poli = Poli::all();
		$diagnosa = Diagnosis::all();

	    return view(' kajian-awal.inc.modal-edit', [
	        'rs' => $rs,
	        'dokter' => $dokter,
	        'obats' => $obats,
	        'routeName' => $routeName,
	        'action' => $action,
	    ]);
	}
}
