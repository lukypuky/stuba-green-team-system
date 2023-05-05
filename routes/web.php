<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VanReservationController;
use Illuminate\Support\Facades\Auth;

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

//vendor/laravel/routes/routes.php

Route::get('/', function () {
    return redirect('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('dashboard');

    Route::get('/dashboard-admin-pouzivatelia', [AdminController::class, 'getUsers'])->name('dashboard-get-users');
    Route::get('/dashboard-admin-detail-pouzivatela/{id}', [AdminController::class, 'getUserDetail'])->name('dashboard-get-user-detail');
    Route::post('/dashboard-admin-detail-pouzivatel-update', [AdminController::class, 'updateUser'])->name('dashboard-update-user');
    Route::get('/dashboard-admin-registracia', [RegisterController::class, 'getStoreUserPage'])->name('dashboard-store-user-page');
    Route::post('/dashboard-admin-registracia', [RegisterController::class, 'storeUser'])->name('dashboard-store-user');

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    Route::get('/dashboard-admin-typy-uloh', [AdminController::class, 'getTaskTypes'])->name('dashboard-get-task-types');
    Route::post('/dashboard-admin-typy-uloh', [AdminController::class, 'deleteTaskType'])->name('dashboard-delete-task-type');
    Route::get('/dashboard-admin-detail-typu-ulohy/{id}', [AdminController::class, 'getTaskTypeDetail'])->name('dashboard-task-type-detail');
    Route::post('/dashboard-admin-detail-typ-ulohy-update', [AdminController::class, 'updateTaskType'])->name('dashboard-update-task-type');
    Route::get('/dashboard-admin-typ-ulohy-pridanie', [AdminController::class, 'getTaskTypeStorePage'])->name('dashboard-get-task-type-store-page');
    Route::post('/dashboard-admin-typ-ulohy-pridanie', [AdminController::class, 'storeTaskType'])->name('dashboard-store-task-type');

    Route::get('/dashboard-admin-stavy-uloh', [AdminController::class, 'getTaskStatuses'])->name('dashboard-get-task-statuses');
    Route::post('/dashboard-admin-stavy-uloh', [AdminController::class, 'deleteTaskStatus'])->name('dashboard-delete-task-status');
    Route::get('/dashboard-admin-detail-stavu-ulohy/{id}', [AdminController::class, 'getTaskStatusDetail'])->name('dashboard-task-status-detail');
    Route::post('/dashboard-admin-detail-stav-ulohy-update', [AdminController::class, 'updateTaskStatus'])->name('dashboard-update-task-status');
    Route::get('/dashboard-admin-stav-ulohy-pridanie', [AdminController::class, 'getTaskStatusStorePage'])->name('dashboard-get-task-status-store-page');
    Route::post('/dashboard-admin-stav-ulohy-pridanie', [AdminController::class, 'storeTaskStatus'])->name('dashboard-store-task-status');

    Route::get('/dashboard-admin-priority-uloh', [AdminController::class, 'getTaskPriorities'])->name('dashboard-get-task-priorities');
    Route::post('/dashboard-admin-priority-uloh', [AdminController::class, 'deleteTaskPriority'])->name('dashboard-delete-task-priority');
    Route::get('/dashboard-admin-detail-priority-ulohy/{id}', [AdminController::class, 'getTaskPriorityDetail'])->name('dashboard-task-priority-detail');
    Route::post('/dashboard-admin-detail-priorita-ulohy-update', [AdminController::class, 'updateTaskPriority'])->name('dashboard-update-task-priority');
    Route::get('/dashboard-admin-priorita-ulohy-pridanie', [AdminController::class, 'getTaskPriorityStorePage'])->name('dashboard-get-task-priority-store-page');
    Route::post('/dashboard-admin-priorita-ulohy-pridanie', [AdminController::class, 'storeTaskPriority'])->name('dashboard-store-task-priority');

    Route::get('/dashboard-admin-stavy-objednavok', [AdminController::class, 'getOrderStatuses'])->name('dashboard-get-order-statuses');
    Route::post('/dashboard-admin-stavy-objednavok', [AdminController::class, 'deleteOrderStatus'])->name('dashboard-delete-order-status');
    Route::get('/dashboard-admin-detail-stavy-objednavok/{id}', [AdminController::class, 'getOrderStatusDetail'])->name('dashboard-order-status-detail');
    Route::post('/dashboard-admin-detail-stav-objednavky-update', [AdminController::class, 'updateOrderStatus'])->name('dashboard-update-order-status');
    Route::get('/dashboard-admin-stav-objednavky-pridanie', [AdminController::class, 'getOrderStatusStorePage'])->name('dashboard-get-order-status-store-page');
    Route::post('/dashboard-admin-stav-objednavky-pridanie', [AdminController::class, 'storeOrderStatus'])->name('dashboard-store-order-status');

    Route::get('/dashboard-admin-priority-objednavok', [AdminController::class, 'getOrderPriorities'])->name('dashboard-get-order-priorities');
    Route::post('/dashboard-admin-priority-objednavok', [AdminController::class, 'deleteOrderPriority'])->name('dashboard-delete-order-priority');
    Route::get('/dashboard-admin-detail-priority-objednavok/{id}', [AdminController::class, 'getOrderPriorityDetail'])->name('dashboard-order-priority-detail');
    Route::post('/dashboard-admin-detail-priorita-objednavky-update', [AdminController::class, 'updateOrderPriority'])->name('dashboard-update-order-priority');
    Route::get('/dashboard-admin-priorita-objednavky-pridanie', [AdminController::class, 'getOrderPriorityStorePage'])->name('dashboard-get-order-priority-store-page');
    Route::post('/dashboard-admin-priorita-objednavky-pridanie', [AdminController::class, 'storeOrderPriority'])->name('dashboard-store-order-priority');
    
    Route::get('/dashboard-admin-typy-stretnuti', [AdminController::class, 'getMeetingTypes'])->name('dashboard-get-meeting-types');
    Route::post('/dashboard-admin-typy-stretnuti', [AdminController::class, 'deleteMeetingType'])->name('dashboard-delete-meeting-type');
    Route::get('/dashboard-admin-detail-typy-stretnuti/{id}', [AdminController::class, 'getMeetingTypeDetail'])->name('dashboard-meeting-type-detail');
    Route::post('/dashboard-admin-detail-typ-stretnutia-update', [AdminController::class, 'updateMeetingType'])->name('dashboard-update-meeting-type');
    Route::get('/dashboard-admin-typ-stretnutia-pridanie', [AdminController::class, 'getMeetingTypeStorePage'])->name('dashboard-get-meeting-type-store-page');
    Route::post('/dashboard-admin-typ-stretnutia-pridanie', [AdminController::class, 'storeMeetingType'])->name('dashboard-store-meeting-type');

    Route::get('/dashboard-admin-casti-formuly', [AdminController::class, 'getFormulaParts'])->name('dashboard-get-formula-parts');
    Route::post('/dashboard-admin-casti-formuly', [AdminController::class, 'deleteFormulaPart'])->name('dashboard-delete-formula-part');
    Route::get('/dashboard-admin-detail-casti-formuly/{id}', [AdminController::class, 'getFormulaPartDetail'])->name('dashboard-formula-part-detail');
    Route::post('/dashboard-admin-detail-cast-formuly-update', [AdminController::class, 'updateFormulaPart'])->name('dashboard-update-formula-part');
    Route::get('/dashboard-admin-cast-formuly-pridanie', [AdminController::class, 'getFormulaPartStorePage'])->name('dashboard-get-formula-part-store-page');
    Route::post('/dashboard-admin-cast-formuly-pridanie', [AdminController::class, 'storeFormulaPart'])->name('dashboard-store-formula-part');

    Route::get('/dashboard-admin-divizie', [AdminController::class, 'getDivisions'])->name('dashboard-get-divisions');
    Route::post('/dashboard-admin-divizie', [AdminController::class, 'deleteDivision'])->name('dashboard-delete-division');
    Route::get('/dashboard-admin-detail-divizie/{id}', [AdminController::class, 'getDivisionDetail'])->name('dashboard-division-detail');
    Route::post('/dashboard-admin-detail-divizia-update', [AdminController::class, 'updateDivision'])->name('dashboard-update-division');
    Route::get('/dashboard-admin-divizia-pridanie', [AdminController::class, 'getDivisionStorePage'])->name('dashboard-get-division-store-page');
    Route::post('/dashboard-admin-divizia-pridanie', [AdminController::class, 'storeDivision'])->name('dashboard-store-division');

    Route::get('/dashboard-admin-meny', [AdminController::class, 'getCurrencies'])->name('dashboard-get-currencies');
    Route::post('/dashboard-admin-meny', [AdminController::class, 'deleteCurrency'])->name('dashboard-delete-currency');
    Route::get('/dashboard-admin-detail-meny/{id}', [AdminController::class, 'getCurrencyDetail'])->name('dashboard-currency-detail');
    Route::post('/dashboard-admin-detail-mena-update', [AdminController::class, 'updateCurrency'])->name('dashboard-update-currency');
    Route::get('/dashboard-admin-mena-pridanie', [AdminController::class, 'getCurrencyStorePage'])->name('dashboard-get-currency-store-page');
    Route::post('/dashboard-admin-mena-pridanie', [AdminController::class, 'storeCurrency'])->name('dashboard-store-currency');

    Route::get('/dashboard-admin-oblasti', [AdminController::class, 'getAreas'])->name('dashboard-get-areas');
    Route::post('/dashboard-admin-oblasti', [AdminController::class, 'deleteArea'])->name('dashboard-delete-area');
    Route::get('/dashboard-admin-detail-oblasti/{id}', [AdminController::class, 'getAreaDetail'])->name('dashboard-area-detail');
    Route::post('/dashboard-admin-detail-oblast-update', [AdminController::class, 'updateArea'])->name('dashboard-update-area');
    Route::get('/dashboard-admin-oblast-pridanie', [AdminController::class, 'getAreaStorePage'])->name('dashboard-get-area-store-page');
    Route::post('/dashboard-admin-oblast-pridanie', [AdminController::class, 'storeArea'])->name('dashboard-store-area');

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    Route::get('/dashboard-moje-objednavky', [OrderController::class, 'getMyOrders'])->name('dashboard-my-orders');
    Route::get('/dashboard-vsetky-objednavky', [OrderController::class, 'getAllOrders'])->name('dashboard-all-orders');
    Route::post('/dashboard-objednavky-pridanie', [OrderController::class, 'storeOrder'])->name('dashboard-store-order');
    Route::post('/dashboard-objednavky-update', [OrderController::class, 'updateOrder'])->name('dashboard-update-order');
    Route::post('/dashboard-objednavky-delete', [OrderController::class, 'deleteOrder'])->name('dashboard-delete-order');
    Route::post('/dashboard-hladaj-objednavky', [OrderController::class, 'getSearchedOrders'])->name('dashboard-search-orders');

    Route::get('/dashboard', [ReportController::class, 'getReports'])->name('dashboard');
    Route::post('/dashboard-vykaz-pridanie', [ReportController::class, 'storeReport'])->name('dashboard-store-report');
    Route::post('/dashboard-vykaz-update', [ReportController::class, 'updateReport'])->name('dashboard-update-report');
    Route::post('/dashboard-vykaz-delete', [ReportController::class, 'deleteReport'])->name('dashboard-delete-report');
    Route::post('/dashboard-vykaz-zmena-pouzivatela', [ReportController::class, 'changeReportUser'])->name('dashboard-change-report-user');

    Route::get('/dashboard-prehlad-vykazov', [ReportController::class, 'getAllReports'])->name('dashboard-get-all-reports');
    Route::post('/dashboard-prehlad-vykazov', [ReportController::class, 'changeReportsMonth'])->name('dashboard-change-reports-month');

    Route::get('/dashboard-moje-ulohy', [TaskController::class, 'getModalTaskData'])->name('dashboard-tasks');
    Route::post('/dashboard-moje-ulohy', [TaskController::class, 'storeNewTask'])->name('dashboard-store-task');
    Route::get('/dashboard-ulohy/{id}', [TaskController::class, 'getTaskDetail'])->name('dashboard-task-detail');
    Route::post('/dashboard-uloha-update', [TaskController::class, 'updateTask'])->name('dashboard-update-task');
    Route::post('/dashboard-uloha-delete', [TaskController::class, 'deleteTask'])->name('dashboard-delete-task');
    Route::get('/dashboard-vsetky-ulohy', [TaskController::class, 'getAllTasks'])->name('dashboard-all-tasks');
    Route::post('/dashboard-hladaj-ulohy', [TaskController::class, 'getSearchedTasks'])->name('dashboard-search-tasks');
    Route::post('/dashboard-komentar-pridanie', [TaskController::class, 'storeComment'])->name('dashboard-store-comment');
    
    Route::get('/dashboard-dochadzka', [AttendanceController::class, 'getAttendance'])->name('dashboard-attendance');
    Route::post('/dashboard-dochadzka', [AttendanceController::class, 'changeMeetingType'])->name('dashboard-change-meeting-type');
    Route::post('/dashboard-dochadzka-pridanie', [AttendanceController::class, 'storeAttendance'])->name('dashboard-store-attendance');
    Route::post('/dashboard-dochadzka-update', [AttendanceController::class, 'updateAttendance'])->name('dashboard-update-attendance');
    Route::post('/dashboard-dochadzka-delete', [AttendanceController::class, 'deleteAttendance'])->name('dashboard-delete-attendance');

    Route::get('/dashboard-rezervacie-dodavky', [VanReservationController::class, 'getVanReservations'])->name('dashboard-van-reservations');
    Route::post('/dashboard-rezervacia-dodavky-pridanie', [VanReservationController::class, 'storeVanReservation'])->name('dashboard-store-van-reservation');
    Route::post('/dashboard-rezervacia-dodavky-update', [VanReservationController::class, 'updateReservation'])->name('dashboard-update-van-reservation');
    Route::post('/dashboard-rezervacia-dodavky-delete', [VanReservationController::class, 'deleteReservation'])->name('dashboard-delete-van-reservation');
    Route::post('/dashboard-hladaj-rezervacie-dodavky', [VanReservationController::class, 'getSearchedVanReservations'])->name('dashboard-search-van-reservations');
});
