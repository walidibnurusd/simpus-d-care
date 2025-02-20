<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Patients;
use App\Models\Hipertensi;
use App\Models\Kunjungan;
use App\Models\GangguanAutis;
use App\Models\Anemia;
use App\Models\Talasemia;
use App\Models\DiabetesMellitus;
use App\Models\GangguanJiwaAnak;
use App\Models\GangguanJiwaRemaja;
use App\Models\Geriatri;
use App\Models\Hepatitis;
use App\Models\Hiv;
use App\Models\KankerKolorektal;
use App\Models\KankerParu;
use App\Models\KankerPayudara;
use App\Models\Kecacingan;
use App\Models\KekerasanPerempuan;
use App\Models\KekerasanAnak;
use App\Models\LayakHamil;
use App\Models\Merokok;
use App\Models\Napza;
use App\Models\Obesitas;
use App\Models\Tbc;
use App\Models\TesDayaDengar;
use App\Models\TripleEliminasi;
use App\Models\Puma;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PatientImport;

class PatientsController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new PatientImport(), $request->file('file'));

        return redirect()->back()->with('success', 'Data pasien berhasil diimport.');
    }
    public function getPatients(Request $request)
    {
        // Ambil parameter pagination dari DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');

        // Hitung halaman berdasarkan DataTables `start` dan `length`
        $page = $start / $length + 1;

        // Query dengan relasi dan filter pencarian
        $query = Patients::with('genderName', 'educations', 'occupations');

        if (!empty($searchValue)) {
            $query
                ->where('name', 'LIKE', "%{$searchValue}%")
                ->orWhere('address', 'LIKE', "%{$searchValue}%")
                ->orWhere('nik', 'LIKE', "%{$searchValue}%")
                ->orWhere('no_rm', 'LIKE', "%{$searchValue}%")
                ->orWhere('no_family_folder', 'LIKE', "%{$searchValue}%")
                ->orWhereHas('genderName', function ($q) use ($searchValue) {
                    $q->where('gender', 'LIKE', "%{$searchValue}%");
                });
        }

        // Ambil data dengan pagination
        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(), // Data pasien
        ]);
    }
    public function getPatientsPoliUmum(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');

        $page = $start / $length + 1;
        $today = Carbon::now()->toDateString();
        $query = Patients::with(['genderName', 'educations', 'occupations'])
            ->whereHas('kunjungans', function ($q) use ($today) {
                $q->where('poli', 'poli-umum')->where('tanggal', $today);
            })
            ->whereDoesntHave('actions', function ($q) use ($today) {
                $q->where('tipe', 'poli-umum')->where('tanggal', $today);
            });

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('address', 'LIKE', "%{$searchValue}%")
                    ->orWhere('nik', 'LIKE', "%{$searchValue}%")
                    ->orWhere('nik', 'LIKE', "%{$searchValue}%")
                    ->orWhereHas('genderName', function ($q) use ($searchValue) {
                        $q->where('gender', 'LIKE', "%{$searchValue}%");
                    });
            });
        }

        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        $data = $patients->items();
        $formattedData = [];
        foreach ($data as $patient) {
            $kunjunganCreatedAt = optional($patient->kunjungans->last())->created_at;
            $formattedData[] = [
                'id' => $patient->id,
                'name' => $patient->name,
                'nik' => $patient->nik,
                'address' => $patient->address,
                'jenis_kartu' => $patient->jenis_kartu,
                'nomor_kartu' => $patient->nomor_kartu,
                'blood_type' => $patient->blood_type,
                'no_rm' => $patient->no_rm,
                'dob' => $patient->dob,
                'phone' => $patient->phone,
                'gender' => $patient->genderName->gender ?? '-',
                'education' => $patient->educations->name ?? '-',
                'occupation' => $patient->occupations->name ?? '-',
                'created_at' => $kunjunganCreatedAt ? $kunjunganCreatedAt->format('d-m-Y H:i:s') : '-',
            ];
        }

        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $formattedData,
        ]);
    }
    public function getPatientsPoliGigi(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');

        $page = $start / $length + 1;
        $today = Carbon::now()->toDateString();
        $query = Patients::with(['genderName', 'educations', 'occupations'])
            ->whereHas('kunjungans', function ($q) use ($today) {
                $q->where('poli', 'poli-gigi')->where('tanggal', $today);
            })
            ->whereDoesntHave('actions', function ($q) use ($today) {
                $q->where('tipe', 'poli-gigi')->where('tanggal', $today);
            });
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('address', 'LIKE', "%{$searchValue}%")
                    ->orWhere('nik', 'LIKE', "%{$searchValue}%")
                    ->orWhere('nik', 'LIKE', "%{$searchValue}%")
                    ->orWhereHas('genderName', function ($q) use ($searchValue) {
                        $q->where('gender', 'LIKE', "%{$searchValue}%");
                    });
            });
        }

        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        $data = $patients->items();
        $formattedData = [];
        foreach ($data as $patient) {
            $kunjunganCreatedAt = optional($patient->kunjungans->last())->created_at;
            $formattedData[] = [
                'id' => $patient->id,
                'name' => $patient->name,
                'nik' => $patient->nik,
                'address' => $patient->address,
                'jenis_kartu' => $patient->jenis_kartu,
                'nomor_kartu' => $patient->nomor_kartu,
                'blood_type' => $patient->blood_type,
                'no_rm' => $patient->no_rm,
                'dob' => $patient->dob,
                'phone' => $patient->phone,
                'gender' => $patient->genderName->gender ?? '-',
                'education' => $patient->educations->name ?? '-',
                'occupation' => $patient->occupations->name ?? '-',
                'created_at' => $kunjunganCreatedAt ? $kunjunganCreatedAt->format('d-m-Y H:i:s') : '-',
            ];
        }

        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $formattedData,
        ]);
    }
    public function getPatientsPoliKia(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');

        $page = $start / $length + 1;
        $today = Carbon::now()->toDateString();
        $query = Patients::with(['genderName', 'educations', 'occupations'])
            ->whereHas('kunjungans', function ($q) use ($today) {
                $q->where('poli', 'poli-kia')->where('tanggal', $today);
            })
            ->whereDoesntHave('actions', function ($q) use ($today) {
                $q->where('tipe', 'poli-kia')->where('tanggal', $today);
            });

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('address', 'LIKE', "%{$searchValue}%")
                    ->orWhere('nik', 'LIKE', "%{$searchValue}%")
                    ->orWhere('nik', 'LIKE', "%{$searchValue}%")
                    ->orWhereHas('genderName', function ($q) use ($searchValue) {
                        $q->where('gender', 'LIKE', "%{$searchValue}%");
                    });
            });
        }

        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        $data = $patients->items();
        $formattedData = [];
        foreach ($data as $patient) {
            $kunjunganCreatedAt = optional($patient->kunjungans->last())->created_at;
            $formattedData[] = [
                'id' => $patient->id,
                'name' => $patient->name,
                'nik' => $patient->nik,
                'address' => $patient->address,
                'jenis_kartu' => $patient->jenis_kartu,
                'nomor_kartu' => $patient->nomor_kartu,
                'blood_type' => $patient->blood_type,
                'no_rm' => $patient->no_rm,
                'dob' => $patient->dob,
                'phone' => $patient->phone,
                'gender' => $patient->genderName->gender ?? '-',
                'education' => $patient->educations->name ?? '-',
                'occupation' => $patient->occupations->name ?? '-',
                'created_at' => $kunjunganCreatedAt ? $kunjunganCreatedAt->format('d-m-Y H:i:s') : '-',
            ];
        }

        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $formattedData,
        ]);
    }

    public function getPatientsPoliKb(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');

        $page = $start / $length + 1;
        $today = Carbon::now()->toDateString();
        $query = Patients::with(['genderName', 'educations', 'occupations'])
            ->whereHas('kunjungans', function ($q) use ($today) {
                $q->where('poli', 'poli-kb')->where('tanggal', $today);
            })
            ->whereDoesntHave('actions', function ($q) use ($today) {
                $q->where('tipe', 'poli-kb')->where('tanggal', $today);
            });
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('address', 'LIKE', "%{$searchValue}%")
                    ->orWhere('nik', 'LIKE', "%{$searchValue}%")
                    ->orWhereHas('genderName', function ($q) use ($searchValue) {
                        $q->where('gender', 'LIKE', "%{$searchValue}%");
                    });
            });
        }

        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        $data = $patients->items();
        $formattedData = [];
        foreach ($data as $patient) {
            $kunjunganCreatedAt = optional($patient->kunjungans->last())->created_at;
            $formattedData[] = [
                'id' => $patient->id,
                'name' => $patient->name,
                'nik' => $patient->nik,
                'address' => $patient->address,
                'jenis_kartu' => $patient->jenis_kartu,
                'nomor_kartu' => $patient->nomor_kartu,
                'blood_type' => $patient->blood_type,
                'no_rm' => $patient->no_rm,
                'dob' => $patient->dob,
                'phone' => $patient->phone,
                'gender' => $patient->genderName->gender ?? '-',
                'education' => $patient->educations->name ?? '-',
                'occupation' => $patient->occupations->name ?? '-',
                'created_at' => $kunjunganCreatedAt ? $kunjunganCreatedAt->format('d-m-Y H:i:s') : '-',
            ];
        }

        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $formattedData,
        ]);
    }

    public function getPatientsRuangTindakan(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');

        $page = $start / $length + 1;
        $today = Carbon::now()->toDateString();
        $query = Patients::with(['genderName', 'educations', 'occupations'])
            ->whereHas('kunjungans', function ($q) use ($today) {
                $q->where('poli', 'ruang-tindakan')->where('tanggal', $today);
            })
            ->whereDoesntHave('actions', function ($q) use ($today) {
                $q->where('tipe', 'ruang-tindakan')->where('tanggal', $today);
            });
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('address', 'LIKE', "%{$searchValue}%")
                    ->orWhere('nik', 'LIKE', "%{$searchValue}%")
                    ->orWhereHas('genderName', function ($q) use ($searchValue) {
                        $q->where('gender', 'LIKE', "%{$searchValue}%");
                    });
            });
        }

        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        $data = $patients->items();
        $formattedData = [];
        foreach ($data as $patient) {
            $kunjunganCreatedAt = optional($patient->kunjungans->last())->created_at;
            $formattedData[] = [
                'id' => $patient->id,
                'name' => $patient->name,
                'nik' => $patient->nik,
                'address' => $patient->address,
                'jenis_kartu' => $patient->jenis_kartu,
                'nomor_kartu' => $patient->nomor_kartu,
                'blood_type' => $patient->blood_type,
                'no_rm' => $patient->no_rm,
                'dob' => $patient->dob,
                'phone' => $patient->phone,
                'gender' => $patient->genderName->gender ?? '-',
                'education' => $patient->educations->name ?? '-',
                'occupation' => $patient->occupations->name ?? '-',
                'created_at' => $kunjunganCreatedAt ? $kunjunganCreatedAt->format('d-m-Y H:i:s') : '-',
            ];
        }

        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $formattedData,
        ]);
    }
    public function getPatientsDokter(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        $page = $start / $length + 1;
        // $query = DB::table('patients')
        // ->leftJoin('actions', 'patients.id', '=', 'actions.id_patient')
        // ->leftJoin('kunjungan', 'patients.id', '=', 'kunjungan.pasien')
        // ->select(
        //     'patients.id as patient_id', 'patients.*',
        //     'actions.id as action_id', 'actions.*',
        //     'kunjungan.id as kunjungan_id', 'kunjungan.*'
        // )
        // ->whereNotNull('kunjungan.id')
        // ->whereNull('actions.diagnosa')
        // ->where('kunjungan.poli', 'poli-umum');
        $query = DB::table('kunjungan')
            ->leftJoin('actions', function ($join) {
                $join->on('kunjungan.pasien', '=', 'actions.id_patient')->whereRaw('DATE(kunjungan.tanggal) = DATE(actions.tanggal)'); // Pastikan tanggal sama
            })
            ->leftJoin('patients', 'kunjungan.pasien', '=', 'patients.id')
            ->select('patients.id as patient_id', 'patients.*', 'actions.id as action_id', 'actions.*', 'kunjungan.id as kunjungan_id', 'kunjungan.*')
            ->whereNotNull('kunjungan.id')
            ->whereNull('actions.diagnosa')
            ->where('kunjungan.poli', 'poli-umum');

        // $query = Kunjungan::with(['patient', 'patient.actions']) // ✅ Ambil relasi pasien & tindakan
        // ->whereHas('patient.actions', function ($query) {
        //     $query->whereNull('diagnosa'); // ✅ Filter yang belum punya diagnosa
        // })
        // ->where('poli', 'poli-umum');

        // if ($filterDate) {
        //     $query->whereBetween('kunjungan.created_at', [Carbon::parse($filterDate)->startOfDay(), Carbon::parse($filterDate)->endOfDay()]);
        // }
        if ($filterDate) {
            $query->where('kunjungan.tanggal', '=', $filterDate);
        }

        if (!empty($searchValue)) {
            $query
                ->where('name', 'LIKE', "%{$searchValue}%")
                ->orWhere('address', 'LIKE', "%{$searchValue}%")
                ->orWhere('dob', 'LIKE', "%{$searchValue}%")
                ->orWhere('nik', 'LIKE', "%{$searchValue}%");
        }

        $patients = $query->paginate($length, ['*'], 'page', $page);
        // dd($patients);
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(),
        ]);
    }
    public function getPatientsDokterGigi(Request $request)
    {
        // Ambil parameter DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        // Hitung halaman berdasarkan DataTables `start` dan `length`
        $page = $start / $length + 1;

        $query = DB::table('kunjungan')
            ->leftJoin('actions', function ($join) {
                $join->on('kunjungan.pasien', '=', 'actions.id_patient')->whereRaw('DATE(kunjungan.tanggal) = DATE(actions.tanggal)'); // Pastikan tanggal sama
            })
            ->leftJoin('patients', 'kunjungan.pasien', '=', 'patients.id')
            ->select('patients.id as patient_id', 'patients.*', 'actions.id as action_id', 'actions.*', 'kunjungan.id as kunjungan_id', 'kunjungan.*')
            ->whereNotNull('kunjungan.id')
            ->whereNull('actions.diagnosa')
            ->where('kunjungan.poli', 'poli-gigi');

        if ($filterDate) {
            $query->where('kunjungan.tanggal', '=', $filterDate);
        }

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('patients.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('dob', 'LIKE', "%{$searchValue}%")
                    ->orWhere('patients.address', 'LIKE', "%{$searchValue}%")
                    ->orWhere('patients.nik', 'LIKE', "%{$searchValue}%");
            });
        }

        // Ambil data dengan pagination
        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(), // Data pasien yang dipaginasikan
        ]);
    }
    public function getPatientsDokterRuangTindakan(Request $request)
    {
        // Ambil parameter DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        // Hitung halaman berdasarkan DataTables `start` dan `length`
        $page = $start / $length + 1;
        $query = DB::table('kunjungan')
            ->leftJoin('actions', function ($join) {
                $join->on('kunjungan.pasien', '=', 'actions.id_patient')->whereRaw('DATE(kunjungan.tanggal) = DATE(actions.tanggal)'); // Pastikan tanggal sama
            })
            ->leftJoin('patients', 'kunjungan.pasien', '=', 'patients.id')
            ->select('patients.id as patient_id', 'patients.*', 'actions.id as action_id', 'actions.*', 'kunjungan.id as kunjungan_id', 'kunjungan.*')
            ->whereNotNull('kunjungan.id')
            ->whereNull('actions.tindakan')
            ->where('kunjungan.poli', 'ruang-tindakan');
        if ($filterDate) {
            $query->where('kunjungan.tanggal', '=', $filterDate);
        }

        if (!empty($searchValue)) {
            $query
                ->where('name', 'LIKE', "%{$searchValue}%")
                ->orWhere('address', 'LIKE', "%{$searchValue}%")
                ->orWhere('dob', 'LIKE', "%{$searchValue}%")
                ->orWhere('nik', 'LIKE', "%{$searchValue}%");
        }

        // dd($query->get());
        // Ambil data dengan pagination
        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(), // Data pasien yang dipaginasikan
        ]);
    }
    public function getPatientsDokterKb(Request $request)
    {
        // Ambil parameter DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        // Hitung halaman berdasarkan DataTables `start` dan `length`
        $page = $start / $length + 1;
        $query = DB::table('kunjungan')
            ->leftJoin('actions', function ($join) {
                $join->on('kunjungan.pasien', '=', 'actions.id_patient')->whereRaw('DATE(kunjungan.tanggal) = DATE(actions.tanggal)'); // Pastikan tanggal sama
            })
            ->leftJoin('patients', 'kunjungan.pasien', '=', 'patients.id')
            ->select('patients.id as patient_id', 'patients.*', 'actions.id as action_id', 'actions.*', 'kunjungan.id as kunjungan_id', 'kunjungan.*')
            ->whereNotNull('kunjungan.id')
            ->whereNull('actions.diagnosa')
            ->where('kunjungan.poli', 'poli-kb');
        if ($filterDate) {
            $query->where('kunjungan.tanggal', '=', $filterDate);
        }
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('patients.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('dob', 'LIKE', "%{$searchValue}%")
                    ->orWhere('patients.address', 'LIKE', "%{$searchValue}%")
                    ->orWhere('patients.nik', 'LIKE', "%{$searchValue}%");
            });
        }
        // Ambil data dengan pagination
        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(), // Data pasien yang dipaginasikan
        ]);
    }
    public function getPatientsDokterKia(Request $request)
    {
        // Ambil parameter DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        // Hitung halaman berdasarkan DataTables `start` dan `length`
        $page = $start / $length + 1;
        $query = DB::table('kunjungan')
            ->leftJoin('actions', function ($join) {
                $join->on('kunjungan.pasien', '=', 'actions.id_patient')->whereRaw('DATE(kunjungan.tanggal) = DATE(actions.tanggal)'); // Pastikan tanggal sama
            })
            ->leftJoin('patients', 'kunjungan.pasien', '=', 'patients.id')
            ->select('patients.id as patient_id', 'patients.*', 'actions.id as action_id', 'actions.*', 'kunjungan.id as kunjungan_id', 'kunjungan.*')
            ->whereNotNull('kunjungan.id')
            ->whereNull('actions.diagnosa')
            ->where('kunjungan.poli', 'poli-kia');

        if ($filterDate) {
            $query->where('kunjungan.tanggal', '=', $filterDate);
        }

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('patients.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('dob', 'LIKE', "%{$searchValue}%")
                    ->orWhere('patients.address', 'LIKE', "%{$searchValue}%")
                    ->orWhere('patients.nik', 'LIKE', "%{$searchValue}%");
            });
        }
        // Ambil data dengan pagination
        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(), // Data pasien yang dipaginasikan
        ]);
    }
    public function getPatientsTindakan(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        $page = $start / $length + 1;

        $query = DB::table('kunjungan')
            ->leftJoin('actions', function ($join) {
                $join->on('kunjungan.pasien', '=', 'actions.id_patient')->whereRaw('DATE(kunjungan.tanggal) = DATE(actions.tanggal)'); // Pastikan tanggal sama
            })
            ->leftJoin('patients', 'kunjungan.pasien', '=', 'patients.id')
            ->select('patients.id as patient_id', 'patients.*', 'actions.id as action_id', 'actions.*', 'kunjungan.id as kunjungan_id', 'kunjungan.*')

            ->whereNotNull('kunjungan.id')
            ->where(function ($query) {
                // If kunjungan.poli is 'tindakan', skip the actions.beri_tindakan = 1 check
                $query
                    ->where(function ($subQuery) {
                        // When kunjungan.poli is 'tindakan', no need to check actions.beri_tindakan = 1
                        $subQuery->where('kunjungan.poli', 'tindakan')->whereNull('actions.tindakan_ruang_tindakan');
                    })
                    ->orWhere(function ($subQuery) {
                        // For other cases, actions.beri_tindakan should be 1 and actions.tindakan_ruang_tindakan should be null
                        $subQuery->where('actions.beri_tindakan', 1)->whereNull('actions.tindakan_ruang_tindakan');
                    });
            });
        if ($filterDate) {
            $query->where('kunjungan.tanggal', '=', $filterDate);
        }
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('patients.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('dob', 'LIKE', "%{$searchValue}%")
                    ->orWhere('patients.address', 'LIKE', "%{$searchValue}%")
                    ->orWhere('patients.nik', 'LIKE', "%{$searchValue}%");
            });
        }
        $patients = $query->paginate($length, ['*'], 'page', $page);

        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(),
        ]);
    }
    public function getPatientsLab(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        $page = $start / $length + 1;

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations', 'hasilLab')->whereHas('hasilLab', function ($q) {
            $q->whereNull('gds')->whereNull('gdp')->whereNull('gdp_2_jam_pp')->whereNull('cholesterol')->whereNull('asam_urat')->whereNull('leukosit')->whereNull('eritrosit')->whereNull('trombosit')->whereNull('hemoglobin')->whereNull('sifilis')->whereNull('hiv')->whereNull('golongan_darah')->whereNull('widal')->whereNull('malaria')->whereNull('albumin')->whereNull('reduksi')->whereNull('urinalisa')->whereNull('tes_kehamilan')->whereNull('telur_cacing')->whereNull('bta')->whereNull('igm_dbd')->whereNull('igm_typhoid');
        });

        if ($filterDate) {
            $query->whereDate('tanggal', $filterDate);
        }

        if (!empty($searchValue)) {
            $query->whereHas('patient', function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")->orWhere('address', 'LIKE', "%{$searchValue}%");
            });
        }

        $patients = $query->paginate($length, ['*'], 'page', $page);
        // dd($patients);
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(),
        ]);
    }

    public function getPatientsLabGigi(Request $request)
    {
        // Ambil parameter DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        // Hitung halaman berdasarkan DataTables `start` dan `length`
        $page = $start / $length + 1;

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations', 'hasilLab')
            ->where('tipe', 'poli-gigi')
            ->whereHas('hasilLab', function ($q) {
                $q->whereNull('gds')->whereNull('gdp')->whereNull('gdp_2_jam_pp')->whereNull('cholesterol')->whereNull('asam_urat')->whereNull('leukosit')->whereNull('eritrosit')->whereNull('trombosit')->whereNull('hemoglobin')->whereNull('sifilis')->whereNull('hiv')->whereNull('golongan_darah')->whereNull('widal')->whereNull('malaria')->whereNull('albumin')->whereNull('reduksi')->whereNull('urinalisa')->whereNull('tes_kehamilan')->whereNull('telur_cacing')->whereNull('bta')->whereNull('igm_dbd')->whereNull('igm_typhoid');
            });
        if ($filterDate) {
            $query->whereDate('tanggal', $filterDate);
        }

        if (!empty($searchValue)) {
            $query->whereHas('patient', function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")->orWhere('address', 'LIKE', "%{$searchValue}%");
            });
        }

        // Ambil data dengan pagination
        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(), // Data pasien yang dipaginasikan
        ]);
    }
    public function getPatientsLabRuangTindakan(Request $request)
    {
        // Ambil parameter DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        // Hitung halaman berdasarkan DataTables `start` dan `length`
        $page = $start / $length + 1;

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations', 'hasilLab')
            ->where('tipe', 'ruang-tindakan')
            ->whereHas('hasilLab', function ($q) {
                $q->whereNull('gds')->whereNull('gdp')->whereNull('gdp_2_jam_pp')->whereNull('cholesterol')->whereNull('asam_urat')->whereNull('leukosit')->whereNull('eritrosit')->whereNull('trombosit')->whereNull('hemoglobin')->whereNull('sifilis')->whereNull('hiv')->whereNull('golongan_darah')->whereNull('widal')->whereNull('malaria')->whereNull('albumin')->whereNull('reduksi')->whereNull('urinalisa')->whereNull('tes_kehamilan')->whereNull('telur_cacing')->whereNull('bta')->whereNull('igm_dbd')->whereNull('igm_typhoid');
            });

        if ($filterDate) {
            $query->whereDate('tanggal', $filterDate);
        }

        if (!empty($searchValue)) {
            $query->whereHas('patient', function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")->orWhere('address', 'LIKE', "%{$searchValue}%");
            });
        }

        // Ambil data dengan pagination
        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(), // Data pasien yang dipaginasikan
        ]);
    }
    public function getPatientsLabKia(Request $request)
    {
        // Ambil parameter DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        // Hitung halaman berdasarkan DataTables `start` dan `length`
        $page = $start / $length + 1;

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations', 'hasilLab')
            ->where('tipe', 'poli-kia')
            ->whereHas('hasilLab', function ($q) {
                $q->whereNull('gds')->whereNull('gdp')->whereNull('gdp_2_jam_pp')->whereNull('cholesterol')->whereNull('asam_urat')->whereNull('leukosit')->whereNull('eritrosit')->whereNull('trombosit')->whereNull('hemoglobin')->whereNull('sifilis')->whereNull('hiv')->whereNull('golongan_darah')->whereNull('widal')->whereNull('malaria')->whereNull('albumin')->whereNull('reduksi')->whereNull('urinalisa')->whereNull('tes_kehamilan')->whereNull('telur_cacing')->whereNull('bta')->whereNull('igm_dbd')->whereNull('igm_typhoid');
            });

        if ($filterDate) {
            $query->whereDate('tanggal', $filterDate);
        }

        if (!empty($searchValue)) {
            $query->whereHas('patient', function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")->orWhere('address', 'LIKE', "%{$searchValue}%");
            });
        }

        // Ambil data dengan pagination
        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(),
        ]);
    }
    public function getPatientsLabKb(Request $request)
    {
        // Ambil parameter DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        // Hitung halaman berdasarkan DataTables `start` dan `length`
        $page = $start / $length + 1;

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations', 'hasilLab')
            ->where('tipe', 'poli-kb')
            ->whereHas('hasilLab', function ($q) {
                $q->whereNull('gds')->whereNull('gdp')->whereNull('gdp_2_jam_pp')->whereNull('cholesterol')->whereNull('asam_urat')->whereNull('leukosit')->whereNull('eritrosit')->whereNull('trombosit')->whereNull('hemoglobin')->whereNull('sifilis')->whereNull('hiv')->whereNull('golongan_darah')->whereNull('widal')->whereNull('malaria')->whereNull('albumin')->whereNull('reduksi')->whereNull('urinalisa')->whereNull('tes_kehamilan')->whereNull('telur_cacing')->whereNull('bta')->whereNull('igm_dbd')->whereNull('igm_typhoid');
            });

        if ($filterDate) {
            $query->whereDate('tanggal', $filterDate);
        }

        if (!empty($searchValue)) {
            $query->whereHas('patient', function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")->orWhere('address', 'LIKE', "%{$searchValue}%");
            });
        }

        // Ambil data dengan pagination
        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(),
        ]);
    }
    public function getPatientsApotik(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        $page = $start / $length + 1;

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')->whereNotNull('obat')->whereNull('update_obat');

        if ($filterDate) {
            $query->whereDate('tanggal', $filterDate);
        }

        if (!empty($searchValue)) {
            $query->whereHas('patient', function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")->orWhere('address', 'LIKE', "%{$searchValue}%");
            });
        }

        $patients = $query->paginate($length, ['*'], 'page', $page);

        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(),
        ]);
    }

    public function getPatientsApotikGigi(Request $request)
    {
        // Ambil parameter DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        // Hitung halaman berdasarkan DataTables `start` dan `length`
        $page = $start / $length + 1;

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')->where('tipe', 'poli-gigi')->whereNotNull('obat')->whereNull('update_obat');
        if ($filterDate) {
            $query->whereDate('tanggal', $filterDate);
        }

        if (!empty($searchValue)) {
            $query->whereHas('patient', function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")->orWhere('address', 'LIKE', "%{$searchValue}%");
            });
        }

        // Ambil data dengan pagination
        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(), // Data pasien yang dipaginasikan
        ]);
    }
    public function getPatientsApotikRuangTindakan(Request $request)
    {
        // Ambil parameter DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        // Hitung halaman berdasarkan DataTables `start` dan `length`
        $page = $start / $length + 1;

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')->where('tipe', 'ruang-tindakan')->whereNotNull('obat')->whereNull('update_obat');

        if ($filterDate) {
            $query->whereDate('tanggal', $filterDate);
        }

        if (!empty($searchValue)) {
            $query->whereHas('patient', function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")->orWhere('address', 'LIKE', "%{$searchValue}%");
            });
        }

        // Ambil data dengan pagination
        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(), // Data pasien yang dipaginasikan
        ]);
    }
    public function getPatientsApotikKia(Request $request)
    {
        // Ambil parameter DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        // Hitung halaman berdasarkan DataTables `start` dan `length`
        $page = $start / $length + 1;

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')->where('tipe', 'poli-kia')->whereNotNull('obat')->whereNull('update_obat');

        if ($filterDate) {
            $query->whereDate('tanggal', $filterDate);
        }

        if (!empty($searchValue)) {
            $query->whereHas('patient', function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")->orWhere('address', 'LIKE', "%{$searchValue}%");
            });
        }

        // Ambil data dengan pagination
        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(),
        ]);
    }
    public function getPatientsApotikKb(Request $request)
    {
        // Ambil parameter DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);
        $searchValue = $request->input('search.value', '');
        $filterDate = $request->input('filterDate', null);

        // Hitung halaman berdasarkan DataTables `start` dan `length`
        $page = $start / $length + 1;

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')->where('tipe', 'poli-kb')->whereNotNull('obat')->whereNull('update_obat');

        if ($filterDate) {
            $query->whereDate('tanggal', $filterDate);
        }

        if (!empty($searchValue)) {
            $query->whereHas('patient', function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")->orWhere('address', 'LIKE', "%{$searchValue}%");
            });
        }

        // Ambil data dengan pagination
        $patients = $query->paginate($length, ['*'], 'page', $page);

        // Format data untuk DataTables
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $patients->total(),
            'recordsFiltered' => $patients->total(),
            'data' => $patients->items(),
        ]);
    }
    public function index()
    {
        $patients = Patients::paginate(10); // Ambil data dengan paginasi 10 per halaman
        return view('content.patients.index', compact('patients'));
    }
    public function getPatientIndex(Request $request)
    {
        // Get the query builder for Patients model
        $patients = Patients::query();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if ($startDate) {
            $patients->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $patients->whereDate('created_at', '<=', $endDate);
        }

        $filters = [
            'nik' => $request->input('nik'),
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'phone' => $request->input('phone'),
            'marrital_status' => $request->input('marrital_status'),
            'no_rm' => $request->input('no_rm'),
            'no_family_folder' => $request->input('no_family_folder'),
            'created_at' => $request->input('created_at'),
        ];

        // Apply filters to the query builder
        foreach ($filters as $column => $value) {
            if ($value) {
                Log::info($column);
                if ($column === 'dob') {
                    $patients->whereDate('dob', 'like', "%$value%");
                } elseif ($column === 'gender') {
                    if (strtolower($value) === 'perempuan') {
                        $patients->where('gender', 1);
                    } else {
                        $patients->where('gender', 2);
                    }
                } elseif ($column === 'marrital_status') {
                    if (strtolower($value) === 'belum menikah' || strtolower($value) === 'belum') {
                        $patients->where('marrital_status', 1);
                    } elseif (strtolower($value) === 'menikah') {
                        $patients->where('marrital_status', 2);
                    } elseif (strtolower($value) === 'janda') {
                        $patients->where('marrital_status', 3);
                    } else {
                        $patients->where('marrital_status', 4);
                    }
                } else {
                    // Generic column search
                    $patients->where($column, 'like', "%$value%");
                }
            }
        }

        // Return the datatables response
        return datatables()
            ->of($patients)
            ->addIndexColumn() // Add index column for row number
            ->editColumn('dob', function ($row) {
                return $row->place_birth . ' / ' . $row->dob . ' (' . $row->getAgeAttribute() . '-thn)';
            })
            ->editColumn('gender', function ($row) {
                return $row->genderName->name ?? '';
            })
            ->editColumn('marrital_status', function ($row) {
                return $row->marritalStatus->name ?? '';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->addColumn('action', function ($row) {
                // Render the modal HTML for this specific row
                $modal = view('component.modal-edit-patient', ['patient' => $row])->render();

                return '<div class="action-buttons">
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-primary btn-sm text-white font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#editPatientModal' .
                    $row->id .
                    '">
                            <i class="fas fa-edit"></i>
                        </button>
                        
                        <!-- Delete Button with a Unique ID -->
                        <button type="button" class="btn btn-danger btn-sm text-white font-weight-bold d-flex align-items-center btn-delete" id="delete-button-' .
                    $row->id .
                    '">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>' .
                    $modal;
            })
            ->make(true);
    }
    public function getPatientDashboard(Request $request)
    {
        // Get the query builder for Patients model
        $patients = Patients::query();
        $startDate = $request->input('start_date') ?? Carbon::today()->toDateString();
        $endDate = $request->input('end_date') ?? Carbon::today()->toDateString();
        $patients->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);

        $filters = [
            'nik' => $request->input('nik'),
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'phone' => $request->input('phone'),
            'marrital_status' => $request->input('marrital_status'),
            'no_rm' => $request->input('no_rm'),
            'no_family_folder' => $request->input('no_family_folder'),
            'created_at' => $request->input('created_at'),
        ];

        // Apply filters to the query builder
        foreach ($filters as $column => $value) {
            if ($value) {
                Log::info($column);
                if ($column === 'dob') {
                    $patients->whereDate('dob', 'like', "%$value%");
                } elseif ($column === 'gender') {
                    if (strtolower($value) === 'perempuan') {
                        $patients->where('gender', 1);
                    } else {
                        $patients->where('gender', 2);
                    }
                } elseif ($column === 'marrital_status') {
                    if (strtolower($value) === 'belum menikah' || strtolower($value) === 'belum') {
                        $patients->where('marrital_status', 1);
                    } elseif (strtolower($value) === 'menikah') {
                        $patients->where('marrital_status', 2);
                    } elseif (strtolower($value) === 'janda') {
                        $patients->where('marrital_status', 3);
                    } else {
                        $patients->where('marrital_status', 4);
                    }
                } else {
                    // Generic column search
                    $patients->where($column, 'like', "%$value%");
                }
            }
        }

        // Return the datatables response
        return datatables()
            ->of($patients)
            ->addIndexColumn() // Add index column for row number
            ->editColumn('dob', function ($row) {
                return $row->place_birth . ' / ' . $row->dob . ' (' . $row->getAgeAttribute() . '-thn)';
            })
            ->editColumn('gender', function ($row) {
                return $row->genderName->name ?? '';
            })
            ->editColumn('marrital_status', function ($row) {
                return $row->marritalStatus->name ?? '';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->addColumn('action', function ($row) {
                // Render the modal HTML for this specific row
                $modal = view('component.modal-edit-patient', ['patient' => $row])->render();

                return '<div class="action-buttons">
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-primary btn-sm text-white font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#editPatientModal' .
                    $row->id .
                    '">
                            <i class="fas fa-edit"></i>
                        </button>
                        
                        <!-- Delete Button with a Unique ID -->
                        <button type="button" class="btn btn-danger btn-sm text-white font-weight-bold d-flex align-items-center btn-delete" id="delete-button-' .
                    $row->id .
                    '">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>' .
                    $modal;
            })
            ->make(true);
    }
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'nik' => 'required|string|max:16',
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:15',
                'gender' => 'required|integer',
                'place_birth' => 'required|string|max:255',
                'dob' => 'required|date',
                'no_family_folder' => 'required|string|max:255',
                'marriage_status' => 'required|integer',
                'blood_type' => 'required|string',
                'education' => 'required|integer',
                'occupation' => 'required|integer',
                'district' => 'required',
                'village' => 'nullable',
                'rw' => 'nullable',
                'poli_berobat' => 'nullable',
                'hamil' => 'nullable',
                'address' => 'required|string|max:255',
                'jenis_kartu' => 'required|string|max:255',
                'nomor_kartu' => 'required|string|max:255',
                'kunjungan' => 'nullable',
                'wilayah_faskes' => 'nullable',
                'tanggal' => 'nullable',
            ]);
            // \Log::info($validatedData);
            // Check if patient with NIK exists
            $patient = Patients::where('nik', $validatedData['nik'])->first();
            if (!$patient) {
                // Create new patient if not exists
                $patient = new Patients();
                $patient->nik = $validatedData['nik'];
                $patient->name = $validatedData['name'];
                $patient->phone = $validatedData['phone'] ?? null;
                $patient->gender = $validatedData['gender'];
                $patient->place_birth = $validatedData['place_birth'];
                $patient->dob = $validatedData['dob'];
                $patient->marrital_status = $validatedData['marriage_status'];
                $patient->blood_type = $validatedData['blood_type'];
                $patient->education = $validatedData['education'];
                $patient->occupation = $validatedData['occupation'];
                $patient->indonesia_province_id = 27;
                $patient->indonesia_city_id = 420;
                $patient->indonesia_district = $validatedData['district'];
                $patient->indonesia_village = $validatedData['village'] ?? null;
                $patient->rw = $validatedData['rw'] ?? null;
                $patient->klaster = null;
                $patient->poli = null;
                $patient->address = $validatedData['address'];
                $patient->jenis_kartu = $validatedData['jenis_kartu'];
                $patient->nomor_kartu = $validatedData['nomor_kartu'];
                $patient->wilayah_faskes = $validatedData['wilayah_faskes'];
                $patient->no_family_folder = $validatedData['no_family_folder'];
                $lastPatient = Patients::orderBy('created_at', 'desc')->first();

                $lastNoRm = $lastPatient ? intval($lastPatient->no_rm) : 0;
                $nextNoRm = str_pad($lastNoRm + 1, 5, '0', STR_PAD_LEFT);
                $patient->no_rm = $nextNoRm;
                $patient->save();
            }
            $existingVisit = Kunjungan::where('pasien', $patient->id)->where('poli', $validatedData['poli_berobat'])->where('tanggal', $validatedData['tanggal'])->first();

            if (!$existingVisit) {
                Kunjungan::create([
                    'pasien' => $patient->id,
                    'poli' => $validatedData['poli_berobat'],
                    'hamil' => $validatedData['hamil'],
                    'tanggal' => $validatedData['tanggal'],
                ]);
            }

            // Create a new Kunjungan entry

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Data berhasil tersimpan');
        } catch (Exception $e) {
            \Log::error('Error occurred: ' . $e->getMessage());
            \Log::error('Stack Trace: ' . $e->getTraceAsString());
            // Log the error
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $errors = $e->errors();
                \Log::error('Validation Errors: ', $errors);

                // Check if specific validation errors exist for 'nik'
                if (isset($errors['nik'])) {
                    $errorMessage = 'NIK Tidak Boleh Lebih Dari 16 Angka';
                    return redirect()
                        ->back()
                        ->withErrors(['nik' => $errorMessage]);
                }

                // Return all other validation errors
                return redirect()->back()->withErrors($errors);
            }

            // Redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while adding the patient or visit. Please try again.');
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
                'no_family_folder' => 'required|string|max:255',
                'marriage_status' => 'required|integer',
                'blood_type' => 'required|string',
                'education' => 'required|integer',
                'occupation' => 'required|integer',
                'district' => 'required',
                'village' => 'nullable',
                'rw' => 'nullable',
                'address' => 'required|string|max:255',
                'jenis_kartu' => 'required|string|max:255',
                'nomor_kartu' => 'required|string|max:255',
                'wilayah_faskes' => 'nullable',
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
            $patient->no_family_folder = $validatedData['no_family_folder'];
            $patient->marrital_status = $validatedData['marriage_status'];
            $patient->blood_type = $validatedData['blood_type'];
            $patient->education = $validatedData['education'];
            $patient->occupation = $validatedData['occupation'];
            $patient->indonesia_province_id = 27;
            $patient->indonesia_city_id = 420;
            $patient->indonesia_district = $validatedData['district'];
            $patient->indonesia_village = $validatedData['village'] ?? null;
            $patient->rw = $validatedData['rw'] ?? null;
            $patient->address = $validatedData['address'];
            $patient->jenis_kartu = $validatedData['jenis_kartu'];
            $patient->nomor_kartu = $validatedData['nomor_kartu'];
            $patient->wilayah_faskes = $validatedData['wilayah_faskes'];

            // Save the updated patient record
            $patient->save();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Data berhasil diubah');
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
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
    public function patientReport()
    {
        $patients = Patients::all(); // Ganti dengan query sesuai kebutuhan
        return view('content.patients.print', compact('patients'));
    }
}
