<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AttendanceController;

use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/dashboard-moje-objednavky', [OrderController::class, 'getMyOrders'])->name('dashboard-my-orders');
    Route::post('/dashboard-objednavky-pridanie', [OrderController::class, 'storeOrder'])->name('dashboard-store-order');
    Route::post('/dashboard-objednavky-update', [OrderController::class, 'updateOrder'])->name('dashboard-update-order');
    Route::post('/dashboard-objednavky-delete', [OrderController::class, 'deleteOrder'])->name('dashboard-delete-order');

    Route::get('/dashboard-vykaz', [ReportController::class, 'getReports'])->name('dashboard-report');
    Route::post('/dashboard-vykaz-pridanie', [ReportController::class, 'storeReport'])->name('dashboard-store-report');
    Route::post('/dashboard-vykaz-update', [ReportController::class, 'updateReport'])->name('dashboard-update-report');
    Route::post('/dashboard-vykaz-mazanie', [ReportController::class, 'deleteReport'])->name('dashboard-delete-report');

    Route::get('/dashboard-moje-ulohy', [TaskController::class, 'getModalTaskData'])->name('dashboard-tasks');
    Route::post('/dashboard-moje-ulohy', [TaskController::class, 'storeNewTask'])->name('dashboard-store-task');
    Route::get('/dashboard-ulohy/{id}', [TaskController::class, 'getTaskDetail'])->name('dashboard-task-detail');
    Route::post('/dashboard-uloha-update', [TaskController::class, 'updateTask'])->name('dashboard-update-task');
    Route::post('/dashboard-uloha-delete', [TaskController::class, 'deleteTask'])->name('dashboard-delete-task');
    Route::get('/dashboard-vsetky-ulohy', [TaskController::class, 'getAllTasks'])->name('dashboard-all-tasks');
    Route::post('/dashboard-hladaj-ulohy', [TaskController::class, 'getSearchedTasks'])->name('dashboard-search-tasks');
    
    Route::get('/dashboard-dochadzka', [AttendanceController::class, 'getAttendance'])->name('dashboard-attendance');
    Route::post('/dashboard-dochadzka', [AttendanceController::class, 'changeMeetingType'])->name('dashboard-change-meeting-type');
    Route::post('/dashboard-ulozit-dochadzku', [AttendanceController::class, 'storeAttendance'])->name('dashboard-store-attendance');
});
