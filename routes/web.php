<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AttendanceController;

use App\Http\Controllers\TaskTypeController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\TaskPriorityController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\AreaController;

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

    Route::get('/dashboard-nakup', [PurchaseController::class, 'getUsers'])->name('dashboard-purchase');

    Route::get('/dashboard-vykaz', CalendarController::class)->name('dashboard-report');
    Route::get('/dashboard-moje-ulohy', [TaskController::class, 'getModalTaskData'])->name('dashboard-tasks');
    Route::post('/dashboard-moje-ulohy', [TaskController::class, 'saveNewTask'])->name('dashboard-save-task');
    Route::get('/dashboard-ulohy/{id}', [TaskController::class, 'getTaskDetail'])->name('dashboard-task-detail');
    Route::post('/dashboard-uloha', [TaskController::class, 'updateTask'])->name('dashboard-update-task');
    Route::get('/dashboard-vsetky-ulohy', [TaskController::class, 'getAllTasks'])->name('dashboard-all-tasks');
    Route::post('/dashboard-hladaj-ulohy', [TaskController::class, 'getSearchedTasks'])->name('dashboard-search-tasks');
    Route::get('/dashboard-dochadzka', [AttendanceController::class, 'getAttendance'])->name('dashboard-attendance');
    Route::post('/dashboard-dochadzka', [AttendanceController::class, 'changeMeetingType'])->name('dashboard-change-meeting-type');
    Route::post('/dashboard-ulozit-dochadzku', [AttendanceController::class, 'storeAttendance'])->name('dashboard-store-attendance');

    Route::resources([
        'report' => ReportController::class,
        'taskType' => TaskTypeController::class,
        'taskStatus' => TaskStatusController::class,
        'taskPriority' => TaskPriorityController::class,
        'division' => DivisionController::class,
        'area' => AreaController::class,
    ]);
});
