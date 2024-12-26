<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DependentDropdownController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IMTController;
use App\Http\Controllers\KadarLemakController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

    Route::get('hipertensi', [App\Http\Controllers\KiaController::class, 'showHipertensi'])->name('hipertensi.view');
    Route::post('hipertensi', [App\Http\Controllers\KiaController::class, 'storeHipertensi'])->name('hipertensi.store');

    Route::get('gangguan-autis', [App\Http\Controllers\KiaController::class, 'showGangguanAutis'])->name('gangguan.autis.view');
    Route::post('gangguan-autis', [App\Http\Controllers\KiaController::class, 'storeGangguanAutis'])->name('gangguan.autis.store');

    Route::get('anemia', [App\Http\Controllers\KiaController::class, 'showAnemia'])->name('anemia.view');
    Route::post('anemia', [App\Http\Controllers\KiaController::class, 'storeAnemia'])->name('anemia.store');

    Route::get('kecacingan', [App\Http\Controllers\KiaController::class, 'showKecacingan'])->name('kecacingan.view');
    Route::post('kecacingan', [App\Http\Controllers\KiaController::class, 'storeKecacingan'])->name('kecacingan.store');

    Route::get('hiv', [App\Http\Controllers\KiaController::class, 'showHiv'])->name('hiv.view');
    Route::post('hiv', [App\Http\Controllers\KiaController::class, 'storeHiv'])->name('hiv.store');

    Route::get('talasemia', [App\Http\Controllers\KiaController::class, 'showTalasemia'])->name('talasemia.view');
    Route::post('talasemia', [App\Http\Controllers\KiaController::class, 'storeTalasemia'])->name('talasemia.store');

    Route::get('hepatitis', [App\Http\Controllers\KiaController::class, 'showHepatitis'])->name('hepatitis.view');
    Route::post('hepatitis', [App\Http\Controllers\KiaController::class, 'storeHepatitis'])->name('hepatitis.store');

    Route::get('kekerasan-anak', [App\Http\Controllers\KiaController::class, 'showKekerasanAnak'])->name('kekerasan.anak.view');
    Route::post('kekerasan-anak', [App\Http\Controllers\KiaController::class, 'storeKekerasanAnak'])->name('kekerasan.anak.store');

    Route::get('kekerasan-perempuan', [App\Http\Controllers\KiaController::class, 'showKekerasanPerempuan'])->name('kekerasan.perempuan.view');
    Route::post('kekerasan-perempuan', [App\Http\Controllers\KiaController::class, 'storeKekerasanPerempuan'])->name('kekerasan.perempuan.store');

    Route::get('diabetes-mellitus', [App\Http\Controllers\KiaController::class, 'showDiabetesMellitus'])->name('diabetes.mellitus.view');
    Route::post('diabetes-mellitus', [App\Http\Controllers\KiaController::class, 'storeDiabetesMellitus'])->name('diabetes.mellitus.store');

    Route::get('tbc', [App\Http\Controllers\KiaController::class, 'showTbc'])->name('tbc.view');
    Route::post('tbc', [App\Http\Controllers\KiaController::class, 'storeTbc'])->name('tbc.store');

    Route::get('triple-eliminasi-bumil', [App\Http\Controllers\KiaController::class, 'showTripleEliminasi'])->name('triple.eliminasi.view');
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
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    Route::get('/patients', [PatientsController::class, 'index'])->name('patient.index');
    Route::post('/patients', [PatientsController::class, 'store'])->name('patient.store');
    Route::put('/patients/{id}', [PatientsController::class, 'update'])->name('patient.update');
    Route::delete('/patients/{id}', [PatientsController::class, 'destroy'])->name('patient.destroy');
    Route::get('/report/patients', [PatientsController::class, 'patientReport'])->name('patient.report');

    Route::get('/action', [ActionController::class, 'index'])->name('action.index');
    Route::post('/action', [ActionController::class, 'store'])->name('action.store');
    Route::POST('/action/{id}', [ActionController::class, 'update'])->name('action.update');
    Route::delete('/action/{id}', [ActionController::class, 'destroy'])->name('action.destroy');
    Route::get('/report/action', [ActionController::class, 'actionReport'])->name('action.report');

    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/tifoid', [ReportController::class, 'printTifoid'])->name('report.tifoid');
    Route::get('/report/diare', [ReportController::class, 'printDiare'])->name('report.diare');
    Route::get('/report-poli-umum/diare', [ReportController::class, 'reportDiare'])->name('report.poli.diare');
    Route::get('/report/stp', [ReportController::class, 'reportSTP'])->name('report.stp');
    Route::get('/report/ptm', [ReportController::class, 'reportPTM'])->name('report.ptm');
    Route::get('/report/afp', [ReportController::class, 'reportAFP'])->name('report.afp');
    Route::get('/report/difteri', [ReportController::class, 'reportDifteri'])->name('report.difteri');
    Route::get('/report/C1', [ReportController::class, 'reportC1'])->name('report.C1');
    Route::get('/report/rjp', [ReportController::class, 'reportRJP'])->name('report.rjp');
    Route::get('/report/skdr', [ReportController::class, 'reportSKDR'])->name('report.skdr');
    Route::get('/report/lkg', [ReportController::class, 'reportLKG'])->name('report.lkg');
    Route::get('/report/lrkg', [ReportController::class, 'reportLRKG'])->name('report.lrkg');
    Route::get('/report/lkt', [ReportController::class, 'reportLKT'])->name('report.lkt');
    Route::get('/report/lbkt', [ReportController::class, 'reportLBKT'])->name('report.lbkt');
    Route::get('/report/urt', [ReportController::class, 'reportURT'])->name('report.urt');
    Route::get('/report/lkrj', [ReportController::class, 'reportLKRJ'])->name('report.lkrj');
    Route::get('/report/rrt', [ReportController::class, 'reportRRT'])->name('report.rrt');
    Route::get('/report/ll', [ReportController::class, 'reportLL'])->name('report.ll');
    Route::get('/report/formulir10', [ReportController::class, 'reportFormulir10'])->name('report.formulir10');
    Route::get('/report/formulir11', [ReportController::class, 'reportFormulir11'])->name('report.formulir11');
    Route::get('/report/formulir12', [ReportController::class, 'reportFormulir12'])->name('report.formulir12');
    Route::get('/report/lr', [ReportController::class, 'reportLR'])->name('report.lr');
    Route::get('/report/up', [ReportController::class, 'reportUP'])->name('report.up');
    
    Route::put('/profile/{id}', [AuthController::class, 'update'])->name('profile.update');
    Route::put('/change-password/{id}', [AuthController::class, 'changePassword'])->name('change.password');
     Route::prefix('admin')->group(function () {
        Route::prefix('kia')->group(function () {
            Route::get('layak-hamil', [App\Http\Controllers\AdminController::class, 'viewLayakHamil'])->name('layakHamil.admin');
            Route::get('/layak-hamil/{id}', [App\Http\Controllers\AdminController::class, 'editLayakHamil'])->name('layak_hamil.edit');
            Route::put('/layak-hamil/{id}', [App\Http\Controllers\AdminController::class, 'updateLayakHamil'])->name('layak_hamil.update');
            Route::delete('/layak-hamil/{id}', [App\Http\Controllers\AdminController::class, 'deleteLayakHamil'])->name('layak_hamil.delete');

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

            Route::get('triple', [App\Http\Controllers\AdminController::class, 'viewTripleEliminasi'])->name('triple.eliminasi.admin');
            Route::get('/triple/{id}', [App\Http\Controllers\AdminController::class, 'editTripleEliminasi'])->name('triple.eliminasi.edit');
            Route::put('/triple/{id}', [App\Http\Controllers\AdminController::class, 'updateTripleEliminasi'])->name('triple.eliminasi.update');
            Route::delete('/triple/{id}', [App\Http\Controllers\AdminController::class, 'deleteTripleEliminasi'])->name('triple.eliminasi.delete');

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

            Route::get('hipertensi', [App\Http\Controllers\AdminController::class, 'viewHipertensi'])->name('hipertensi.admin.mtbs');
            // Route::get('/hipertensi/{id}', [App\Http\Controllers\AdminController::class, 'editHipertensi'])->name('hipertensi.edit');
            // Route::put('/hipertensi/{id}', [App\Http\Controllers\AdminController::class, 'updateHipertensi'])->name('hipertensi.update');
            // Route::delete('/hipertensi/{id}', [App\Http\Controllers\AdminController::class, 'deleteHipertensi'])->name('hipertensi.delete');

            Route::get('tbc', [App\Http\Controllers\AdminController::class, 'viewTbc'])->name('tbc.admin.mtbs');
            // Route::get('/tbc/{id}', [App\Http\Controllers\AdminController::class, 'editTbc'])->name('tbc.edit');
            // Route::put('/tbc/{id}', [App\Http\Controllers\AdminController::class, 'updateTbc'])->name('tbc.update');
            // Route::delete('/tbc/{id}', [App\Http\Controllers\AdminController::class, 'deleteTbc'])->name('tbc.delete');

            Route::get('talasemia', [App\Http\Controllers\AdminController::class, 'viewTalasemia'])->name('talasemia.admin.mtbs');
            // Route::get('/talasemia/{id}', [App\Http\Controllers\AdminController::class, 'editTalasemia'])->name('talasemia.edit');
            // Route::put('/talasemia/{id}', [App\Http\Controllers\AdminController::class, 'updateTalasemia'])->name('talasemia.update');
            // Route::delete('/talasemia/{id}', [App\Http\Controllers\AdminController::class, 'deleteTalasemia'])->name('talasemia.delete');

            
            Route::get('anemia', [App\Http\Controllers\AdminController::class, 'viewAnemia'])->name('anemia.admin.mtbs');
            // Route::get('/anemia/{id}', [App\Http\Controllers\AdminController::class, 'editAnemia'])->name('anemia.edit');
            // Route::put('/anemia/{id}', [App\Http\Controllers\AdminController::class, 'updateAnemia'])->name('anemia.update');
            // Route::delete('/anemia/{id}', [App\Http\Controllers\AdminController::class, 'deleteAnemia'])->name('anemia.delete');

            Route::get('kekerasan-perempuan', [App\Http\Controllers\AdminController::class, 'viewKekerasanPerempuan'])->name('kekerasan.perempuan.admin.mtbs');
            // Route::get('/kekerasan-perempuan/{id}', [App\Http\Controllers\AdminController::class, 'editKekerasanPerempuan'])->name('kekerasan.perempuan.edit');
            // Route::put('/kekerasan-perempuan/{id}', [App\Http\Controllers\AdminController::class, 'updateKekerasanPerempuan'])->name('kekerasan.perempuan.update');
            // Route::delete('/kekerasan-perempuan/{id}', [App\Http\Controllers\AdminController::class, 'deleteKekerasanPerempuan'])->name('kekerasan.perempuan.delete');

            Route::get('kekerasan-anak', [App\Http\Controllers\AdminController::class, 'viewKekerasanAnak'])->name('kekerasan.anak.admin.mtbs');
            // Route::get('/kekerasan-anak/{id}', [App\Http\Controllers\AdminController::class, 'editKekerasanAnak'])->name('kekerasan.anak.edit');
            // Route::put('/kekerasan-anak/{id}', [App\Http\Controllers\AdminController::class, 'updateKekerasanAnak'])->name('kekerasan.anak.update');
            // Route::delete('/kekerasan-anak/{id}', [App\Http\Controllers\AdminController::class, 'deleteKekerasanAnak'])->name('kekerasan.anak.delete');

            Route::get('diabetes-mellitus', [App\Http\Controllers\AdminController::class, 'viewDiabetesMellitus'])->name('diabetes.mellitus.admin.mtbs');
            // Route::get('/diabetes-mellitus/{id}', [App\Http\Controllers\AdminController::class, 'editDiabetesMellitus'])->name('diabetes.mellitus.edit');
            // Route::put('/diabetes-mellitus/{id}', [App\Http\Controllers\AdminController::class, 'updateDiabetesMellitus'])->name('diabetes.mellitus.update');
            // Route::delete('/diabetes-mellitus/{id}', [App\Http\Controllers\AdminController::class, 'deleteDiabetesMellitus'])->name('diabetes.mellitus.delete');
            
            Route::get('kecacingan', [App\Http\Controllers\AdminController::class, 'viewKecacingan'])->name('kecacingan.admin.mtbs');
            // Route::get('/kecacingan/{id}', [App\Http\Controllers\AdminController::class, 'editKecacingan'])->name('kecacingan.edit');
            // Route::put('/kecacingan/{id}', [App\Http\Controllers\AdminController::class, 'updateKecacingan'])->name('kecacingan.update');
            // Route::delete('/kecacingan/{id}', [App\Http\Controllers\AdminController::class, 'deleteKecacingan'])->name('kecacingan.delete');

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
            // Route::get('/layak-hamil/{id}', [App\Http\Controllers\AdminController::class, 'editLayakHamil'])->name('layak_hamil.edit');
            // Route::put('/layak-hamil/{id}', [App\Http\Controllers\AdminController::class, 'updateLayakHamil'])->name('layak_hamil.update');
            // Route::delete('/layak-hamil/{id}', [App\Http\Controllers\AdminController::class, 'deleteLayakHamil'])->name('layak_hamil.delete');

            Route::get('hipertensi', [App\Http\Controllers\AdminController::class, 'viewHipertensi'])->name('hipertensi.admin.lansia');
            // Route::get('/hipertensi/{id}', [App\Http\Controllers\AdminController::class, 'editHipertensi'])->name('hipertensi.edit');
            // Route::put('/hipertensi/{id}', [App\Http\Controllers\AdminController::class, 'updateHipertensi'])->name('hipertensi.update');
            // Route::delete('/hipertensi/{id}', [App\Http\Controllers\AdminController::class, 'deleteHipertensi'])->name('hipertensi.delete');

            Route::get('tbc', [App\Http\Controllers\AdminController::class, 'viewTbc'])->name('tbc.admin.lansia');
            // Route::get('/tbc/{id}', [App\Http\Controllers\AdminController::class, 'editTbc'])->name('tbc.edit');
            // Route::put('/tbc/{id}', [App\Http\Controllers\AdminController::class, 'updateTbc'])->name('tbc.update');
            // Route::delete('/tbc/{id}', [App\Http\Controllers\AdminController::class, 'deleteTbc'])->name('tbc.delete');

            Route::get('talasemia', [App\Http\Controllers\AdminController::class, 'viewTalasemia'])->name('talasemia.admin.lansia');
            // Route::get('/talasemia/{id}', [App\Http\Controllers\AdminController::class, 'editTalasemia'])->name('talasemia.edit');
            // Route::put('/talasemia/{id}', [App\Http\Controllers\AdminController::class, 'updateTalasemia'])->name('talasemia.update');
            // Route::delete('/talasemia/{id}', [App\Http\Controllers\AdminController::class, 'deleteTalasemia'])->name('talasemia.delete');

            
            Route::get('anemia', [App\Http\Controllers\AdminController::class, 'viewAnemia'])->name('anemia.admin.lansia');
            // Route::get('/anemia/{id}', [App\Http\Controllers\AdminController::class, 'editAnemia'])->name('anemia.edit');
            // Route::put('/anemia/{id}', [App\Http\Controllers\AdminController::class, 'updateAnemia'])->name('anemia.update');
            // Route::delete('/anemia/{id}', [App\Http\Controllers\AdminController::class, 'deleteAnemia'])->name('anemia.delete');
        });
    });
});

Route::get('provinces', [DependentDropdownController::class, 'provinces'])->name('provinces');
Route::get('cities/{provinceId}', [DependentDropdownController::class, 'citiesData'])->name('cities');
Route::get('districts/{cityId}', [DependentDropdownController::class, 'districtsData'])->name('districts');
Route::get('villages/{districtId}', [DependentDropdownController::class, 'villagesData'])->name('villages');
Route::get('/get-patients', [PatientsController::class, 'getPatients'])->name('get-patients');

//Language Change
Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'de', 'es', 'fr', 'pt', 'cn', 'ae'])) {
        abort(400);
    }
    Session()->put('locale', $locale);
    Session::get('locale');
    return redirect()->back();
})->name('lang');

Route::prefix('dashboard')->group(function () {
    Route::view('index', 'dashboard.index')->name('index');
    Route::view('dashboard-02', 'dashboard.dashboard-02')->name('dashboard-02');
    Route::view('dashboard-03', 'dashboard.dashboard-03')->name('dashboard-03');
    Route::view('dashboard-04', 'dashboard.dashboard-04')->name('dashboard-04');
    Route::view('dashboard-05', 'dashboard.dashboard-05')->name('dashboard-05');
});
Route::prefix('widgets')->group(function () {
    Route::view('chart-widget', 'widgets.chart-widget')->name('chart-widget');
});

Route::prefix('page-layouts')->group(function () {
    Route::view('box-layout', 'page-layout.box-layout')->name('box-layout');
    Route::view('layout-rtl', 'page-layout.layout-rtl')->name('layout-rtl');
    Route::view('layout-dark', 'page-layout.layout-dark')->name('layout-dark');
    Route::view('hide-on-scroll', 'page-layout.hide-on-scroll')->name('hide-on-scroll');
    Route::view('footer-light', 'page-layout.footer-light')->name('footer-light');
    Route::view('footer-dark', 'page-layout.footer-dark')->name('footer-dark');
    Route::view('footer-fixed', 'page-layout.footer-fixed')->name('footer-fixed');
});

Route::prefix('project')->group(function () {
    Route::view('projects', 'project.projects')->name('projects');
    Route::view('projectcreate', 'project.projectcreate')->name('projectcreate');
});

Route::view('file-manager', 'file-manager')->name('file-manager');
Route::view('kanban', 'kanban')->name('kanban');

Route::prefix('ecommerce')->group(function () {
    Route::view('product', 'apps.product')->name('product');
    Route::view('page-product', 'apps.product-page')->name('product-page');
    Route::view('list-products', 'apps.list-products')->name('list-products');
    Route::view('payment-details', 'apps.payment-details')->name('payment-details');
    Route::view('order-history', 'apps.order-history')->name('order-history');
    Route::view('invoice-template', 'apps.invoice-template')->name('invoice-template');
    Route::view('cart', 'apps.cart')->name('cart');
    Route::view('list-wish', 'apps.list-wish')->name('list-wish');
    Route::view('checkout', 'apps.checkout')->name('checkout');
    Route::view('pricing', 'apps.pricing')->name('pricing');
});

Route::prefix('email')->group(function () {
    Route::view('email-application', 'apps.email-application')->name('email-application');
    Route::view('email-compose', 'apps.email-compose')->name('email-compose');
});

Route::prefix('chat')->group(function () {
    Route::view('chat', 'apps.chat')->name('chat');
    Route::view('video-chat', 'apps.video-chat')->name('chat-video');
});

Route::prefix('users')->group(function () {
    Route::view('user-profile', 'apps.user-profile')->name('user-profile');
    Route::view('edit-profile', 'apps.edit-profile')->name('edit-profile');
    Route::view('user-cards', 'apps.user-cards')->name('user-cards');
});

Route::view('bookmark', 'apps.bookmark')->name('bookmark');
Route::view('contacts', 'apps.contacts')->name('contacts');
Route::view('task', 'apps.task')->name('task');
Route::view('calendar-basic', 'apps.calendar-basic')->name('calendar-basic');
Route::view('social-app', 'apps.social-app')->name('social-app');
Route::view('to-do', 'apps.to-do')->name('to-do');
Route::view('search', 'apps.search')->name('search');

Route::prefix('ui-kits')->group(function () {
    Route::view('state-color', 'ui-kits.state-color')->name('state-color');
    Route::view('typography', 'ui-kits.typography')->name('typography');
    Route::view('avatars', 'ui-kits.avatars')->name('avatars');
    Route::view('helper-classes', 'ui-kits.helper-classes')->name('helper-classes');
    Route::view('grid', 'ui-kits.grid')->name('grid');
    Route::view('tag-pills', 'ui-kits.tag-pills')->name('tag-pills');
    Route::view('progress-bar', 'ui-kits.progress-bar')->name('progress-bar');
    Route::view('modal', 'ui-kits.modal')->name('modal');
    Route::view('alert', 'ui-kits.alert')->name('alert');
    Route::view('popover', 'ui-kits.popover')->name('popover');
    Route::view('tooltip', 'ui-kits.tooltip')->name('tooltip');
    Route::view('loader', 'ui-kits.loader')->name('loader');
    Route::view('dropdown', 'ui-kits.dropdown')->name('dropdown');
    Route::view('accordion', 'ui-kits.accordion')->name('accordion');
    Route::view('tab-bootstrap', 'ui-kits.tab-bootstrap')->name('tab-bootstrap');
    Route::view('tab-material', 'ui-kits.tab-material')->name('tab-material');
    Route::view('box-shadow', 'ui-kits.box-shadow')->name('box-shadow');
    Route::view('list', 'ui-kits.list')->name('list');
});

Route::prefix('bonus-ui')->group(function () {
    Route::view('scrollable', 'bonus-ui.scrollable')->name('scrollable');
    Route::view('tree', 'bonus-ui.tree')->name('tree');
    Route::view('bootstrap-notify', 'bonus-ui.bootstrap-notify')->name('bootstrap-notify');
    Route::view('rating', 'bonus-ui.rating')->name('rating');
    Route::view('dropzone', 'bonus-ui.dropzone')->name('dropzone');
    Route::view('tour', 'bonus-ui.tour')->name('tour');
    Route::view('sweet-alert2', 'bonus-ui.sweet-alert2')->name('sweet-alert2');
    Route::view('modal-animated', 'bonus-ui.modal-animated')->name('modal-animated');
    Route::view('owl-carousel', 'bonus-ui.owl-carousel')->name('owl-carousel');
    Route::view('ribbons', 'bonus-ui.ribbons')->name('ribbons');
    Route::view('pagination', 'bonus-ui.pagination')->name('pagination');
    Route::view('breadcrumb', 'bonus-ui.breadcrumb')->name('breadcrumb');
    Route::view('range-slider', 'bonus-ui.range-slider')->name('range-slider');
    Route::view('image-cropper', 'bonus-ui.image-cropper')->name('image-cropper');
    Route::view('sticky', 'bonus-ui.sticky')->name('sticky');
    Route::view('basic-card', 'bonus-ui.basic-card')->name('basic-card');
    Route::view('creative-card', 'bonus-ui.creative-card')->name('creative-card');
    Route::view('tabbed-card', 'bonus-ui.tabbed-card')->name('tabbed-card');
    Route::view('dragable-card', 'bonus-ui.dragable-card')->name('dragable-card');
    Route::view('timeline-v-1', 'bonus-ui.timeline-v-1')->name('timeline-v-1');
    Route::view('timeline-v-2', 'bonus-ui.timeline-v-2')->name('timeline-v-2');
    Route::view('timeline-small', 'bonus-ui.timeline-small')->name('timeline-small');
});

Route::prefix('builders')->group(function () {
    Route::view('form-builder-1', 'builders.form-builder-1')->name('form-builder-1');
    Route::view('form-builder-2', 'builders.form-builder-2')->name('form-builder-2');
    Route::view('pagebuild', 'builders.pagebuild')->name('pagebuild');
    Route::view('button-builder', 'builders.button-builder')->name('button-builder');
});

Route::prefix('animation')->group(function () {
    Route::view('animate', 'animation.animate')->name('animate');
    Route::view('scroll-reval', 'animation.scroll-reval')->name('scroll-reval');
    Route::view('aos', 'animation.aos')->name('aos');
    Route::view('tilt', 'animation.tilt')->name('tilt');
    Route::view('wow', 'animation.wow')->name('wow');
});

Route::prefix('icons')->group(function () {
    Route::view('flag-icon', 'icons.flag-icon')->name('flag-icon');
    Route::view('font-awesome', 'icons.font-awesome')->name('font-awesome');
    Route::view('ico-icon', 'icons.ico-icon')->name('ico-icon');
    Route::view('themify-icon', 'icons.themify-icon')->name('themify-icon');
    Route::view('feather-icon', 'icons.feather-icon')->name('feather-icon');
    Route::view('whether-icon', 'icons.whether-icon')->name('whether-icon');
    Route::view('simple-line-icon', 'icons.simple-line-icon')->name('simple-line-icon');
    Route::view('material-design-icon', 'icons.material-design-icon')->name('material-design-icon');
    Route::view('pe7-icon', 'icons.pe7-icon')->name('pe7-icon');
    Route::view('typicons-icon', 'icons.typicons-icon')->name('typicons-icon');
    Route::view('ionic-icon', 'icons.ionic-icon')->name('ionic-icon');
});

Route::prefix('buttons')->group(function () {
    Route::view('buttons', 'buttons.buttons')->name('buttons');
    Route::view('flat-buttons', 'buttons.flat-buttons')->name('flat-buttons');
    Route::view('edge-buttons', 'buttons.buttons-edge')->name('buttons-edge');
    Route::view('raised-button', 'buttons.raised-button')->name('raised-button');
    Route::view('button-group', 'buttons.button-group')->name('button-group');
});

Route::prefix('forms')->group(function () {
    Route::view('form-validation', 'forms.form-validation')->name('form-validation');
    Route::view('base-input', 'forms.base-input')->name('base-input');
    Route::view('radio-checkbox-control', 'forms.radio-checkbox-control')->name('radio-checkbox-control');
    Route::view('input-group', 'forms.input-group')->name('input-group');
    Route::view('megaoptions', 'forms.megaoptions')->name('megaoptions');
    Route::view('datepicker', 'forms.datepicker')->name('datepicker');
    Route::view('time-picker', 'forms.time-picker')->name('time-picker');
    Route::view('datetimepicker', 'forms.datetimepicker')->name('datetimepicker');
    Route::view('daterangepicker', 'forms.daterangepicker')->name('daterangepicker');
    Route::view('touchspin', 'forms.touchspin')->name('touchspin');
    Route::view('select2', 'forms.select2')->name('select2');
    Route::view('switch', 'forms.switch')->name('switch');
    Route::view('typeahead', 'forms.typeahead')->name('typeahead');
    Route::view('clipboard', 'forms.clipboard')->name('clipboard');
    Route::view('default-form', 'forms.default-form')->name('default-form');
    Route::view('form-wizard', 'forms.form-wizard')->name('form-wizard');
    Route::view('form-two-wizard', 'forms.form-wizard-two')->name('form-wizard-two');
    Route::view('wizard-form-three', 'forms.form-wizard-three')->name('form-wizard-three');
    Route::post('form-wizard-three', function () {
        return redirect()->route('form-wizard-three');
    })->name('form-wizard-three-post');
});

Route::prefix('tables')->group(function () {
    Route::view('bootstrap-basic-table', 'tables.bootstrap-basic-table')->name('bootstrap-basic-table');
    Route::view('bootstrap-sizing-table', 'tables.bootstrap-sizing-table')->name('bootstrap-sizing-table');
    Route::view('bootstrap-border-table', 'tables.bootstrap-border-table')->name('bootstrap-border-table');
    Route::view('bootstrap-styling-table', 'tables.bootstrap-styling-table')->name('bootstrap-styling-table');
    Route::view('table-components', 'tables.table-components')->name('table-components');
    Route::view('datatable-basic-init', 'tables.datatable-basic-init')->name('datatable-basic-init');
    Route::view('datatable-advance', 'tables.datatable-advance')->name('datatable-advance');
    Route::view('datatable-styling', 'tables.datatable-styling')->name('datatable-styling');
    Route::view('datatable-ajax', 'tables.datatable-ajax')->name('datatable-ajax');
    Route::view('datatable-server-side', 'tables.datatable-server-side')->name('datatable-server-side');
    Route::view('datatable-plugin', 'tables.datatable-plugin')->name('datatable-plugin');
    Route::view('datatable-api', 'tables.datatable-api')->name('datatable-api');
    Route::view('datatable-data-source', 'tables.datatable-data-source')->name('datatable-data-source');
    Route::view('datatable-ext-autofill', 'tables.datatable-ext-autofill')->name('datatable-ext-autofill');
    Route::view('datatable-ext-basic-button', 'tables.datatable-ext-basic-button')->name('datatable-ext-basic-button');
    Route::view('datatable-ext-col-reorder', 'tables.datatable-ext-col-reorder')->name('datatable-ext-col-reorder');
    Route::view('datatable-ext-fixed-header', 'tables.datatable-ext-fixed-header')->name('datatable-ext-fixed-header');
    Route::view('datatable-ext-html-5-data-export', 'tables.datatable-ext-html-5-data-export')->name('datatable-ext-html-5-data-export');
    Route::view('datatable-ext-key-table', 'tables.datatable-ext-key-table')->name('datatable-ext-key-table');
    Route::view('datatable-ext-responsive', 'tables.datatable-ext-responsive')->name('datatable-ext-responsive');
    Route::view('datatable-ext-row-reorder', 'tables.datatable-ext-row-reorder')->name('datatable-ext-row-reorder');
    Route::view('datatable-ext-scroller', 'tables.datatable-ext-scroller')->name('datatable-ext-scroller');
    Route::view('jsgrid-table', 'tables.jsgrid-table')->name('jsgrid-table');
});

Route::prefix('charts')->group(function () {
    Route::view('echarts', 'charts.echarts')->name('echarts');
    Route::view('chart-apex', 'charts.chart-apex')->name('chart-apex');
    Route::view('chart-google', 'charts.chart-google')->name('chart-google');
    Route::view('chart-sparkline', 'charts.chart-sparkline')->name('chart-sparkline');
    Route::view('chart-flot', 'charts.chart-flot')->name('chart-flot');
    Route::view('chart-knob', 'charts.chart-knob')->name('chart-knob');
    Route::view('chart-morris', 'charts.chart-morris')->name('chart-morris');
    Route::view('chartjs', 'charts.chartjs')->name('chartjs');
    Route::view('chartist', 'charts.chartist')->name('chartist');
    Route::view('chart-peity', 'charts.chart-peity')->name('chart-peity');
});

Route::view('sample-page', 'pages.sample-page')->name('sample-page');
Route::view('internationalization', 'pages.internationalization')->name('internationalization');

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

Route::prefix('authentication')->group(function () {
    // Route::view('login', 'authentication.login')->name('login');
    Route::view('login-one', 'authentication.login-one')->name('login-one');
    Route::view('login-two', 'authentication.login-two')->name('login-two');
    Route::view('login-bs-validation', 'authentication.login-bs-validation')->name('login-bs-validation');
    Route::view('login-bs-tt-validation', 'authentication.login-bs-tt-validation')->name('login-bs-tt-validation');
    Route::view('login-sa-validation', 'authentication.login-sa-validation')->name('login-sa-validation');
    Route::view('sign-up', 'authentication.sign-up')->name('sign-up');
    Route::view('sign-up-one', 'authentication.sign-up-one')->name('sign-up-one');
    Route::view('sign-up-two', 'authentication.sign-up-two')->name('sign-up-two');
    Route::view('sign-up-wizard', 'authentication.sign-up-wizard')->name('sign-up-wizard');
    Route::view('unlock', 'authentication.unlock')->name('unlock');
    Route::view('forget-password', 'authentication.forget-password')->name('forget-password');
    Route::view('reset-password', 'authentication.reset-password')->name('reset-password');
    Route::view('maintenance', 'authentication.maintenance')->name('maintenance');
});

Route::view('comingsoon', 'comingsoon.comingsoon')->name('comingsoon');
Route::view('comingsoon-bg-video', 'comingsoon.comingsoon-bg-video')->name('comingsoon-bg-video');
Route::view('comingsoon-bg-img', 'comingsoon.comingsoon-bg-img')->name('comingsoon-bg-img');

Route::view('basic-template', 'email-templates.basic-template')->name('basic-template');
Route::view('email-header', 'email-templates.email-header')->name('email-header');
Route::view('template-email', 'email-templates.template-email')->name('template-email');
Route::view('template-email-2', 'email-templates.template-email-2')->name('template-email-2');
Route::view('ecommerce-templates', 'email-templates.ecommerce-templates')->name('ecommerce-templates');
Route::view('email-order-success', 'email-templates.email-order-success')->name('email-order-success');

Route::prefix('gallery')->group(function () {
    Route::view('index', 'apps.gallery')->name('gallery');
    Route::view('with-gallery-description', 'apps.gallery-with-description')->name('gallery-with-description');
    Route::view('gallery-masonry', 'apps.gallery-masonry')->name('gallery-masonry');
    Route::view('masonry-gallery-with-disc', 'apps.masonry-gallery-with-disc')->name('masonry-gallery-with-disc');
    Route::view('gallery-hover', 'apps.gallery-hover')->name('gallery-hover');
});

Route::prefix('blog')->group(function () {
    Route::view('index', 'apps.blog')->name('blog');
    Route::view('blog-single', 'apps.blog-single')->name('blog-single');
    Route::view('add-post', 'apps.add-post')->name('add-post');
});

Route::view('faq', 'apps.faq')->name('faq');

Route::prefix('job-search')->group(function () {
    Route::view('job-cards-view', 'apps.job-cards-view')->name('job-cards-view');
    Route::view('job-list-view', 'apps.job-list-view')->name('job-list-view');
    Route::view('job-details', 'apps.job-details')->name('job-details');
    Route::view('job-apply', 'apps.job-apply')->name('job-apply');
});

Route::prefix('learning')->group(function () {
    Route::view('learning-list-view', 'apps.learning-list-view')->name('learning-list-view');
    Route::view('learning-detailed', 'apps.learning-detailed')->name('learning-detailed');
});

Route::prefix('maps')->group(function () {
    Route::view('map-js', 'apps.map-js')->name('map-js');
    Route::view('vector-map', 'apps.vector-map')->name('vector-map');
});

Route::prefix('editors')->group(function () {
    Route::view('summernote', 'apps.summernote')->name('summernote');
    Route::view('ckeditor', 'apps.ckeditor')->name('ckeditor');
    Route::view('simple-mde', 'apps.simple-mde')->name('simple-mde');
    Route::view('ace-code-editor', 'apps.ace-code-editor')->name('ace-code-editor');
});

Route::view('knowledgebase', 'apps.knowledgebase')->name('knowledgebase');
Route::view('support-ticket', 'apps.support-ticket')->name('support-ticket');
Route::view('landing-page', 'pages.landing-page')->name('landing-page');

Route::prefix('layouts')->group(function () {
    Route::view('compact-sidebar', 'admin_unique_layouts.compact-sidebar'); //default //Dubai
    Route::view('box-layout', 'admin_unique_layouts.box-layout'); //default //New York //
    Route::view('dark-sidebar', 'admin_unique_layouts.dark-sidebar');

    Route::view('default-body', 'admin_unique_layouts.default-body');
    Route::view('compact-wrap', 'admin_unique_layouts.compact-wrap');
    Route::view('enterprice-type', 'admin_unique_layouts.enterprice-type');

    Route::view('compact-small', 'admin_unique_layouts.compact-small');
    Route::view('advance-type', 'admin_unique_layouts.advance-type');
    Route::view('material-layout', 'admin_unique_layouts.material-layout');

    Route::view('color-sidebar', 'admin_unique_layouts.color-sidebar');
    Route::view('material-icon', 'admin_unique_layouts.material-icon');
    Route::view('modern-layout', 'admin_unique_layouts.modern-layout');
});

Route::get('layout-{light}', function ($light) {
    session()->put('layout', $light);
    session()->get('layout');
    if ($light == 'vertical-layout') {
        return redirect()->route('pages-vertical-layout');
    }
    return redirect()->route('index');
    return 1;
});
Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return 'Cache is cleared';
})->name('clear.cache');
