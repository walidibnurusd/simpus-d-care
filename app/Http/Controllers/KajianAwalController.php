<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\ActionObat;
use App\Models\Diagnosis;
use App\Models\Disease;
use App\Models\Poli;
use App\Models\SatuSehatEncounter;
use App\Models\TerimaObat;
use App\Helpers\SatuSehatHelper;
use App\Models\User;
use App\Models\Hospital;
use App\Models\Patients;
use App\Models\Kunjungan;
use App\Models\HasilLab;
use App\Models\Obat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class KajianAwalController extends Controller
{

	public function umum(Request $request)
	{
		$dokter = User::where('role', 'dokter')->get();
		$diagnosa = Diagnosis::all();
		$penyakit = Disease::all();
		$rs = Hospital::all();
		$routeName = $request->route()->getName();
		$obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();

		if ($request->ajax()) {
			$startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
			$endDate = $request->input('end_date') ?? Carbon::today()->toDateString();
			$actionsQuery = Action::with([
					'patient:id,nik,no_rm,name,dob,jenis_kartu,wilayah_faskes',
					'hospitalReferral'
				])
				->select('actions.id', 'tanggal', 'diagnosa', 'keluhan', 'tindakan', 'id_patient', 'rujuk_rs')
				->where('tipe', 'poli-umum')
				->whereDate('tanggal', '>=', $startDate)
				->whereDate('tanggal', '<=', $endDate);

			return DataTables::of($actionsQuery)
				->filter(function ($query) use ($request) {
					if ($search = $request->input('search.value')) {
						$query->where(function ($q) use ($search) {
							$q->orWhereHas('patient', function ($patientQuery) use ($search) {
								$patientQuery->where('nik', 'like', "%{$search}%")
									->orWhere('name', 'like', "%{$search}%")
									->orWhere('jenis_kartu', 'like', "%{$search}%")
									->orWhere('no_rm', 'like', "%{$search}%");
							});

							$q->orWhereHas('hospitalReferral', function ($patientQuery) use ($search) {
								$patientQuery->where('name', 'like', "%{$search}%");
							});

							$q->orWhere('keluhan', 'like', "%{$search}%")
							  ->orWhere('tindakan', 'like', "%{$search}%")
							  ->orWhere('tanggal', 'like', "%{$search}%");

							$q->orWhereRaw("(SELECT COUNT(*) FROM kunjungan WHERE kunjungan.pasien = actions.id_patient) = 1 AND 'Baru' LIKE ?", ["%{$search}%"]);
							$q->orWhereRaw("(SELECT COUNT(*) FROM kunjungan WHERE kunjungan.pasien = actions.id_patient) > 1 AND 'Lama' LIKE ?", ["%{$search}%"]);
						});
					}
				})
				->orderColumn('patient_nik', function ($query, $order) {
					$query->join('patients', 'actions.id_patient', '=', 'patients.id')
						  ->orderBy('patients.nik', $order);
				})
				->orderColumn('patient_no_rm', function ($query, $order) {
					$query->join('patients', 'actions.id_patient', '=', 'patients.id')
						  ->orderBy('patients.no_rm', $order);
				})
				->orderColumn('patient_name', function ($query, $order) {
					$query->join('patients', 'actions.id_patient', '=', 'patients.id')
						  ->orderBy('patients.name', $order);
				})
				->orderColumn('patient_age', function ($query, $order) {
					$query->join('patients', 'actions.id_patient', '=', 'patients.id')
						  ->orderBy('patients.dob', $order);
				})
				->orderColumn('kartu', function ($query, $order) {
					$query->join('patients', 'actions.id_patient', '=', 'patients.id')
						  ->orderBy('patients.jenis_kartu', $order);
				})
				->orderColumn('tanggal', function ($query, $order) {
					$query->orderBy('tanggal', $order);
				})
				->addIndexColumn()
				->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
				->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
				->addColumn('patient_name', fn($row) => optional($row->patient)->name)
				->addColumn('kartu', fn($row) => optional($row->patient)->jenis_kartu)
				->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
				->addColumn('diagnosa', function ($row) {
					if (!is_string($row->diagnosa)) {
						return '-';
					}
					$diagnosaIds = explode(',', $row->diagnosa);
					$diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();
					return implode(', ', $diagnoses);
				})
				->addColumn('kunjungan', function ($row) {
					$kunjunganCount = Kunjungan::where('pasien', $row->id_patient)->count();

					return $kunjunganCount == 1 ? 'Baru' : 'Lama';
				})
				->addColumn('action', function ($row) use ($routeName) {
				    return '<div class="action-buttons">
				                <button type="button" class="btn btn-primary btn-sm text-white"
				                    data-id="' . $row->id . '"
									data-route-name="' . $routeName . '"
				                    data-url="' . route('loadModal.editKajianAwal', $row->id) . '"
				                    onclick="loadEditModal(this)">
				                    <i class="fas fa-edit"></i>
				                </button>
				                <form action="' . route('action.destroy', $row->id) . '" method="POST" class="d-inline">
				                    ' . csrf_field() . method_field('DELETE') . '
				                    <button type="submit" class="btn btn-danger btn-sm text-white" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
				                        <i class="fas fa-trash-alt"></i>
				                    </button>
				                </form>
				            </div>';
				})
				->rawColumns(['action'])
				->make(true);
		}

		return view('kajian-awal.index', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName', 'obats'));
	}

	public function gigi(Request $request)
	{
		$dokter = User::where('role', 'dokter')->get();
		$diagnosa = Diagnosis::all();
		$penyakit = Disease::all();
		$rs = Hospital::all();
		$routeName = $request->route()->getName();
		$poli = Poli::all();
		$diagnosa = Diagnosis::all();

		$obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')
			->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')
			->selectRaw('SUM(terima_obat.amount) as total_stock')
			->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')
			->get();

		if ($request->ajax()) {
			$startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
			$endDate = $request->input('end_date') ?? Carbon::today()->toDateString();

			$actionsQuery = Action::with([
					'patient:id,nik,no_rm,name,dob,jenis_kartu,wilayah_faskes',
					'hospitalReferral'
				])
				->select('actions.id', 'tanggal', 'diagnosa', 'keluhan', 'tindakan', 'id_patient', 'rujuk_rs')
				->where('tipe', 'poli-gigi')
				->whereDate('tanggal', '>=', $startDate)
				->whereDate('tanggal', '<=', $endDate);

			return DataTables::of($actionsQuery)
				->filter(function ($query) use ($request) {
					if ($search = $request->input('search.value')) {
						$query->where(function ($q) use ($search) {
							$q->orWhereHas('patient', function ($patientQuery) use ($search) {
								$patientQuery->where('nik', 'like', "%{$search}%")
									->orWhere('name', 'like', "%{$search}%")
									->orWhere('jenis_kartu', 'like', "%{$search}%")
									->orWhere('no_rm', 'like', "%{$search}%");
							});

							$q->orWhereHas('hospitalReferral', function ($patientQuery) use ($search) {
								$patientQuery->where('name', 'like', "%{$search}%");
							});

							$q->orWhere('keluhan', 'like', "%{$search}%")
							  ->orWhere('tindakan', 'like', "%{$search}%")
							  ->orWhere('tanggal', 'like', "%{$search}%");

							$q->orWhereRaw("(SELECT COUNT(*) FROM kunjungan WHERE kunjungan.pasien = actions.id_patient) = 1 AND 'Baru' LIKE ?", ["%{$search}%"]);
							$q->orWhereRaw("(SELECT COUNT(*) FROM kunjungan WHERE kunjungan.pasien = actions.id_patient) > 1 AND 'Lama' LIKE ?", ["%{$search}%"]);
						});
					}
				})
				->orderColumn('patient_nik', function ($query, $order) {
					$query->join('patients', 'actions.id_patient', '=', 'patients.id')
						  ->orderBy('patients.nik', $order);
				})
				->orderColumn('patient_no_rm', function ($query, $order) {
					$query->join('patients', 'actions.id_patient', '=', 'patients.id')
						  ->orderBy('patients.no_rm', $order);
				})
				->orderColumn('patient_name', function ($query, $order) {
					$query->join('patients', 'actions.id_patient', '=', 'patients.id')
						  ->orderBy('patients.name', $order);
				})
				->orderColumn('patient_age', function ($query, $order) {
					$query->join('patients', 'actions.id_patient', '=', 'patients.id')
						  ->orderBy('patients.dob', $order);
				})
				->orderColumn('kartu', function ($query, $order) {
					$query->join('patients', 'actions.id_patient', '=', 'patients.id')
						  ->orderBy('patients.jenis_kartu', $order);
				})
				->orderColumn('tanggal', function ($query, $order) {
					$query->orderBy('tanggal', $order);
				})
				->addIndexColumn()
				->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
				->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
				->addColumn('patient_name', fn($row) => optional($row->patient)->name)
				->addColumn('kartu', fn($row) => optional($row->patient)->jenis_kartu)
				->addColumn('patient_age', fn($row) =>
					optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-'
				)
				->addColumn('diagnosa', function ($row) {
					$diagnosa = $row->diagnosa;
					if (is_string($diagnosa)) {
						$diagnosaIds = json_decode($diagnosa, true);
					} elseif (is_array($diagnosa)) {
						$diagnosaIds = $diagnosa;
					} else {
						return '-';
					}

					$diagnosaIds = array_map('intval', $diagnosaIds);
					$diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();

					return !empty($diagnoses) ? implode(', ', $diagnoses) : '-';
				})
				->addColumn('kunjungan', function ($row) {
					$kunjunganCount = Kunjungan::where('pasien', $row->id_patient)->count();
					return $kunjunganCount == 1 ? 'Baru' : 'Lama';
				})
				->addColumn('action', function ($row) use ($routeName) {
					return '<div class="action-buttons">
								<button type="button" class="btn btn-primary btn-sm text-white"
									data-id="' . $row->id . '"
									data-route-name="' . $routeName . '"
									data-url="' . route('loadModal.editKajianAwal', $row->id) . '"
									onclick="loadEditModal(this)">
									<i class="fas fa-edit"></i>
								</button>
								<form action="' . route('action.destroy', $row->id) . '" method="POST" class="d-inline">
									' . csrf_field() . method_field('DELETE') . '
									<button type="submit" class="btn btn-danger btn-sm text-white" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
										<i class="fas fa-trash-alt"></i>
									</button>
								</form>
							</div>';
				})
				->rawColumns(['action'])
				->make(true);
		}

		return view('kajian-awal.index', compact(
			'dokter', 'penyakit', 'rs', 'diagnosa', 'routeName', 'obats'
		));
	}

	public function kia(Request $request)
	{
		$dokter = User::where('role', 'dokter')->get();
		$diagnosa = Diagnosis::all();
		$penyakit = Disease::all();
		$rs = Hospital::all();
		$routeName = $request->route()->getName();
		$poli = Poli::all();
		$obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();

		if ($request->ajax()) {
			$startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
			$endDate = $request->input('end_date') ?? Carbon::today()->toDateString();
			$actionsQuery = Action::with(['patient', 'hospitalReferral'])->where('tipe', 'poli-kia'); // Ensure 'diagnosa' is not null

			$actionsQuery->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate);

			$actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

			$actions = $actionsQuery->get();

			return DataTables::of($actions)
				->addIndexColumn()
				->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
				->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
				->addColumn('patient_name', fn($row) => optional($row->patient)->name)
				->addColumn('kartu', fn($row) => optional($row->patient)->jenis_kartu)
				->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
				->addColumn('diagnosa', function ($row) {
					$diagnosa = $row->diagnosa;

					if (is_string($diagnosa)) {
						$diagnosaIds = json_decode($diagnosa, true);
					} elseif (is_array($diagnosa)) {
						$diagnosaIds = $diagnosa;
					} else {
						return '-';
					}

					$diagnosaIds = array_map('intval', $diagnosaIds);
					$diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();

					return !empty($diagnoses) ? implode(', ', $diagnoses) : '-';
				})
				->addColumn('kunjungan', function ($row) {
					$kunjunganCount = Kunjungan::where('pasien', $row->id_patient)->count();

					return $kunjunganCount == 1 ? 'Baru' : 'Lama';
				})
				->addColumn('action', function ($row) use ($routeName) {
					return '<div class="action-buttons">
								<button type="button" class="btn btn-primary btn-sm text-white"
									data-id="' . $row->id . '"
									data-route-name="' . $routeName . '"
									data-url="' . route('loadModal.editKajianAwal', $row->id) . '"
									onclick="loadEditModal(this)">
									<i class="fas fa-edit"></i>
								</button>
								<form action="' . route('action.destroy', $row->id) . '" method="POST" class="d-inline">
									' . csrf_field() . method_field('DELETE') . '
									<button type="submit" class="btn btn-danger btn-sm text-white" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
										<i class="fas fa-trash-alt"></i>
									</button>
								</form>
							</div>';
				})
				->rawColumns(['action'])
				->make(true);
		}

		return view('kajian-awal.index', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName', 'obats', 'poli'));
	}

	public function kb(Request $request)
	{
		$dokter = User::where('role', 'dokter')->get();
		$diagnosa = Diagnosis::all();
		$penyakit = Disease::all();
		$rs = Hospital::all();
		$routeName = $request->route()->getName();
		$poli = Poli::all();
		$obats = Obat::select('obat.id', 'obat.name', 'obat.code', 'obat.shape')->join('terima_obat', 'obat.id', '=', 'terima_obat.id_obat')->selectRaw('SUM(terima_obat.amount) as total_stock')->groupBy('obat.id', 'obat.name', 'obat.code', 'obat.shape')->get();

		if ($request->ajax()) {
			$startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
			$endDate = $request->input('end_date') ?? Carbon::today()->toDateString();
			$actionsQuery = Action::with(['patient', 'hospitalReferral'])->where('tipe', 'poli-kb'); // Ensure 'diagnosa' is not null

			$actionsQuery->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate);

			$actionsQuery->orderByDesc('tanggal')->orderByDesc('created_at');

			$actions = $actionsQuery->get();

			return DataTables::of($actions)
				->addIndexColumn()
				->editColumn('tanggal', fn($row) => $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-')
				->addColumn('patient_nik', fn($row) => optional($row->patient)->nik . '/' . optional($row->patient)->no_rm)
				->addColumn('patient_name', fn($row) => optional($row->patient)->name)
				->addColumn('kartu', fn($row) => optional($row->patient)->jenis_kartu)
				->addColumn('patient_age', fn($row) => optional($row->patient->dob) ? Carbon::parse($row->patient->dob)->age . ' Tahun' : '-')
				->addColumn('diagnosa', function ($row) {
					$diagnosa = $row->diagnosa;

					if (is_string($diagnosa)) {
						$diagnosaIds = json_decode($diagnosa, true);
					} elseif (is_array($diagnosa)) {
						$diagnosaIds = $diagnosa;
					} else {
						return '-';
					}

					$diagnosaIds = array_map('intval', $diagnosaIds);
					$diagnoses = Diagnosis::whereIn('id', $diagnosaIds)->pluck('name')->toArray();

					return !empty($diagnoses) ? implode(', ', $diagnoses) : '-';
				})
				->addColumn('kunjungan', function ($row) {
					$kunjunganCount = Kunjungan::where('pasien', $row->id_patient)->count();

					return $kunjunganCount == 1 ? 'Baru' : 'Lama';
				})

				->addColumn('action', function ($row) use ($routeName) {
					return '<div class="action-buttons">
								<button type="button" class="btn btn-primary btn-sm text-white"
									data-id="' . $row->id . '"
									data-route-name="' . $routeName . '"
									data-url="' . route('loadModal.editKajianAwal', $row->id) . '"
									onclick="loadEditModal(this)">
									<i class="fas fa-edit"></i>
								</button>
								<form action="' . route('action.destroy', $row->id) . '" method="POST" class="d-inline">
									' . csrf_field() . method_field('DELETE') . '
									<button type="submit" class="btn btn-danger btn-sm text-white" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
										<i class="fas fa-trash-alt"></i>
									</button>
								</form>
							</div>';
				})
				->rawColumns(['action'])
				->make(true);
		}
		return view('kajian-awal.index', compact('dokter', 'penyakit', 'rs', 'diagnosa', 'routeName', 'obats', 'poli'));
	}

}
