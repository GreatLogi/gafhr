<?php

use App\Http\Controllers\Api\Approve\ApproveController;
use App\Http\Controllers\Api\GeneralReportController;
use App\Http\Controllers\Api\Integration\PersonnelIntegrationController;
use App\Http\Controllers\Api\LogActivities\UserAuditTrailActivitiesController;
use App\Http\Controllers\Api\LogActivities\UserLogActivitiesController;
use App\Http\Controllers\Api\Mission\OnMissionController;
use App\Http\Controllers\Api\Pending\PendingController;
use App\Http\Controllers\Api\personnelcontroller;
use App\Http\Controllers\Api\Return\ReturnController;
use App\Http\Controllers\Api\TrackMissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('personnel')->group(function () {
    Route::post('/api-view-personnel', [personnelcontroller::class, 'index'])->name('api-view-personnel');
    Route::post('/store', [personnelcontroller::class, 'store'])->name('api.appointments.store');
});

Route::prefix('mission-record')->group(function () {
    Route::post('/api-view-record', [TrackMissionController::class, 'TrackMissionData'])->name('api-mission-record');
    Route::post('/store', [TrackMissionController::class, 'store'])->name('api-appointments-store');
});
Route::prefix('user-logs-activities')->group(function () {
    Route::post('/api-user-logs-activities', [UserLogActivitiesController::class, 'index'])->name('api-user-logs-activities');
    Route::post('/api-audit-logs', [UserAuditTrailActivitiesController::class, 'index'])->name('api-audit-logs');
});

Route::prefix('mission-status')->group(function () {
    Route::post('/api-pending-record', [PendingController::class, 'Pending'])->name('api-pending-record');
    Route::post('/api-pending-first-user-dashbaord', [PendingController::class, 'Pending_first_user_dashboard'])->name('api-pending-first-user-dashbaord');
    Route::post('/api-approve-record', [ApproveController::class, 'Approve_Deployment'])->name('api-approve-record');
    Route::post('/api-approve-user-first-dashboard', [ApproveController::class, 'Approve_Deployment_first_user'])->name('api-approve-user-first-dashboard');
    Route::post('/api-on-mission-record', [OnMissionController::class, 'OnMission'])->name('api-on-mission-record');
    Route::post('/api-first-user-dashbaord', [OnMissionController::class, 'FirstUserDashboardArrival'])->name('api-first-user-dashbaord');
    Route::post('api-returned-mission', [ReturnController::class, 'return'])->name('returned-mission');
    Route::post('api-personnel-returned-from-travel', [ReturnController::class, 'return_from_travel'])->name('personnel-returned-from-travel');
});
Route::prefix('reports')->group(function () {
    Route::POST('/api-main-report', [GeneralReportController::class, 'report'])->name('api-main-report');
    Route::post('/api-filter-main-report', [GeneralReportController::class, 'searchfilter'])->name('api-filter-report');
    Route::post('/report-filter-base-on-monthly-weekly-daily', [GeneralReportController::class, 'report_base_on_month_weekly_daily'])->name('report-filter-base-on-monthly-weekly-daily');
});

Route::prefix('integrations')->group(function () {
    Route::get('/personnel/{serviceNo}', [PersonnelIntegrationController::class, 'show'])->name('api.integrations.personnel.show');
});
