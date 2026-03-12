<?php

use App\Http\Controllers\Api\GeneralReportController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\countrycontroller;
use App\Http\Controllers\LogactivityController;
use App\Http\Controllers\ManageUserAccountController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\personnelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\rankController;
use App\Http\Controllers\RecordManagerController;
use App\Http\Controllers\reportcontroller;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TrackTravelController;
use App\Http\Controllers\TrackTravelDashboardController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\UserController;
use App\Models\GAFTOTRAVELRECORD;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/otp/verify', [OTPController::class, 'showVerifyForm'])->name('otp.verify');
Route::post('/otp/verify', [OTPController::class, 'verify']);
Route::middleware([
    'auth:sanctum',config('jetstream.auth_session'),'verified', 'otp', 'force.password.change',])->group(function () {
    Route::get('/dashboard', [TrackTravelDashboardController::class, 'index'])->name('travel-dash');
});

Route::post('login', [PagesController::class, 'Log_in'])->name('login.dashboard');
Route::get('logout', [PagesController::class, 'Logout'])->name('logout')
    ->middleware('auth');
Route::prefix('reports')->group(function () {
    Route::get('/api-main-report', [GeneralReportController::class, 'report'])->name('web-main-report');
});
Route::group(['prefix' => 'settings'], function () {
    Route::resource('roles', RoleController::class, ['names' => 'roles']);
    Route::resource('users', UserController::class, ['names' => 'users']);
    Route::get('/forgot-password', [PagesController::class, 'resetpassword'])->name('forgot-password');
    Route::post('/forgot-password', [PagesController::class, 'resetpasswordSubmit'])->name('forgot-password.submit');
    Route::get('/change-password', [PagesController::class, 'verifyaccount'])->name('verify-password');
    Route::post('/password-changed', [ManageUserAccountController::class, 'changePassword'])->name('changed-password');
    Route::prefix('Profile')->group(function () {
        Route::get('/', [ProfileController::class, 'ProfileView'])->name('profileview');
        Route::get('/edit', [ProfileController::class, 'ProfileEdit'])->name('profile.edit');
        Route::post('/store', [ProfileController::class, 'ProfileStore'])->name('profile.store');
        Route::get('/password/view', [ProfileController::class, 'PasswordView'])->name('password.view');
        Route::post('/password/update', [ProfileController::class, 'PasswordUpdate'])->name('password.update');
        Route::get('/inactivation{id}', [ProfileController::class, 'Inactive'])->name('user.inactive');
        Route::get('/activation{id}', [ProfileController::class, 'Active'])->name('user.active');
    });
    Route::get('/login-activities', [LogactivityController::class, 'login_and_logout_activities'])->name('login_and_logout');
    Route::prefix('audit-trail')->group(function () {
        Route::get('/', [AuditController::class, 'ViewAudit'])->name('audit.trail');
        Route::get('/user-audit', [AuditController::class, 'AuthAudit'])->name('user-audit-trail');
    });
});

Route::prefix('gaf-hr')->group(function () {
    Route::get('/admin', [TrackTravelDashboardController::class, 'index'])->name('admin.index');
    Route::get('/admin-dashboard', function () {
        return redirect()->route('admin.index');
    })->name('admin-dashboard');

    Route::prefix('record-manager')->group(function () {
        Route::get('/', [TrackTravelDashboardController::class, 'recordmanager'])->name('record-manager');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/officers', [TrackTravelDashboardController::class, 'officerAnalysis'])->name('admin.officers');
        Route::get('/soldiers', [TrackTravelDashboardController::class, 'soldierAnalysis'])->name('admin.soldiers');
        Route::get('/ratings', [TrackTravelDashboardController::class, 'ratingAnalysis'])->name('admin.ratings');
     
        Route::prefix('records')->group(function () {
            Route::get('/', [TrackTravelController::class, 'View'])->name('view-record');
            Route::get('/mech', [personnelController::class, 'adminCreate'])->name('create-record');
            Route::post('/mech', [personnelController::class, 'adminStore'])->name('admin.personnel.store');
            Route::get('/mech-travel', [TrackTravelController::class, 'create'])->name('create-record-travel');
            Route::get('/mech-civilian', [TrackTravelController::class, 'create_civilian'])->name('create-civilian-record');
            Route::post('/store', [TrackTravelController::class, 'Store'])->name('store-record');
            Route::post('/store-civilian', [TrackTravelController::class, 'Store_Civilian'])->name('store-civilian-record');
            Route::get('/travel/edit/{uuid}', [TrackTravelController::class, 'Edit'])->name('edit-record');
            Route::get('/travel/edit-civilian/{uuid}', [TrackTravelController::class, 'Edit_Civilian'])->name('edit-civilian-record');
            Route::post('/travel/update{uuid}', [TrackTravelController::class, 'Update'])->name('update-record');
            Route::post('/travel/update/civilian-{uuid}', [TrackTravelController::class, 'Civilian_Record_Update'])->name('update-civilian-record');
            Route::get('/travel/delete{uuid}', [TrackTravelController::class, 'Delete'])->name('delete-record');
            Route::get('/travel/pending', [TrackTravelController::class, 'Pending'])->name('mission-pending');
            // Route::get('/approving{id}', [TrackTravelController::class, 'Approve'])->name('course.approve');
            Route::post('/bulk-approve', [TrackTravelController::class, 'Bulk_Approve'])->name('bulk-approve');
            Route::post('/bulk-deployment', [TrackTravelController::class, 'Bulk_Deployed'])->name('bulk-deployment');
            Route::post('/bulk-return', [TrackTravelController::class, 'Bulk_Return'])->name('bulk-return');
            Route::get('/on-mission', [TrackTravelController::class, 'OnMission'])->name('on-mission');
            Route::get('/approve-mission', [TrackTravelController::class, 'Approve_Deployment'])->name('approve-personnel');
            Route::get('/repatriation/{uuid}', [TrackTravelController::class, 'Edit_Repatriation'])->name('repatriation-edit');
            Route::post('/repatriation/update/{uuid}', [TrackTravelController::class, 'Repatriation_Update'])->name('update-personnel-repatriation');
            Route::get('/travel/cancel', [TrackTravelController::class, 'Cancel'])->name('course.oncancel');
            Route::get('/cancel/approving{id}', [TrackTravelController::class, 'oncancel'])->name('course.approve.cancel');
            Route::get('/travel/schedule', [TrackTravelController::class, 'OnSchedule'])->name('course.schedule');
            Route::get('/reschedule/approving{id}', [TrackTravelController::class, 'Rescheduled'])->name('course.approve.reschedule');
            Route::get('/travel/personnel/returned', [TrackTravelController::class, 'Returned'])->name('course.arrived');
            Route::get('/personnel/arriving{id}', [TrackTravelController::class, 'Arrived'])->name('course.arriving.personnel');
            Route::get('/personal/details/{uuid}', [TrackTravelController::class, 'Details'])->name('record.details');
            Route::post('/import', [TrackTravelController::class, 'import'])->name('import-record');
            Route::post('/import-deployment', [TrackTravelController::class, 'ImportDeployment'])->name('import-deployement');
            Route::post('/return-import', [TrackTravelController::class, 'import_return'])->name('import-returned');
            Route::post('/fetch-countries', [TrackTravelController::class, 'fetchMission'])->name('fetch-countries');
            Route::post('/fetch-details', [TrackTravelController::class, 'fetchDetails'])->name('fetch-details');
            Route::post('/bulk-delete', [TrackTravelController::class, 'bulkDelete'])->name('bulk-delete');
            Route::prefix('manager')->group(function () {
                Route::get('/', [RecordManagerController::class, 'RecordManager'])->name('record-manager');
                Route::post('/personnel-data', [RecordManagerController::class, 'PersonnelData'])->name('record-manager-personnel-data');
                Route::get('/personnel/{uuid}/edit', [personnelController::class, 'adminEdit'])->name('admin.personnel.edit');
                Route::post('/personnel/{uuid}', [personnelController::class, 'adminUpdate'])->name('admin.personnel.update');
                Route::prefix('personnel/{uuid}')->group(function () {
                    Route::get('/awards', [personnelController::class, 'awards'])->name('admin.personnel.awards');
                    Route::post('/awards', [personnelController::class, 'storeAward'])->name('admin.personnel.awards.store');
                    Route::get('/courses', [personnelController::class, 'courses'])->name('admin.personnel.courses');
                    Route::post('/courses', [personnelController::class, 'storeCourse'])->name('admin.personnel.courses.store');
                    Route::get('/promotions', [personnelController::class, 'promotions'])->name('admin.personnel.promotions');
                    Route::post('/promotions', [personnelController::class, 'storePromotion'])->name('admin.personnel.promotions.store');
                    Route::get('/documents', [personnelController::class, 'documents'])->name('admin.personnel.documents');
                    Route::post('/documents', [personnelController::class, 'storeDocument'])->name('admin.personnel.documents.store');
                    Route::get('/family', [personnelController::class, 'family'])->name('admin.personnel.family');
                    Route::post('/family', [personnelController::class, 'storeFamily'])->name('admin.personnel.family.store');
                    Route::get('/next-of-kin', [personnelController::class, 'nextOfKin'])->name('admin.personnel.next_of_kin');
                    Route::post('/next-of-kin', [personnelController::class, 'storeNextOfKin'])->name('admin.personnel.next_of_kin.store');
                    Route::get('/posts', [personnelController::class, 'posts'])->name('admin.personnel.posts');
                    Route::post('/posts', [personnelController::class, 'storePost'])->name('admin.personnel.posts.store');
                    Route::get('/remarks', [personnelController::class, 'remarks'])->name('admin.personnel.remarks');
                    Route::post('/remarks', [personnelController::class, 'storeRemark'])->name('admin.personnel.remarks.store');
                    Route::get('/interviews', [personnelController::class, 'interviews'])->name('admin.personnel.interviews');
                    Route::post('/interviews', [personnelController::class, 'storeInterview'])->name('admin.personnel.interviews.store');
                });
                Route::get('/deployment', [RecordManagerController::class, 'RecordUpdate'])->name('record-manager-update');
                Route::get('/pending/deployment', [RecordManagerController::class, 'RecordApprove'])->name('record-manager-approve');
                Route::get('/pending', [RecordManagerController::class, 'RecordPending'])->name('record-manager-pending');
                Route::post('/update', [RecordManagerController::class, 'Record_Update_From_Server'])->name('manager-update-record');
                Route::post('/pending', [RecordManagerController::class, 'Record_Pending_From_Server'])->name('manager-pending-record');
                Route::post('/approve', [RecordManagerController::class, 'Record_Approve_From_Server'])->name('manager-approve-record');
            });
        });
    });

    Route::prefix('arm-of-service')->group(function () {
        Route::get('/', [ServiceController::class, 'Index'])->name('arm-view');
        Route::get('/mech', [ServiceController::class, 'create'])->name('arm-add');
        Route::post('/store', [ServiceController::class, 'store'])->name('arm-store');
        Route::get('/edit/{uuid}', [ServiceController::class, 'Edit'])->name('arm-edit');
        Route::post('/update', [ServiceController::class, 'update'])->name('arm-update');
        Route::get('/delete{uuid}', [ServiceController::class, 'delete'])->name('arm-delete');
    });
    Route::prefix('rank')->group(function () {
        Route::get('/', [rankcontroller::class, 'View'])->name('view-rank');
        Route::get('/mech', [rankcontroller::class, 'RankAdd'])->name('rank-add');
        Route::post('/store', [rankcontroller::class, 'Store'])->name('rank-store');
        Route::get('/edit/{uuid}', [rankcontroller::class, 'Edit'])->name('rank-edit');
        Route::post('/update{uuid}', [rankcontroller::class, 'Update'])->name('rank-update');
        Route::get('/delete{uuid}', [rankcontroller::class, 'Delete'])->name('rank-delete');
    });
    Route::prefix('general-report')->group(function () {
        Route::get('/', [reportcontroller::class, 'report'])->name('system-report');
        Route::post('/post/filter', [reportcontroller::class, 'searchfilter'])->name('filter-report');
    });
    Route::prefix('country')->group(function () {
        Route::get('/', [countrycontroller::class, 'View'])->name('view-country');
        Route::get('/mech', [countrycontroller::class, 'Add'])->name('mech-country');
        Route::post('/store', [countrycontroller::class, 'Store'])->name('store-country');
        Route::get('/edit/{uuid}', [countrycontroller::class, 'Edit'])->name('edit-country');
        Route::post('/update{uuid}', [countrycontroller::class, 'Update'])->name('update-country');
        Route::get('/delete{uuid}', [countrycontroller::class, 'Delete'])->name('delete-country');
    });

    Route::prefix('unit')->group(function () {
        Route::get('/view', [UnitController::class, 'View'])->name('view-unit');
        Route::get('/add', [UnitController::class, 'Add'])->name('add-unit');
        Route::post('/store', [UnitController::class, 'Store'])->name('store-unit');
        Route::get('/edit/{uuid}', [UnitController::class, 'Edit'])->name('edit-unit');
        Route::post('/update/{uuid}', [UnitController::class, 'Update'])->name('update-unit');
        Route::get('/delete{uuid}', [UnitController::class, 'Delete'])->name('delete-unit');
    });
    Route::prefix('personnel')->group(function () {
        Route::get('/', [personnelController::class, 'index'])->name('personal-view');
        Route::get('/mech', [personnelController::class, 'create'])->name('personal-mech');
        Route::post('/store', [personnelController::class, 'store'])->name('personal-store');
        Route::get('/edit/{uuid}', [personnelController::class, 'edit'])->name('personal-edit');
        Route::post('/update', [personnelController::class, 'update'])->name('personal-update');
        Route::get('/delete{uuid}', [personnelController::class, 'delete'])->name('personal-delete');
        Route::post('/import', [personnelController::class, 'import'])->name('import-personnel');
        Route::get('/download-sample-excel', [personnelController::class, 'downloadSampleExcel']);
    });
    Route::prefix('user-activity')->group(function () {
        Route::post('/user-activity', [UserActivityController::class, 'UserData'])->name('user-activity');
    });

});

// ./vendor/bin/pint -v
// git config --global  pull.ff true
