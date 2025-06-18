<?php
use App\Http\Controllers\ActionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DependentDropDownController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IMTController;
use App\Http\Controllers\KadarLemakController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SkriningController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\LoadModalController;
use App\Http\Controllers\KajianAwalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ObatController;

Route::get('/', function () {
    if (Auth::check()) {
        // Jika user sudah login, arahkan ke dashboard
        return redirect()->route('profile');
    } else {
        // Jika user belum login, arahkan ke halaman login
        return redirect()->route('login');
    }
})->name('/');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/skrining-ilp', function () {
    return view('skrining');
})->name('skrining.ilp');
Route::prefix('kia')->group(function () {
    Route::get('layak-hamil', [App\Http\Controllers\KiaController::class, 'showLayakHamil'])->name('layakHamil.view');
    Route::post('/layak-hamil/store', [App\Http\Controllers\KiaController::class, 'storeLayakHamil'])->name('layak_hamil.store');

    Route::get('hipertensi/{id}', [App\Http\Controllers\KiaController::class, 'showHipertensi'])->name('hipertensi.view');
    Route::post('hipertensi', [App\Http\Controllers\KiaController::class, 'storeHipertensi'])->name('hipertensi.store');

    Route::get('preeklampsia/{id}', [App\Http\Controllers\KiaController::class, 'showPreeklampsia'])->name('preeklampsia.view');
    Route::post('preeklampsia', [App\Http\Controllers\KiaController::class, 'storePreeklampsia'])->name('preeklampsia.store');

    Route::get('keswa-srq-dewasa/{id}', [App\Http\Controllers\KiaController::class, 'showGangguanJiwaDewasa'])->name('srq.dewasa.view');
    Route::post('keswa-srq-dewasa', [App\Http\Controllers\KiaController::class, 'storeGangguanJiwaDewasa'])->name('srq.dewasa.store');

    Route::get('malaria/{id}', [App\Http\Controllers\KiaController::class, 'showMigrasiMalaria'])->name('malaria.view');
    Route::post('malaria', [App\Http\Controllers\KiaController::class, 'storeMalaria'])->name('malaria.store');

    Route::get('gangguan-autis/{id}', [App\Http\Controllers\KiaController::class, 'showGangguanAutis'])->name('gangguan.autis.view');
    Route::post('gangguan-autis', [App\Http\Controllers\KiaController::class, 'storeGangguanAutis'])->name('gangguan.autis.store');

    Route::get('anemia/{id}', [App\Http\Controllers\KiaController::class, 'showAnemia'])->name('anemia.view');
    Route::post('anemia', [App\Http\Controllers\KiaController::class, 'storeAnemia'])->name('anemia.store');

    Route::get('kecacingan/{id}', [App\Http\Controllers\KiaController::class, 'showKecacingan'])->name('kecacingan.view');
    Route::post('kecacingan', [App\Http\Controllers\KiaController::class, 'storeKecacingan'])->name('kecacingan.store');

    Route::get('hiv/{id}', [App\Http\Controllers\KiaController::class, 'showHiv'])->name('hiv.view');
    Route::post('hiv', [App\Http\Controllers\KiaController::class, 'storeHiv'])->name('hiv.store');

    Route::get('talasemia/{id}', [App\Http\Controllers\KiaController::class, 'showTalasemia'])->name('talasemia.view');
    Route::post('talasemia', [App\Http\Controllers\KiaController::class, 'storeTalasemia'])->name('talasemia.store');

    Route::get('hepatitis/{id}', [App\Http\Controllers\KiaController::class, 'showHepatitis'])->name('hepatitis.view');
    Route::post('hepatitis', [App\Http\Controllers\KiaController::class, 'storeHepatitis'])->name('hepatitis.store');

    Route::get('kekerasan-anak/{id}', [App\Http\Controllers\KiaController::class, 'showKekerasanAnak'])->name('kekerasan.anak.view');
    Route::post('kekerasan-anak', [App\Http\Controllers\KiaController::class, 'storeKekerasanAnak'])->name('kekerasan.anak.store');

    Route::get('kekerasan-perempuan/{id}', [App\Http\Controllers\KiaController::class, 'showKekerasanPerempuan'])->name('kekerasan.perempuan.view');
    Route::post('kekerasan-perempuan', [App\Http\Controllers\KiaController::class, 'storeKekerasanPerempuan'])->name('kekerasan.perempuan.store');

    Route::get('diabetes-mellitus/{id}', [App\Http\Controllers\KiaController::class, 'showDiabetesMellitus'])->name('diabetes.mellitus.view');
    Route::post('diabetes-mellitus', [App\Http\Controllers\KiaController::class, 'storeDiabetesMellitus'])->name('diabetes.mellitus.store');

    Route::get('tbc/{id}', [App\Http\Controllers\KiaController::class, 'showTbc'])->name('tbc.view');
    Route::post('tbc', [App\Http\Controllers\KiaController::class, 'storeTbc'])->name('tbc.store');

    Route::get('triple-eliminasi-bumil/{id}', [App\Http\Controllers\KiaController::class, 'showTripleEliminasi'])->name('triple.eliminasi.view');
    Route::post('triple-eliminasi-bumil', [App\Http\Controllers\KiaController::class, 'storeTripleEliminasi'])->name('triple.eliminasi.store');
});

Route::prefix('mtbs')->group(function () {
    Route::get('hipertensi', [App\Http\Controllers\KiaController::class, 'showHipertensi'])->name('hipertensi.mtbs.view');
    Route::get('anemia', [App\Http\Controllers\KiaController::class, 'showAnemia'])->name('anemia.mtbs.view');
    Route::get('talasemia', [App\Http\Controllers\KiaController::class, 'showTalasemia'])->name('talasemia.mtbs.view');
    Route::get('kecacingan', [App\Http\Controllers\KiaController::class, 'showKecacingan'])->name('kecacingan.mtbs.view');
    Route::get('kekerasan-anak', [App\Http\Controllers\KiaController::class, 'showKekerasanAnak'])->name('kekerasan.anak.mtbs.view');
    Route::get('kekerasan-perempuan', [App\Http\Controllers\KiaController::class, 'showKekerasanPerempuan'])->name('kekerasan.perempuan.mtbs.view');
    Route::get('diabetes-mellitus', [App\Http\Controllers\KiaController::class, 'showDiabetesMellitus'])->name('diabetes.mellitus.mtbs.view');
    Route::get('tbc', [App\Http\Controllers\KiaController::class, 'showTbc'])->name('tbc.mtbs.view');

    Route::get('keswa-sdq', [App\Http\Controllers\MtbsController::class, 'showSdqAnak'])->name('sdq.mtbs.view');
    Route::post('keswa-sdq', [App\Http\Controllers\MtbsController::class, 'storeSdqAnak'])->name('sdq.mtbs.store');

    Route::get('keswa-sdq-remaja', [App\Http\Controllers\MtbsController::class, 'showSdqRemaja'])->name('sdq.remaja.mtbs.view');
    Route::post('keswa-sdq-remaja', [App\Http\Controllers\MtbsController::class, 'storeSdqRemaja'])->name('sdq.remaja.mtbs.store');

    Route::get('obesitas', [App\Http\Controllers\MtbsController::class, 'showObesitas'])->name('obesitas.mtbs.view');
    Route::post('obesitas', [App\Http\Controllers\MtbsController::class, 'storeObesitas'])->name('obesitas.mtbs.store');

    Route::get('napza', [App\Http\Controllers\MtbsController::class, 'showNapza'])->name('napza.mtbs.view');
    Route::post('napza', [App\Http\Controllers\MtbsController::class, 'storeNapza'])->name('napza.mtbs.store');

    Route::get('merokok', [App\Http\Controllers\MtbsController::class, 'showMerokok'])->name('merokok.mtbs.view');
    Route::post('merokok', [App\Http\Controllers\MtbsController::class, 'storeMerokok'])->name('merokok.mtbs.store');

    Route::get('test-pendengaran', [App\Http\Controllers\MtbsController::class, 'showTestPendengaran'])->name('testPendengaran.mtbs.view');
    Route::post('test-pendengaran', [App\Http\Controllers\MtbsController::class, 'storeTestPendengaran'])->name('testPendengaran.mtbs.store');
});
Route::prefix('lansia')->group(function () {
    Route::get('hipertensi', [App\Http\Controllers\KiaController::class, 'showHipertensi'])->name('hipertensi.lansia.view');
    Route::get('anemia', [App\Http\Controllers\KiaController::class, 'showAnemia'])->name('anemia.lansia.view');
    Route::get('talasemia', [App\Http\Controllers\KiaController::class, 'showTalasemia'])->name('talasemia.lansia.view');
    Route::get('tbc', [App\Http\Controllers\KiaController::class, 'showTbc'])->name('tbc.lansia.view');
    Route::get('obesitas', [App\Http\Controllers\MtbsController::class, 'showObesitas'])->name('obesitas.lansia.view');
    Route::get('layak-hamil', [App\Http\Controllers\KiaController::class, 'showLayakHamil'])->name('layakHamil.lansia.view');

    Route::get('puma', [App\Http\Controllers\LansiaController::class, 'showPuma'])->name('puma.lansia.view');
    Route::post('puma', [App\Http\Controllers\LansiaController::class, 'storePuma'])->name('puma.lansia.store');

    Route::get('geriatri', [App\Http\Controllers\LansiaController::class, 'showGeriatri'])->name('geriatri.lansia.view');
    Route::post('geriatri', [App\Http\Controllers\LansiaController::class, 'storeGeriatri'])->name('geriatri.lansia.store');

    Route::get('kanker-paru', [App\Http\Controllers\LansiaController::class, 'showKankerParu'])->name('kankerParu.lansia.view');
    Route::post('kanker-paru', [App\Http\Controllers\LansiaController::class, 'storeKankerParu'])->name('kankerParu.lansia.store');

    Route::get('kanker-kolorektal', [App\Http\Controllers\LansiaController::class, 'showKankerKolorektal'])->name('kankerKolorektal.lansia.view');
    Route::post('kanker-kolorektal', [App\Http\Controllers\LansiaController::class, 'storeKankerKolorektal'])->name('kankerKolorektal.lansia.store');

    Route::get('kanker-payudara', [App\Http\Controllers\LansiaController::class, 'showKankerPayudara'])->name('kankerPayudara.lansia.view');
    Route::post('kanker-payudara', [App\Http\Controllers\LansiaController::class, 'storeKankerPayudara'])->name('kankerPayudara.lansia.store');
});

Route::middleware('auth')->group(function () {

    Route::prefix('reference')
    ->group(function () {
        Route::prefix('doctor')
            ->group(function () {
                Route::get('/', [ReferenceController::class, 'indexDoctor'])->name('reference.doctor');
                Route::get('/data', [ReferenceController::class, 'indexDataDoctor'])->name('reference.doctor.data');

                Route::post('/', [ReferenceController::class, 'storeDoctor'])->name('reference.doctor.store');
                Route::put('/{id}', [ReferenceController::class, 'updateDoctor']);
                Route::delete('/{id}', [ReferenceController::class, 'destroyDoctor']);
            });
        Route::prefix('poli')
            ->group(function () {
                Route::get('/', [ReferenceController::class, 'indexPoli'])->name('reference.poli');
                Route::get('/data', [ReferenceController::class, 'indexDataPoli'])->name('reference.poli.data');

                Route::post('/', [ReferenceController::class, 'storePoli'])->name('reference.poli.store');
                Route::put('/{id}', [ReferenceController::class, 'updatePoli']);
                Route::delete('/{id}', [ReferenceController::class, 'destroyPoli']);
            });
        Route::prefix('diagnosis')
            ->group(function () {
                Route::get('/', [ReferenceController::class, 'indexDiagnosis'])->name('reference.diagnosis');
                Route::get('/data', [ReferenceController::class, 'indexDataDiagnosis'])->name('reference.diagnosis.data');

                Route::post('/', [ReferenceController::class, 'storeDiagnosis'])->name('reference.diagnosis.store');
                Route::put('/{id}', [ReferenceController::class, 'updateDiagnosis']);
                Route::delete('/{id}', [ReferenceController::class, 'destroyDiagnosis']);
            });

        Route::prefix('obat')
            ->group(function () {
                Route::get('/', [ReferenceController::class, 'indexObat'])->name('reference.obat');
                Route::get('/data', [ReferenceController::class, 'indexDataObat'])->name('reference.obat.data');

                Route::post('/', [ReferenceController::class, 'storeObat'])->name('reference.obat.store');
                Route::put('/{id}', [ReferenceController::class, 'updateObat']);
                Route::delete('/{id}', [ReferenceController::class, 'destroyObat']);
            });

        Route::prefix('tindakan')
            ->group(function () {
                Route::get('/', [ReferenceController::class, 'indexTindakan'])->name('reference.tindakan');
                Route::get('/data', [ReferenceController::class, 'indexDataTindakan'])->name('reference.tindakan.data');

                Route::post('/', [ReferenceController::class, 'storeTindakan'])->name('reference.tindakan.store');
                Route::put('/{id}', [ReferenceController::class, 'updateTindakan']);
                Route::delete('/{id}', [ReferenceController::class, 'destroyTindakan']);
            });

        Route::prefix('rumah-sakit')
            ->group(function () {
                Route::get('/', [ReferenceController::class, 'indexRumahSakit'])->name('reference.rumahsakit');
                Route::get('/data', [ReferenceController::class, 'indexDataRumahSakit'])->name('reference.rumahsakit.data');

                Route::post('/', [ReferenceController::class, 'storeRumahSakit'])->name('reference.rumahsakit.store');
                Route::put('/{id}', [ReferenceController::class, 'updateRumahSakit']);
                Route::delete('/{id}', [ReferenceController::class, 'destroyRumahSakit']);
            });
    });

    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/import/patients', [PatientsController::class, 'import'])->name('patient.import');
    Route::get('/patients/data', [PatientsController::class, 'getPatientIndex'])->name('patient.data');
    Route::get('/patients/dashboard', [PatientsController::class, 'getPatientDashboard'])->name('patient.dashboard');

    Route::get('/patients', [PatientsController::class, 'index'])->name('patient.index');
    Route::post('/patients', [PatientsController::class, 'store'])->name('patient.store');
    Route::put('/patients/{id}', [PatientsController::class, 'update'])->name('patient.update');
    Route::delete('/patients/{id}', [PatientsController::class, 'destroy'])->name('patient.destroy');
    Route::get('/laporan/patients', [PatientsController::class, 'patientReport'])->name('patient.report');

	Route::prefix('kajian-awal')
        ->name('kajian-awal.')
        ->group(function () {
            Route::get('/poli-umum', [KajianAwalController::class, 'umum'])->name('umum');
            Route::get('/poli-gigi', [KajianAwalController::class, 'gigi'])->name('gigi');
            Route::get('/ugd', [KajianAwalController::class, 'ugd'])->name('ugd');
            Route::get('/kia', [KajianAwalController::class, 'kia'])->name('kia');
            Route::get('/kb', [KajianAwalController::class, 'kb'])->name('kb');
        });
    Route::prefix('tindakan')
        ->name('action.')
        ->group(function () {
            Route::get('/poli-umum', [ActionController::class, 'indexDokter'])->name('dokter.index');
            Route::get('/poli-gigi', [ActionController::class, 'indexGigiDokter'])->name('dokter.gigi.index');
            Route::get('/ugd', [ActionController::class, 'indexUgdDokter'])->name('dokter.ugd.index');
            Route::get('/ruang-tindakan', [ActionController::class, 'indexRuangTindakanDokter'])->name('dokter.ruang.tindakan.index');
            Route::get('/poli-kia', [ActionController::class, 'indexDokterKia'])->name('kia.dokter.index');
            Route::get('/poli-kb', [ActionController::class, 'indexDokterKb'])->name('kb.dokter.index');

            Route::get('/lab', [ActionController::class, 'indexLab'])->name('lab.index');

            Route::get('/apotik', [ActionController::class, 'indexApotik'])->name('apotik.index');
            Route::get('/pdf-example', [ObatController::class, 'generatePrescription'])->name('apotik.generate');
        });

    Route::post('/tindakan', [ActionController::class, 'store'])->name('action.store');
    Route::post('/tindakan-edit/{id}', [ActionController::class, 'update'])->name('action.update');
    Route::post('/tindakan-dokter/{id}', [ActionController::class, 'updateDokter'])->name('action.update.dokter');
    Route::post('/dokter-tindakan/{id}', [ActionController::class, 'updateTindakan'])->name('action.update.dokter.tindakan');
    Route::post('/tindakan-lab/{id}', [ActionController::class, 'updateLab'])->name('action.update.lab');
    Route::post('/tindakan-lab-edit/{id}', [ActionController::class, 'updateLabEdit'])->name('action.update.lab.edit');
    Route::post('/tindakan-apotik/{id}', [ActionController::class, 'updateApotik'])->name('action.update.apotik');
    Route::delete('/tindakan/{id}', [ActionController::class, 'destroy'])->name('action.destroy');
    Route::get('/laporan/tindakan', [ActionController::class, 'actionReport'])->name('action.report');

    Route::get('/laporan/poli-umum', [ReportController::class, 'index'])->name('report.index');
    Route::get('/laporan/poli-gigi', [ReportController::class, 'index'])->name('report.index.gigi');
    Route::get('/laporan/ugd', [ReportController::class, 'index'])->name('report.index.ugd');
    Route::get('/laporan/tifoid', [ReportController::class, 'printTifoid'])->name('report.tifoid');
    // Route::get('/laporan/diare', [ReportController::class, 'printDiare'])->name('report.diare');
    Route::get('/laporan/diare', [ReportController::class, 'reportDiare'])->name('report.poli.diare');
    Route::get('/laporan/stp', [ReportController::class, 'reportSTP'])->name('report.stp');
    Route::get('/laporan/ptm', [ReportController::class, 'reportPTM'])->name('report.ptm');
    Route::get('/laporan/afp', [ReportController::class, 'reportAFP'])->name('report.afp');
    Route::get('/laporan/difteri', [ReportController::class, 'reportDifteri'])->name('report.difteri');
    Route::get('/laporan/C1', [ReportController::class, 'reportC1'])->name('report.C1');
    Route::get('/laporan/rjp', [ReportController::class, 'reportRJP'])->name('report.rjp');
    Route::get('/laporan/skdr', [ReportController::class, 'reportSKDR'])->name('report.skdr');
    Route::get('/laporan/lkg', [ReportController::class, 'reportLKG'])->name('report.lkg');
    Route::get('/laporan/lkt', [ReportController::class, 'reportLKT'])->name('report.lkt');
    Route::get('/laporan/lbkt', [ReportController::class, 'reportLBKT'])->name('report.lbkt');
    Route::get('/laporan/urt', [ReportController::class, 'reportURT'])->name('report.urt');
    Route::get('/laporan/lkrj', [ReportController::class, 'reportLKRJ'])->name('report.lkrj');
    Route::post('/laporan/rrt', [ReportController::class, 'reportRRT'])->name('report.rrt');
    Route::get('/laporan/ll', [ReportController::class, 'reportLL'])->name('report.ll');
    Route::get('/laporan/formulir10', [ReportController::class, 'reportFormulir10'])->name('report.formulir10');
    Route::get('/laporan/formulir11', [ReportController::class, 'reportFormulir11'])->name('report.formulir11');
    Route::get('/laporan/formulir12', [ReportController::class, 'reportFormulir12'])->name('report.formulir12');
    Route::get('/laporan/formulir13', [ReportController::class, 'reportFormulir13'])->name('report.formulir13');
    Route::get('/laporan/lr', [ReportController::class, 'reportLR'])->name('report.lr');
    Route::get('/laporan/jamkesda', [ReportController::class, 'reportJamkesda'])->name('report.jamkesda');
    Route::get('/laporan/bpjs', [ReportController::class, 'reportBpjs'])->name('report.bpjs');
    Route::get('/laporan/kunjungan', [ReportController::class, 'reportKunjungan'])->name('report.kunjungan');
    Route::get('/laporan/usia-produktif', [ReportController::class, 'reportUspro'])->name('report.uspro');
    Route::get('/laporan/pandu-hipertensi', [ReportController::class, 'reportPanduHipertensi'])->name('report.pandu.hipertensi');
    Route::get('/laporan/pandu-diabetes', [ReportController::class, 'reportPanduDiabetes'])->name('report.pandu.diabetes');
    Route::put('/profile/{id}', [AuthController::class, 'update'])->name('profile.update');
    Route::put('/change-password/{id}', [AuthController::class, 'changePassword'])->name('change.password');
    Route::prefix('skrining')->group(function () {
        Route::get('/', [SkriningController::class, 'index'])->name('skrining.index');
    });
    Route::prefix('kunjungan')->group(function () {
        Route::get('/', [KunjunganController::class, 'index'])->name('kunjungan.index');
        Route::get('/dashboard', [KunjunganController::class, 'kunjunganDashboard'])->name('kunjungan.dashboard');
        Route::post('/', [KunjunganController::class, 'store'])->name('kunjungan.store');
        Route::put('/{id}', [KunjunganController::class, 'update'])->name('kunjungan.update');
        Route::delete('/{id}', [KunjunganController::class, 'destroy'])->name('kunjungan.delete');
    });
    Route::prefix('admin')->group(function () {
        Route::prefix('kia')->group(function () {
            Route::get('layak-hamil', [App\Http\Controllers\AdminController::class, 'viewLayakHamil'])->name('layakHamil.admin');
            Route::get('/layak-hamil/{id}', [App\Http\Controllers\AdminController::class, 'editLayakHamil'])->name('layak_hamil.edit');
            Route::put('/layak-hamil/{id}', [App\Http\Controllers\AdminController::class, 'updateLayakHamil'])->name('layak_hamil.update');
            Route::delete('/layak-hamil/{id}', [App\Http\Controllers\AdminController::class, 'deleteLayakHamil'])->name('layak_hamil.delete');

            Route::get('/preeklampsia/{id}', [App\Http\Controllers\AdminController::class, 'editPreeklampsia'])->name('preeklampsia.edit');
            Route::put('/preeklampsia/{id}', [App\Http\Controllers\AdminController::class, 'updatePreeklampsia'])->name('preeklampsia.update');
            Route::delete('/preeklampsia/{id}', [App\Http\Controllers\AdminController::class, 'deletePreeklampsia'])->name('preeklampsia.delete');

            Route::get('/keswa-srq-dewasa/{id}', [App\Http\Controllers\AdminController::class, 'editGangguanJiwaDewasa'])->name('srq.dewasa.edit');
            Route::put('/keswa-srq-dewasa/{id}', [App\Http\Controllers\AdminController::class, 'updateGangguanJiwaDewasa'])->name('srq.dewasa.update');
            Route::delete('/keswa-srq-dewasa/{id}', [App\Http\Controllers\AdminController::class, 'deleteGangguanJiwaDewasa'])->name('srq.dewasa.delete');

            Route::get('hipertensi', [App\Http\Controllers\AdminController::class, 'viewHipertensi'])->name('hipertensi.admin');
            Route::get('/hipertensi/{id}', [App\Http\Controllers\AdminController::class, 'editHipertensi'])->name('hipertensi.edit');
            Route::put('/hipertensi/{id}', [App\Http\Controllers\AdminController::class, 'updateHipertensi'])->name('hipertensi.update');
            Route::delete('/hipertensi/{id}', [App\Http\Controllers\AdminController::class, 'deleteHipertensi'])->name('hipertensi.delete');

            Route::get('gangguan-autis', [App\Http\Controllers\AdminController::class, 'viewGangguanAutis'])->name('gangguan.autis.admin');
            Route::get('/gangguan-autis/{id}', [App\Http\Controllers\AdminController::class, 'editGangguanAutis'])->name('gangguan.autis.edit');
            Route::put('/gangguan-autis/{id}', [App\Http\Controllers\AdminController::class, 'updateGangguanAutis'])->name('gangguan.autis.update');
            Route::delete('/gangguan-autis/{id}', [App\Http\Controllers\AdminController::class, 'deleteGangguanAutis'])->name('gangguan.autis.delete');

            Route::get('anemia', [App\Http\Controllers\AdminController::class, 'viewAnemia'])->name('anemia.admin');
            Route::get('/anemia/{id}', [App\Http\Controllers\AdminController::class, 'editAnemia'])->name('anemia.edit');
            Route::put('/anemia/{id}', [App\Http\Controllers\AdminController::class, 'updateAnemia'])->name('anemia.update');
            Route::delete('/anemia/{id}', [App\Http\Controllers\AdminController::class, 'deleteAnemia'])->name('anemia.delete');

            Route::get('hiv', [App\Http\Controllers\AdminController::class, 'viewHiv'])->name('hiv.admin');
            Route::get('/hiv/{id}', [App\Http\Controllers\AdminController::class, 'editHiv'])->name('hiv.edit');
            Route::put('/hiv/{id}', [App\Http\Controllers\AdminController::class, 'updateHiv'])->name('hiv.update');
            Route::delete('/hiv/{id}', [App\Http\Controllers\AdminController::class, 'deleteHiv'])->name('hiv.delete');

            Route::get('hepatitis', [App\Http\Controllers\AdminController::class, 'viewHepatitis'])->name('hepatitis.admin');
            Route::get('/hepatitis/{id}', [App\Http\Controllers\AdminController::class, 'editHepatitis'])->name('hepatitis.edit');
            Route::put('/hepatitis/{id}', [App\Http\Controllers\AdminController::class, 'updateHepatitis'])->name('hepatitis.update');
            Route::delete('/hepatitis/{id}', [App\Http\Controllers\AdminController::class, 'deleteHepatitis'])->name('hepatitis.delete');

            Route::get('talasemia', [App\Http\Controllers\AdminController::class, 'viewTalasemia'])->name('talasemia.admin');
            Route::get('/talasemia/{id}', [App\Http\Controllers\AdminController::class, 'editTalasemia'])->name('talasemia.edit');
            Route::put('/talasemia/{id}', [App\Http\Controllers\AdminController::class, 'updateTalasemia'])->name('talasemia.update');
            Route::delete('/talasemia/{id}', [App\Http\Controllers\AdminController::class, 'deleteTalasemia'])->name('talasemia.delete');

            Route::get('kecacingan', [App\Http\Controllers\AdminController::class, 'viewKecacingan'])->name('kecacingan.admin');
            Route::get('/kecacingan/{id}', [App\Http\Controllers\AdminController::class, 'editKecacingan'])->name('kecacingan.edit');
            Route::put('/kecacingan/{id}', [App\Http\Controllers\AdminController::class, 'updateKecacingan'])->name('kecacingan.update');
            Route::delete('/kecacingan/{id}', [App\Http\Controllers\AdminController::class, 'deleteKecacingan'])->name('kecacingan.delete');

            Route::get('tbc', [App\Http\Controllers\AdminController::class, 'viewTbc'])->name('tbc.admin');
            Route::get('/tbc/{id}', [App\Http\Controllers\AdminController::class, 'editTbc'])->name('tbc.edit');
            Route::put('/tbc/{id}', [App\Http\Controllers\AdminController::class, 'updateTbc'])->name('tbc.update');
            Route::delete('/tbc/{id}', [App\Http\Controllers\AdminController::class, 'deleteTbc'])->name('tbc.delete');

            Route::get('triple-eliminasi-bumil', [App\Http\Controllers\AdminController::class, 'viewTripleEliminasi'])->name('triple.eliminasi.admin');
            Route::get('/triple-eliminasi-bumil/{id}', [App\Http\Controllers\AdminController::class, 'editTripleEliminasi'])->name('triple.eliminasi.edit');
            Route::put('/triple-eliminasi-bumil/{id}', [App\Http\Controllers\AdminController::class, 'updateTripleEliminasi'])->name('triple.eliminasi.update');
            Route::delete('/triple-eliminasi-bumil/{id}', [App\Http\Controllers\AdminController::class, 'deleteTripleEliminasi'])->name('triple.eliminasi.delete');

            Route::get('kekerasan-perempuan', [App\Http\Controllers\AdminController::class, 'viewKekerasanPerempuan'])->name('kekerasan.perempuan.admin');
            Route::get('/kekerasan-perempuan/{id}', [App\Http\Controllers\AdminController::class, 'editKekerasanPerempuan'])->name('kekerasan.perempuan.edit');
            Route::put('/kekerasan-perempuan/{id}', [App\Http\Controllers\AdminController::class, 'updateKekerasanPerempuan'])->name('kekerasan.perempuan.update');
            Route::delete('/kekerasan-perempuan/{id}', [App\Http\Controllers\AdminController::class, 'deleteKekerasanPerempuan'])->name('kekerasan.perempuan.delete');

            Route::get('kekerasan-anak', [App\Http\Controllers\AdminController::class, 'viewKekerasanAnak'])->name('kekerasan.anak.admin');
            Route::get('/kekerasan-anak/{id}', [App\Http\Controllers\AdminController::class, 'editKekerasanAnak'])->name('kekerasan.anak.edit');
            Route::put('/kekerasan-anak/{id}', [App\Http\Controllers\AdminController::class, 'updateKekerasanAnak'])->name('kekerasan.anak.update');
            Route::delete('/kekerasan-anak/{id}', [App\Http\Controllers\AdminController::class, 'deleteKekerasanAnak'])->name('kekerasan.anak.delete');

            Route::get('diabetes-mellitus', [App\Http\Controllers\AdminController::class, 'viewDiabetesMellitus'])->name('diabetes.mellitus.admin');
            Route::get('/diabetes-mellitus/{id}', [App\Http\Controllers\AdminController::class, 'editDiabetesMellitus'])->name('diabetes.mellitus.edit');
            Route::put('/diabetes-mellitus/{id}', [App\Http\Controllers\AdminController::class, 'updateDiabetesMellitus'])->name('diabetes.mellitus.update');
            Route::delete('/diabetes-mellitus/{id}', [App\Http\Controllers\AdminController::class, 'deleteDiabetesMellitus'])->name('diabetes.mellitus.delete');

            Route::get('/malaria/{id}', [App\Http\Controllers\AdminController::class, 'editMalaria'])->name('malaria.edit');
            Route::put('/malaria/{id}', [App\Http\Controllers\AdminController::class, 'updateMalaria'])->name('malaria.update');
            Route::delete('/malaria/{id}', [App\Http\Controllers\AdminController::class, 'deleteMalaria'])->name('malaria.delete');
        });
        Route::prefix('mtbs')->group(function () {
            Route::get('keswa-sdq', [App\Http\Controllers\AdminControllerMTBS::class, 'viewGangguanJiwaAnak'])->name('sdq.mtbs.admin');
            Route::get('/keswa-sdq/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'editGangguanJiwaAnak'])->name('sdq.mtbs.edit');
            Route::put('/keswa-sdq/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'updateGangguanJiwaAnak'])->name('sdq.mtbs.update');
            Route::delete('/keswa-sdq/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'deleteGangguanJiwaAnak'])->name('sdq.mtbs.delete');

            Route::get('keswa-sdq-remaja', [App\Http\Controllers\AdminControllerMTBS::class, 'viewGangguanJiwaRemaja'])->name('sdq.remaja.mtbs.admin');
            Route::get('/keswa-sdq-remaja/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'editGangguanJiwaRemaja'])->name('sdq.remaja.mtbs.edit');
            Route::put('/keswa-sdq-remaja/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'updateGangguanJiwaRemaja'])->name('sdq.remaja.mtbs.update');
            Route::delete('/keswa-sdq-remaja/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'deleteGangguanJiwaRemaja'])->name('sdq.remaja.mtbs.delete');

            Route::get('obesitas', [App\Http\Controllers\AdminControllerMTBS::class, 'viewObesitas'])->name('obesitas.mtbs.admin');
            Route::get('/obesitas/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'editObesitas'])->name('obesitas.mtbs.edit');
            Route::put('/obesitas/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'updateObesitas'])->name('obesitas.mtbs.update');
            Route::delete('/obesitas/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'deleteObesitas'])->name('obesitas.mtbs.delete');

            Route::get('merokok', [App\Http\Controllers\AdminControllerMTBS::class, 'viewMerokok'])->name('merokok.mtbs.admin');
            Route::get('/merokok/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'editMerokok'])->name('merokok.mtbs.edit');
            Route::put('/merokok/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'updateMerokok'])->name('merokok.mtbs.update');
            Route::delete('/merokok/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'deleteMerokok'])->name('merokok.mtbs.delete');

            Route::get('napza', [App\Http\Controllers\AdminControllerMTBS::class, 'viewNapza'])->name('napza.mtbs.admin');
            Route::get('/napza/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'editNapza'])->name('napza.mtbs.edit');
            Route::put('/napza/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'updateNapza'])->name('napza.mtbs.update');
            Route::delete('/napza/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'deleteNapza'])->name('napza.mtbs.delete');

            Route::get('test-pendengaran', [App\Http\Controllers\AdminControllerMTBS::class, 'viewTestPendengaran'])->name('testPendengaran.mtbs.admin');
            Route::get('/test-pendengaran/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'editTestPendengaran'])->name('testPendengaran.mtbs.edit');
            Route::put('/test-pendengaran/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'updateTestPendengaran'])->name('testPendengaran.mtbs.update');
            Route::delete('/test-pendengaran/{id}', [App\Http\Controllers\AdminControllerMTBS::class, 'deleteTestPendengaran'])->name('testPendengaran.mtbs.delete');

            Route::get('hipertensi', [App\Http\Controllers\AdminControllerMTBS::class, 'viewHipertensi'])->name('hipertensi.admin.mtbs');
            Route::get('/hipertensi/{id}', [App\Http\Controllers\AdminController::class, 'editHipertensi'])->name('hipertensi.mtbs.edit');
            Route::delete('/hipertensi/{id}', [App\Http\Controllers\AdminController::class, 'deleteHipertensi'])->name('hipertensi.mtbs.delete');

            Route::get('tbc', [App\Http\Controllers\AdminControllerMTBS::class, 'viewTbc'])->name('tbc.admin.mtbs');
            Route::get('/tbc/{id}', [App\Http\Controllers\AdminController::class, 'editTbc'])->name('tbc.mtbs.edit');
            Route::delete('/tbc/{id}', [App\Http\Controllers\AdminController::class, 'deleteTbc'])->name('tbc.mtbs.delete');

            Route::get('talasemia', [App\Http\Controllers\AdminControllerMTBS::class, 'viewTalasemia'])->name('talasemia.admin.mtbs');
            Route::get('/talasemia/{id}', [App\Http\Controllers\AdminController::class, 'editTalasemia'])->name('talasemia.mtbs.edit');
            Route::delete('/talasemia/{id}', [App\Http\Controllers\AdminController::class, 'deleteTalasemia'])->name('talasemia.mtbs.delete');

            Route::get('anemia', [App\Http\Controllers\AdminControllerMTBS::class, 'viewAnemia'])->name('anemia.admin.mtbs');
            Route::get('/anemia/{id}', [App\Http\Controllers\AdminController::class, 'editAnemia'])->name('anemia.mtbs.edit');
            Route::delete('/anemia/{id}', [App\Http\Controllers\AdminController::class, 'deleteAnemia'])->name('anemia.mtbs.delete');

            Route::get('kekerasan-perempuan', [App\Http\Controllers\AdminControllerMTBS::class, 'viewKekerasanPerempuan'])->name('kekerasan.perempuan.admin.mtbs');
            Route::get('/kekerasan-perempuan/{id}', [App\Http\Controllers\AdminController::class, 'editKekerasanPerempuan'])->name('kekerasan.perempuan.mtbs.edit');
            Route::delete('/kekerasan-perempuan/{id}', [App\Http\Controllers\AdminController::class, 'deleteKekerasanPerempuan'])->name('kekerasan.perempuan.mtbs.delete');

            Route::get('kekerasan-anak', [App\Http\Controllers\AdminControllerMTBS::class, 'viewKekerasanAnak'])->name('kekerasan.anak.admin.mtbs');
            Route::get('/kekerasan-anak/{id}', [App\Http\Controllers\AdminController::class, 'editKekerasanAnak'])->name('kekerasan.anak.mtbs.edit');
            Route::delete('/kekerasan-anak/{id}', [App\Http\Controllers\AdminController::class, 'deleteKekerasanAnak'])->name('kekerasan.anak.mtbs.delete');

            Route::get('diabetes-mellitus', [App\Http\Controllers\AdminControllerMTBS::class, 'viewDiabetesMellitus'])->name('diabetes.mellitus.admin.mtbs');
            Route::get('/diabetes-mellitus/{id}', [App\Http\Controllers\AdminController::class, 'editDiabetesMellitus'])->name('diabetes.mellitus.mtbs.edit');
            Route::delete('/diabetes-mellitus/{id}', [App\Http\Controllers\AdminController::class, 'deleteDiabetesMellitus'])->name('diabetes.mellitus.mtbs.delete');

            Route::get('kecacingan', [App\Http\Controllers\AdminControllerMTBS::class, 'viewKecacingan'])->name('kecacingan.admin.mtbs');
            Route::get('/kecacingan/{id}', [App\Http\Controllers\AdminController::class, 'editKecacingan'])->name('kecacingan.mtbs.edit');
            Route::delete('/kecacingan/{id}', [App\Http\Controllers\AdminController::class, 'deleteKecacingan'])->name('kecacingan.mtbs.delete');
        });
        Route::prefix('lansia')->group(function () {
            Route::get('puma', [App\Http\Controllers\AdminLansiaController::class, 'viewPuma'])->name('puma.lansia.admin');
            Route::get('/puma/{id}', [App\Http\Controllers\AdminLansiaController::class, 'editPuma'])->name('puma.lansia.edit');
            Route::put('/puma/{id}', [App\Http\Controllers\AdminLansiaController::class, 'updatePuma'])->name('puma.lansia.update');
            Route::delete('/puma/{id}', [App\Http\Controllers\AdminLansiaController::class, 'deletePuma'])->name('puma.lansia.delete');

            Route::get('geriatri', [App\Http\Controllers\AdminLansiaController::class, 'viewGeriatri'])->name('geriatri.lansia.admin');
            Route::get('/geriatri/{id}', [App\Http\Controllers\AdminLansiaController::class, 'editGeriatri'])->name('geriatri.lansia.edit');
            Route::put('/geriatri/{id}', [App\Http\Controllers\AdminLansiaController::class, 'updateGeriatri'])->name('geriatri.lansia.update');
            Route::delete('/geriatri/{id}', [App\Http\Controllers\AdminLansiaController::class, 'deleteGeriatri'])->name('geriatri.lansia.delete');

            Route::get('kanker-paru', [App\Http\Controllers\AdminLansiaController::class, 'viewKankerParu'])->name('kankerParu.lansia.admin');
            Route::get('/kanker-paru/{id}', [App\Http\Controllers\AdminLansiaController::class, 'editKankerParu'])->name('kankerParu.lansia.edit');
            Route::put('/kanker-paru/{id}', [App\Http\Controllers\AdminLansiaController::class, 'updateKankerParu'])->name('kankerParu.lansia.update');
            Route::delete('/kanker-paru/{id}', [App\Http\Controllers\AdminLansiaController::class, 'deleteKankerParu'])->name('kankerParu.lansia.delete');

            Route::get('kanker-payudara', [App\Http\Controllers\AdminLansiaController::class, 'viewKankerPayudara'])->name('kankerPayudara.lansia.admin');
            Route::get('/kanker-payudara/{id}', [App\Http\Controllers\AdminLansiaController::class, 'editKankerPayudara'])->name('kankerPayudara.lansia.edit');
            Route::put('/kanker-payudara/{id}', [App\Http\Controllers\AdminLansiaController::class, 'updateKankerPayudara'])->name('kankerPayudara.lansia.update');
            Route::delete('/kanker-payudara/{id}', [App\Http\Controllers\AdminLansiaController::class, 'deleteKankerPayudara'])->name('kankerPayudara.lansia.delete');

            Route::get('kanker-kolorektal', [App\Http\Controllers\AdminLansiaController::class, 'viewKankerKolorektal'])->name('kankerKolorektal.lansia.admin');
            Route::get('/kanker-kolorektal/{id}', [App\Http\Controllers\AdminLansiaController::class, 'editKankerKolorektal'])->name('kankerKolorektal.lansia.edit');
            Route::put('/kanker-kolorektal/{id}', [App\Http\Controllers\AdminLansiaController::class, 'updateKankerKolorektal'])->name('kankerKolorektal.lansia.update');
            Route::delete('/kanker-kolorektal/{id}', [App\Http\Controllers\AdminLansiaController::class, 'deleteKankerKolorektal'])->name('kankerKolorektal.lansia.delete');

            Route::get('layak-hamil', [App\Http\Controllers\AdminController::class, 'viewLayakHamil'])->name('layakHamil.admin.lansia');
            Route::get('/layak-hamil/{id}', [App\Http\Controllers\AdminController::class, 'editLayakHamil'])->name('layakHamil.lansia.edit');
            Route::delete('/layak-hamil/{id}', [App\Http\Controllers\AdminController::class, 'deleteLayakHamil'])->name('layak_hamil.lansia.delete');

            Route::get('hipertensi', [App\Http\Controllers\AdminLansiaController::class, 'viewHipertensi'])->name('hipertensi.admin.lansia');
            Route::get('/hipertensi/{id}', [App\Http\Controllers\AdminController::class, 'editHipertensi'])->name('hipertensi.lansia.edit');
            Route::delete('/hipertensi/{id}', [App\Http\Controllers\AdminController::class, 'deleteHipertensi'])->name('hipertensi.lansia.delete');

            Route::get('tbc', [App\Http\Controllers\AdminLansiaController::class, 'viewTbc'])->name('tbc.admin.lansia');
            Route::get('/tbc/{id}', [App\Http\Controllers\AdminController::class, 'editTbc'])->name('tbc.lansia.edit');
            Route::delete('/tbc/{id}', [App\Http\Controllers\AdminController::class, 'deleteTbc'])->name('tbc.lansia.delete');

            Route::get('talasemia', [App\Http\Controllers\AdminLansiaController::class, 'viewTalasemia'])->name('talasemia.admin.lansia');
            Route::get('/talasemia/{id}', [App\Http\Controllers\AdminController::class, 'editTalasemia'])->name('talasemia.lansia.edit');
            Route::delete('/talasemia/{id}', [App\Http\Controllers\AdminController::class, 'deleteTalasemia'])->name('talasemia.lansia.delete');

            Route::get('anemia', [App\Http\Controllers\AdminLansiaController::class, 'viewAnemia'])->name('anemia.admin.lansia');
            Route::get('/anemia/{id}', [App\Http\Controllers\AdminController::class, 'editAnemia'])->name('anemia.lansia.edit');
            Route::delete('/anemia/{id}', [App\Http\Controllers\AdminController::class, 'deleteAnemia'])->name('anemia.lansia.delete');
        });
    });
});

Route::get('provinces', [DependentDropdownController::class, 'provinces'])->name('provinces');
Route::get('cities/{provinceId}', [DependentDropdownController::class, 'citiesData'])->name('cities');
Route::get('districts/{cityId}', [DependentDropdownController::class, 'districtsData'])->name('districts');
Route::get('villages/{districtId}', [DependentDropdownController::class, 'villagesData'])->name('villages');
Route::get('/get-patients', [PatientsController::class, 'getPatients'])->name('get-patients');
Route::get('/get-skrining/{id}', [SkriningController::class, 'getSkriningPatient'])->name('get-skrining-patient');
Route::get('/get-patients-kunjungan/{patient}', [PatientsController::class, 'getPatientsKunjunganByPatient'])->name('get.patients.kunjungan');

Route::get('/get-patients/poli-umum', [PatientsController::class, 'getPatientsPoliUmum'])->name('get-patients-poli-umum');
Route::get('/get-patients/poli-gigi', [PatientsController::class, 'getPatientsPoliGigi'])->name('get-patients-poli-gigi');
Route::get('/get-patients/poli-kia', [PatientsController::class, 'getPatientsPoliKia'])->name('get-patients-poli-kia');
Route::get('/get-patients/poli-kb', [PatientsController::class, 'getPatientsPoliKb'])->name('get-patients-poli-kb');
Route::get('/get-patients/ruang-tindakan', [PatientsController::class, 'getPatientsRuangTindakan'])->name('get-patients-ruang-tindakan');

Route::get('/get-patients-dokter/poli-umum', [PatientsController::class, 'getPatientsDokter'])->name('get-patients-dokter');
Route::get('/get-patients-dokter/poli-gigi', [PatientsController::class, 'getPatientsDokterGigi'])->name('get-patients-dokter-gigi');
Route::get('/get-patients-dokter/poli-kia', [PatientsController::class, 'getPatientsDokterKia'])->name('get-patients-dokter-kia');
Route::get('/get-patients-dokter/poli-kb', [PatientsController::class, 'getPatientsDokterKb'])->name('get-patients-dokter-kb');
Route::get('/get-patients-dokter/ruang-tindakan', [PatientsController::class, 'getPatientsDokterRuangTindakan'])->name('get-patients-dokter-ruang-tindakan');
Route::get('/get-patients-dokter/tindakan', [PatientsController::class, 'getPatientsTindakan'])->name('get-patients-tindakan');

Route::get('/get-patients-lab/poli-umum', [PatientsController::class, 'getPatientsLab'])->name('get-patients-lab');
Route::get('/get-patients-lab/poli-gigi', [PatientsController::class, 'getPatientsLabGigi'])->name('get-patients-lab-gigi');
Route::get('/get-patients-lab/ruang-tindakan', [PatientsController::class, 'getPatientsLabRuangTindakan'])->name('get-patients-lab-ruang-tindakan');
Route::get('/get-patients-lab/poli-kia', [PatientsController::class, 'getPatientsLabKia'])->name('get-patients-lab-kia');
Route::get('/get-patients-lab/poli-kb', [PatientsController::class, 'getPatientsLabKb'])->name('get-patients-lab-kb');

Route::get('/get-patients-apotik', [PatientsController::class, 'getPatientsApotik'])->name('get-patients-apotik');
Route::get('/get-patients-apotik/poli-gigi', [PatientsController::class, 'getPatientsApotikGigi'])->name('get-patients-apotik-gigi');
Route::get('/get-patients-apotik/ruang-tindakan', [PatientsController::class, 'getPatientsApotikRuangTindakan'])->name('get-patients-apotik-ruang-tindakan');
Route::get('/get-patients-apotik/poli-kia', [PatientsController::class, 'getPatientsApotikKia'])->name('get-patients-apotik-kia');
Route::get('/get-patients-apotik/poli-kb', [PatientsController::class, 'getPatientsApotikKb'])->name('get-patients-apotik-kb');

Route::prefix('dashboard')->group(function () {
    Route::get('/pasien', [DashboardController::class, 'indexPatient'])->name('dashboard.patient');
    Route::get('/kunjungan', [DashboardController::class, 'indexKunjungan'])->name('dashboard.kunjungan');
});
Route::prefix('obat')->group(function () {
    //master obat
    Route::get('master-data', [ObatController::class, 'indexMasterData'])->name('obat-master-data');
    Route::post('master-data', [ObatController::class, 'storeMasterData'])->name('store-obat-master-data');
    Route::put('master-data/{id}', [ObatController::class, 'updateMasterData'])->name('update-obat-master-data');
    Route::get('table-master-data', [ObatController::class, 'getObatMasterData'])->name('table-obat-master-data');

    //terima obat
    Route::get('terima-obat', [ObatController::class, 'indexTerimaObat'])->name('terima-obat');
    Route::post('terima-obat', [ObatController::class, 'storeTerimaObat'])->name('store-terima-obat');
    Route::put('terima-obat/{id}', [ObatController::class, 'updateTerimaObat'])->name('update-terima-obat');
    Route::get('table-terima-obat', [ObatController::class, 'getTerimaObat'])->name('table-terima-obat');

    //pengeluaran obat
    Route::get('pengeluaran-obat', [ObatController::class, 'indexPengeluaranObat'])->name('pengeluaran-obat');
    Route::post('pengeluaran-obat', [ObatController::class, 'storePengeluaranObat'])->name('store-pengeluaran-obat');
    Route::put('pengeluaran-obat/{id}', [ObatController::class, 'updatePengeluaranObat'])->name('update-pengeluaran-obat');
    Route::get('get-stock/{id}', [ObatController::class, 'getStock']);
    Route::get('table-pengeluaran-obat', [ObatController::class, 'getPengeluaranObat'])->name('table-pengeluaran-obat');

    //stok obat
    Route::get('stok-obat', [ObatController::class, 'indexStokObat'])->name('stok-obat');
    Route::get('table-stok-obat', [ObatController::class, 'getStokObat'])->name('table-stok-obat');

    //generate resep obat
    Route::get('/pdf-resep/{id}', [ObatController::class, 'generatePrescription'])->name('print-prescription');

});
// delete patient action & kunjungan
Route::post('patient/action', [ActionController::class, 'destroyPatientAction'])->name('patient.action.destroy');
Route::post('sendToSatuSehat', [ActionController::class, 'sendToSatuSehat'])->name('sendToSatuSehat');

Route::get('/loadModal/editKajianAwal/{action}', [LoadModalController::class, 'editKajianAwal'])->name('loadModal.editKajianAwal');

//diagnosa
Route::get('/get-diagnosa', [DiagnosaController::class, 'getDiagnosa']);
//Language Change
Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'de', 'es', 'fr', 'pt', 'cn', 'ae'])) {
        abort(400);
    }
    Session()->put('locale', $locale);
    Session::get('locale');
    return redirect()->back();
})->name('lang');


// Route::prefix('starter-kit')->group(function () {
// });

Route::prefix('others')->group(function () {
    Route::view('400', 'errors.400')->name('error-400');
    Route::view('401', 'errors.401')->name('error-401');
    Route::view('403', 'errors.403')->name('error-403');
    Route::view('404', 'errors.404')->name('error-404');
    Route::view('500', 'errors.500')->name('error-500');
    Route::view('503', 'errors.503')->name('error-503');
});

Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return 'Cache is cleared';
})->name('clear.cache');
