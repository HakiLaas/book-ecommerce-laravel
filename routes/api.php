<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminNotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Admin Notification API Routes
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin/notifications', [AdminNotificationController::class, 'index']);
    Route::get('/admin/notifications/{id}', [AdminNotificationController::class, 'show']);
    Route::put('/admin/notifications/{id}/read', [AdminNotificationController::class, 'markAsRead']);
    Route::put('/admin/notifications/read-all', [AdminNotificationController::class, 'markAllAsRead']);
    Route::put('/admin/notifications/{id}/status', [AdminNotificationController::class, 'updateStatus']);
    Route::get('/admin/notifications/unread/count', [AdminNotificationController::class, 'getUnreadCount']);
    Route::get('/admin/notifications/recent', [AdminNotificationController::class, 'getRecentNotifications']);
});
