<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\Admin\AdminReportController;
use App\Http\Controllers\API\Admin\MissionController;
use App\Http\Controllers\API\MissionFeedController;
use App\Http\Controllers\API\AuthController;

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

// Routes العامة (بدون authentication)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes التي تتطلب authentication
Route::middleware('auth:sanctum')->group(function () {
    // معلومات المستخدم
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // تسجيل الخروج
    Route::post('/logout', [AuthController::class, 'logout']);

    // مستخدم عادي: إدارة البلاغات الخاصة به + إنشاء بلاغ
    Route::get('/reports', [ReportController::class, 'index']);        // قائمة البلاغات (مع فلترة)
    Route::post('/reports', [ReportController::class, 'store']);       // إنشاء بلاغ جديد
    Route::get('/reports/{report}', [ReportController::class, 'show']);

    // تغذية حيّة للمهمّة
    Route::post('/missions/{mission}/feed', [MissionFeedController::class, 'push']);
});

// Routes للإدارة (تتطلب authentication + admin privileges)
Route::middleware(['auth:sanctum', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/reports', [AdminReportController::class, 'index']); // فلترة حسب الحالة
    Route::patch('/reports/{report}/approve', [AdminReportController::class, 'approve']);
    Route::patch('/reports/{report}/reject', [AdminReportController::class, 'reject']);

    // إدارة المهمات
    Route::post('/missions', [MissionController::class, 'store']);           // إنشاء مهمة لبلاغ
    Route::patch('/missions/{mission}/status', [MissionController::class, 'updateStatus']);
    Route::get('/missions/{mission}', [MissionController::class, 'show']);
    Route::get('/missions/{mission}/timeline', [MissionController::class, 'timeline']); // التحديثات
});