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
                ->orWhere('nik', 'LIKE', "%{$searchValue}%")
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
        $today = Carbon::today();
        // Query data pasien dengan filter kunjungan poli-umum
        $query = Patients::with([
            'genderName',
            'educations',
            'occupations',
            'kunjungans' => function ($q) use ($today): void {
                $q->where('poli', 'poli-umum')->whereDate('created_at', $today)->select('id', 'pasien', 'created_at');
            },
        ])
            ->whereHas('kunjungans', function ($q) use ($today) {
                $q->where('poli', 'poli-umum')->whereDate('created_at', $today);
            })
            ->whereDoesntHave('actions');

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
            $kunjunganCreatedAt = optional($patient->kunjungans->first())->created_at;
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
        $today = Carbon::today();
        // Query data pasien dengan filter kunjungan poli-umum
        $query = Patients::with([
            'genderName',
            'educations',
            'occupations',
            'kunjungans' => function ($q) use ($today): void {
                $q->where('poli', 'poli-gigi')->whereDate('created_at', $today)->select('id', 'pasien', 'created_at');
            },
        ])
            ->whereHas('kunjungans', function ($q) use ($today) {
                $q->where('poli', 'poli-gigi')->whereDate('created_at', $today); // Hanya pasien yang memiliki kunjungan poli-gigi
            })
            ->whereDoesntHave('actions');

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
            $kunjunganCreatedAt = optional($patient->kunjungans->first())->created_at;
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
        $today = Carbon::today();
        $query = Patients::with([
            'genderName',
            'educations',
            'occupations',
            'kunjungans' => function ($q) use ($today) {
                $q->where('poli', 'poli-kia')->whereDate('created_at', $today)->select('id', 'pasien', 'created_at');
            },
        ])
            ->whereHas('kunjungans', function ($q) use ($today) {
                $q->where('poli', 'poli-kia')->whereDate('created_at', $today);
            })
            ->whereDoesntHave('actions');

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
            $kunjunganCreatedAt = optional($patient->kunjungans->first())->created_at;
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
        $today = Carbon::today();

        $query = Patients::with([
            'genderName',
            'educations',
            'occupations',
            'kunjungans' => function ($q) use ($today) {
                $q->where('poli', 'poli-kb')->whereDate('created_at', $today)->select('id', 'pasien', 'created_at');
            },
        ])
            ->whereHas('kunjungans', function ($q) use ($today) {
                $q->where('poli', 'poli-kb')->whereDate('created_at', $today);
            })
            ->whereDoesntHave('actions');

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
            $kunjunganCreatedAt = optional($patient->kunjungans->first())->created_at;
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
        $today = Carbon::today();

        // Query data pasien dengan filter kunjungan poli-umum
        $query = Patients::with([
            'genderName',
            'educations',
            'occupations',
            'kunjungans' => function ($q) use ($today) {
                $q->where('poli', 'ruang-tindakan')->whereDate('created_at', $today)->select('id', 'pasien', 'created_at');
            },
        ])
            ->whereHas('kunjungans', function ($q) use ($today) {
                $q->where('poli', 'ruang-tindakan')->whereDate('created_at', $today); // Hanya pasien yang memiliki kunjungan ruang-tindakan
            })
            ->whereDoesntHave('actions');

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
            $kunjunganCreatedAt = optional($patient->kunjungans->first())->created_at;
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
        $query = DB::table('patients')
            ->leftJoin('actions', 'patients.id', '=', 'actions.id_patient')
            ->leftJoin('kunjungan', 'patients.id', '=', 'kunjungan.pasien')
            ->select('patients.id as patient_id', 'patients.*', 'actions.id as action_id', 'actions.*', 'kunjungan.id as kunjungan_id', 'kunjungan.*')
            ->whereNotNull('kunjungan.id')
            ->where(function ($query) {
                $query->whereNull('actions.diagnosa');
            })
            ->Where(function ($query) {
                $query->where('kunjungan.poli', 'poli-umum');
            });

        if ($filterDate) {
            $query->whereBetween('kunjungan.created_at', [Carbon::parse($filterDate)->startOfDay(), Carbon::parse($filterDate)->endOfDay()]);
        }

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('patients.name', 'LIKE', "%{$searchValue}%")
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

      $query = DB::table('patients')
            ->leftJoin('actions', 'patients.id', '=', 'actions.id_patient')
            ->leftJoin('kunjungan', 'patients.id', '=', 'kunjungan.pasien')
            ->select('patients.id as patient_id', 'patients.*', 'actions.id as action_id', 'actions.*', 'kunjungan.id as kunjungan_id', 'kunjungan.*')
            ->whereNotNull('kunjungan.id')
            ->where(function ($query) {
                $query->whereNull('actions.diagnosa');
            })
            ->Where(function ($query) {
                $query->where('kunjungan.poli', 'poli-gigi');
            });

        if ($filterDate) {
            $query->whereBetween('kunjungan.created_at', [Carbon::parse($filterDate)->startOfDay(), Carbon::parse($filterDate)->endOfDay()]);
        }

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('patients.name', 'LIKE', "%{$searchValue}%")
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
        $query = DB::table('patients')
            ->leftJoin('actions', 'patients.id', '=', 'actions.id_patient')
            ->leftJoin('kunjungan', 'patients.id', '=', 'kunjungan.pasien')
            ->select('patients.id as patient_id', 'patients.*', 'actions.id as action_id', 'actions.*', 'kunjungan.id as kunjungan_id', 'kunjungan.*')
            ->whereNotNull('kunjungan.id')
            ->where(function ($query) {
                $query->whereNull('actions.tindakan');
            })
            ->Where(function ($query) {
                $query->where('kunjungan.poli', 'ruang-tindakan');
            });

        if ($filterDate) {
            $query->whereBetween('kunjungan.created_at', [Carbon::parse($filterDate)->startOfDay(), Carbon::parse($filterDate)->endOfDay()]);
        }

        if (!empty($searchValue)) {
            $query
                ->where('name', 'LIKE', "%{$searchValue}%")
                ->orWhere('address', 'LIKE', "%{$searchValue}%")
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
       $query = DB::table('patients')
            ->leftJoin('actions', 'patients.id', '=', 'actions.id_patient')
            ->leftJoin('kunjungan', 'patients.id', '=', 'kunjungan.pasien')
            ->select('patients.id as patient_id', 'patients.*', 'actions.id as action_id', 'actions.*', 'kunjungan.id as kunjungan_id', 'kunjungan.*')
            ->whereNotNull('kunjungan.id')
            ->where(function ($query) {
                $query->whereNull('actions.diagnosa');
            })
            ->Where(function ($query) {
                $query->where('kunjungan.poli', 'poli-kb');
            });

        if ($filterDate) {
            $query->where('actions.tanggal', '=', $filterDate);
        }

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('patients.name', 'LIKE', "%{$searchValue}%")
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
       $query = DB::table('patients')
            ->leftJoin('actions', 'patients.id', '=', 'actions.id_patient')
            ->leftJoin('kunjungan', 'patients.id', '=', 'kunjungan.pasien')
            ->select('patients.id as patient_id', 'patients.*', 'actions.id as action_id', 'actions.*', 'kunjungan.id as kunjungan_id', 'kunjungan.*')
            ->whereNotNull('kunjungan.id')
            ->where(function ($query) {
                $query->whereNull('actions.diagnosa');
            })
            ->Where(function ($query) {
                $query->where('kunjungan.poli', 'poli-kia');
            });

        if ($filterDate) {
            $query->where('actions.tanggal', '=', $filterDate);
        }

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('patients.name', 'LIKE', "%{$searchValue}%")
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

        $query = DB::table('patients')
            ->leftJoin('actions', 'patients.id', '=', 'actions.id_patient')
            ->select('patients.*', 'actions.id as action_id', 'actions.*')
            ->where(function ($query) {
                $query->where('actions.beri_tindakan', 1)->whereNull('tindakan_ruang_tindakan');
            });

        if ($filterDate) {
            $query->where('actions.tanggal', '=', $filterDate);
        }
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('patients.name', 'LIKE', "%{$searchValue}%")
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

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')->where('tipe', 'poli-umum')->whereNotNull('pemeriksaan_penunjang');

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

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')->where('tipe', 'poli-gigi')->whereNotNull('pemeriksaan_penunjang');
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

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')->where('tipe', 'ruang-tindakan')->whereNotNull('pemeriksaan_penunjang');

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

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')->where('tipe', 'poli-kia')->whereNotNull('pemeriksaan_penunjang');

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

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')->where('tipe', 'poli-kb')->whereNotNull('pemeriksaan_penunjang');

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

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')->where('tipe', 'poli-umum')->whereNotNull('obat');

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

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')->where('tipe', 'poli-gigi')->whereNotNull('obat');
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

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')->where('tipe', 'ruang-tindakan')->whereNotNull('obat');

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

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')->where('tipe', 'poli-kia')->whereNotNull('obat');

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

        $query = Action::with('patient.genderName', 'patient.educations', 'patient.occupations')->where('tipe', 'poli-kb')->whereNotNull('obat');

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

        // Check if there's a search query
        if ($search = $request->get('search')['value']) {
            $patients->where(function ($query) use ($search) {
                // Filter by any relevant columns (you can add more columns here)
                $query
                    ->where('nik', 'like', "%$search%")
                    ->orWhere('name', 'like', "%$search%")
                    ->orWhere('address', 'like', "%$search%")
                    ->orWhere('dob', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            });
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
                'no_rm' => 'required|string|max:255',
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
            ]);

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
                $patient->no_rm = $validatedData['no_rm'];
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
                $patient->save();
            }
            $existingVisit = Kunjungan::where('pasien', $patient->id)
                ->where('poli', $validatedData['poli_berobat'])
                ->where('tanggal', now()->toDateString())
                ->first();

            if (!$existingVisit) {
                // Create a new Kunjungan entry if it doesn't exist
                Kunjungan::create([
                    'pasien' => $patient->id,
                    'poli' => $validatedData['poli_berobat'],
                    'hamil' => $validatedData['hamil'],
                    'tanggal' => now(),
                ]);
            }

            // Create a new Kunjungan entry

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Patient and visit data added successfully.');
        } catch (Exception $e) {
            // Log the error
            Log::error('Error adding patient or visit: ' . $e->getMessage());

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
                'no_rm' => 'required|string|max:255',
                'marriage_status' => 'required|integer',
                'blood_type' => 'required|string',
                'education' => 'required|integer',
                'occupation' => 'required|integer',
                'district' => 'required',
                'village' => 'nullable',
                'rw' => 'nullable',
                'klaster' => 'required',
                'poli' => 'required',
                'address' => 'required|string|max:255',
                'jenis_kartu' => 'required|string|max:255',
                'nomor_kartu' => 'required|string|max:255',
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
            $patient->indonesia_province_id = 27;
            $patient->indonesia_city_id = 420;
            $patient->indonesia_district = $validatedData['district'];
            $patient->indonesia_village = $validatedData['village'] ?? null;
            $patient->rw = $validatedData['rw'] ?? null;
            $patient->klaster = $validatedData['klaster'] ?? null;
            $patient->poli = $validatedData['poli'] ?? null;
            $patient->address = $validatedData['address'];
            $patient->jenis_kartu = $validatedData['jenis_kartu'];
            $patient->nomor_kartu = $validatedData['nomor_kartu'];

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
