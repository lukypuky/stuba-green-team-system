<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\TaskType;
use App\Models\TaskStatus;
use App\Models\TaskPriority;
use App\Models\Division;
use App\Models\OrderStatus;
use App\Models\OrderPriority;
use App\Models\MeetingType;
use App\Models\FormulaPartSpecify;
use App\Models\Currency;
use App\Models\Area;
use App\Http\Requests\User as UserRequest;
use App\Http\Requests\TaskType as TaskTypeRequest;
use App\Http\Requests\TaskStatus as TaskStatusRequest;
use App\Http\Requests\TaskPriority as TaskPriorityRequest;
use App\Http\Requests\OrderStatus as OrderStatusRequest;
use App\Http\Requests\OrderPriority as OrderPriorityRequest;
use App\Http\Requests\MeetingType as MeetingTypeRequest;
use App\Http\Requests\FormulaPartSpecify as FormulaPartSpecifyRequest;
use App\Http\Requests\Division as DivisionRequest;
use App\Http\Requests\Currency as CurrencyRequest;
use App\Http\Requests\Area as AreaRequest;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function getUsers(){
        $users = User::where('users.id', '!=', Auth::user()->id)
        ->join('roles', 'users.role_id', '=', 'roles.id')
        ->join('divisions', 'users.division_id', '=', 'divisions.id')
        ->orderBy('users.active', 'DESC')
        ->orderBy('users.id', 'DESC')
        ->select(['users.id', 'users.name', 'users.email', 'users.active', 'users.role_id', 'roles.role_title', 'divisions.division_title'])
        ->paginate(7);

        return Inertia::render('Admin/AdminUsers', [
            'users' =>  $users,
        ]);
    }

    public function getUserDetail($id){
        $user = User::where('id', $id)->get();

        $roles = Role::all();
        $divisions = Division::all();

        return Inertia::render('Admin/AdminUserDetail', [
            'userDetail' =>  $user,
            'divisions' => $divisions,
            'roles' => $roles,
        ]);
    }

    public function updateUser(UserRequest $request){
        try {
            User::where('id', $request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'division_id' => $request->division_id,
                'role_id' => $request->role_id,
                // 'is_admin' => $request->is_admin,
                'active' => $request->active,
            ]);
        } catch (\Throwable $e) {
            return redirect()->back()->with('unsuccess_user_save', 'Tento email už niekto používa.');
        }

        return redirect()->back()->with('success_object_update_save', 'Upravené.');
    }

    //////////////////////////////////////////////////TASK TYPE
    public function getTaskTypes(){
        $taskTypes = DB::table('task_types')->orderBy('id', 'DESC')->paginate(7);

        return Inertia::render('Admin/AdminTaskTypes', [
            'taskTypes' =>  $taskTypes,
        ]);
    }

    public function getTaskTypeDetail($id){
        $taskType = TaskType::where('id', $id)->get();

        return Inertia::render('Admin/AdminTaskTypeDetail', [
            'taskType' =>  $taskType,
        ]);
    }

    public function updateTaskType(TaskTypeRequest $request){
        TaskType::where('id', $request->id)->update([
            'task_type_title' => $request->task_type_title,
        ]);

        return redirect()->back()->with('success_object_update_save', 'Upravené.');
    }

    public function deleteTaskType(Request $request){
        try {
            TaskType::where('id', $request->id)->delete();
        } catch (\Throwable $e) {
            return redirect()->back()->with('unsuccess_object_delete', 'Záznam nie je možné odstrániť');
        }

        return redirect()->back()->with('success_object_delete', 'Odstránené.');
    }

    public function getTaskTypeStorePage(){
        return Inertia::render('Admin/AdminTaskTypeStore');
    }

    public function storeTaskType(TaskTypeRequest $request){
        TaskType::create([
            'task_type_title' => $request->task_type_title,
        ]);

        return redirect()->route('dashboard-get-task-types')->with('success_object_save', 'Uložené.');
    }

    //////////////////////////////////////////////////TASK STATUS
    public function getTaskStatuses(){
        $taskStatuses = DB::table('task_statuses')->orderBy('id', 'DESC')->paginate(7);

        return Inertia::render('Admin/AdminTaskStatuses', [
            'taskStatuses' =>  $taskStatuses,
        ]);
    }

    public function getTaskStatusDetail($id){
        $taskStatus = TaskStatus::where('id', $id)->get();

        return Inertia::render('Admin/AdminTaskStatusDetail', [
            'taskStatus' =>  $taskStatus,
        ]);
    }

    public function updateTaskStatus(TaskStatusRequest $request){
        TaskStatus::where('id', $request->id)->update([
            'task_status_title' => $request->task_status_title,
        ]);

        return redirect()->back()->with('success_object_update_save', 'Uložené.');
    }

    public function deleteTaskStatus(Request $request){
        try {
            TaskStatus::where('id', $request->id)->delete();
        } catch (\Throwable $e) {
            return redirect()->back()->with('unsuccess_object_delete', 'Záznam nie je možné odstrániť');
        }

        return redirect()->back()->with('success_object_delete', 'Odstránené.');
    }

    public function getTaskStatusStorePage(){
        return Inertia::render('Admin/AdminTaskStatusStore');
    }

    public function storeTaskStatus(TaskStatusRequest $request){
        TaskStatus::create([
            'task_status_title' => $request->task_status_title,
        ]);

        return redirect()->route('dashboard-get-task-statuses')->with('success_object_save', 'Uložené.');
    }
    
    //////////////////////////////////////////////////TASK PRIORITY
    public function getTaskPriorities(){
        $taskPriorities = DB::table('task_priorities')->orderBy('id', 'DESC')->paginate(7);

        return Inertia::render('Admin/AdminTaskPriorities', [
            'taskPriorities' =>  $taskPriorities,
        ]);
    }

    public function getTaskPriorityDetail($id){
        $taskPriority = TaskPriority::where('id', $id)->get();

        return Inertia::render('Admin/AdminTaskPriorityDetail', [
            'taskPriority' =>  $taskPriority,
        ]);
    }

    public function updateTaskPriority(TaskPriorityRequest $request){
        TaskPriority::where('id', $request->id)->update([
            'task_priority_title' => $request->task_priority_title,
        ]);

        return redirect()->back()->with('success_object_update_save', 'Upravené.');
    }

    public function deleteTaskPriority(Request $request){
        try {
            TaskPriority::where('id', $request->id)->delete();
        } catch (\Throwable $e) {
            return redirect()->back()->with('unsuccess_object_delete', 'Záznam nie je možné odstrániť');
        }

        return redirect()->back()->with('success_object_delete', 'Odstránené.');
    }

    public function getTaskPriorityStorePage(){
        return Inertia::render('Admin/AdminTaskPriorityStore');
    }

    public function storeTaskPriority(TaskPriorityRequest $request){
        TaskPriority::create([
            'task_priority_title' => $request->task_priority_title,
        ]);

        return redirect()->route('dashboard-get-task-priorities')->with('success_object_save', 'Uložené.');
    }

    //////////////////////////////////////////////////ORDER STATUS
    public function getOrderStatuses(){
        $orderStatuses = DB::table('order_statuses')->orderBy('id', 'DESC')->paginate(7);

        return Inertia::render('Admin/AdminOrderStatuses', [
            'orderStatuses' =>  $orderStatuses,
        ]);
    }

    public function getOrderStatusDetail($id){
        $orderStatus = OrderStatus::where('id', $id)->get();

        return Inertia::render('Admin/AdminOrderStatusDetail', [
            'orderStatus' =>  $orderStatus,
        ]);
    }

    public function updateOrderStatus(OrderStatusRequest $request){
        OrderStatus::where('id', $request->id)->update([
            'order_status_title' => $request->order_status_title,
        ]);

        return redirect()->back()->with('success_object_update_save', 'Upravené.');
    }

    public function deleteOrderStatus(Request $request){
        try {
            OrderStatus::where('id', $request->id)->delete();
        } catch (\Throwable $e) {
            return redirect()->back()->with('unsuccess_object_delete', 'Záznam nie je možné odstrániť');
        }

        return redirect()->back()->with('success_object_delete', 'Odstránené.');
    }

    public function getOrderStatusStorePage(){
        return Inertia::render('Admin/AdminOrderStatusStore');
    }

    public function storeOrderStatus(OrderStatusRequest $request){
        OrderStatus::create([
            'order_status_title' => $request->order_status_title,
        ]);

        return redirect()->route('dashboard-get-order-statuses')->with('success_object_save', 'Uložené.');
    }

    //////////////////////////////////////////////////ORDER PRIORITY
    public function getOrderPriorities(){
        $orderPriorities= DB::table('order_priorities')->orderBy('id', 'DESC')->paginate(7);

        return Inertia::render('Admin/AdminOrderPriorities', [
            'orderPriorities' =>  $orderPriorities,
        ]);
    }

    public function getOrderPriorityDetail($id){
        $orderPriority = OrderPriority::where('id', $id)->get();

        return Inertia::render('Admin/AdminOrderPriorityDetail', [
            'orderPriority' =>  $orderPriority,
        ]);
    }

    public function updateOrderPriority(OrderPriorityRequest $request){
        OrderPriority::where('id', $request->id)->update([
            'order_priority_title' => $request->order_priority_title,
        ]);

        return redirect()->back()->with('success_object_update_save', 'Upravené.');
    }

    public function deleteOrderPriority(Request $request){
        try {
            OrderPriority::where('id', $request->id)->delete();
        } catch (\Throwable $e) {
            return redirect()->back()->with('unsuccess_object_delete', 'Záznam nie je možné odstrániť');
        }

        return redirect()->back()->with('success_object_delete', 'Odstránené.');
    }

    public function getOrderPriorityStorePage(){
        return Inertia::render('Admin/AdminOrderPriorityStore');
    }

    public function storeOrderPriority(OrderPriorityRequest $request){
        OrderPriority::create([
            'order_priority_title' => $request->order_priority_title,
        ]);

        return redirect()->route('dashboard-get-order-priorities')->with('success_object_save', 'Uložené.');
    }

    //////////////////////////////////////////////////MEETING TYPE
    public function getMeetingTypes(){
        $meetingTypes= DB::table('meeting_types')->orderBy('id', 'DESC')->paginate(7);

        return Inertia::render('Admin/AdminMeetingTypes', [
            'meetingTypes' =>  $meetingTypes,
        ]);
    }

    public function getMeetingTypeDetail($id){
        $meetingType = MeetingType::where('id', $id)->get();

        return Inertia::render('Admin/AdminMeetingTypeDetail', [
            'meetingType' =>  $meetingType,
        ]);
    }

    public function updateMeetingType(MeetingTypeRequest $request){
        MeetingType::where('id', $request->id)->update([
            'meeting_type_title' => $request->meeting_type_title,
        ]);

        return redirect()->back()->with('success_object_update_save', 'Upravené.');
    }

    public function deleteMeetingType(Request $request){
        try {
            MeetingType::where('id', $request->id)->delete();
        } catch (\Throwable $e) {
            return redirect()->back()->with('unsuccess_object_delete', 'Záznam nie je možné odstrániť');
        }

        return redirect()->back()->with('success_object_delete', 'Odstránené.');
    }

    public function getMeetingTypeStorePage(){
        return Inertia::render('Admin/AdminMeetingTypeStore');
    }

    public function storeMeetingType(MeetingTypeRequest $request){
        MeetingType::create([
            'meeting_type_title' => $request->meeting_type_title,
        ]);

        return redirect()->route('dashboard-get-meeting-types')->with('success_object_save', 'Uložené.');
    }

    //////////////////////////////////////////////////FORMULA PART
    public function getFormulaParts(){
        $formulaParts= DB::table('formula_part_specifies')->orderBy('id', 'DESC')->paginate(7);

        return Inertia::render('Admin/AdminFormulaParts', [
            'formulaParts' =>  $formulaParts,
        ]);
    }

    public function getFormulaPartDetail($id){
        $formulaPart = FormulaPartSpecify::where('id', $id)->get();

        return Inertia::render('Admin/AdminFormulaPartDetail', [
            'formulaPart' =>  $formulaPart,
        ]);
    }

    public function updateFormulaPart(FormulaPartSpecifyRequest $request){
        FormulaPartSpecify::where('id', $request->id)->update([
            'formula_part_specify_title' => $request->formula_part_specify_title,
        ]);

        return redirect()->back()->with('success_object_update_save', 'Upravené.');
    }

    public function deleteFormulaPart(Request $request){
        try {
            FormulaPartSpecify::where('id', $request->id)->delete();
        } catch (\Throwable $e) {
            return redirect()->back()->with('unsuccess_object_delete', 'Záznam nie je možné odstrániť');
        }

        return redirect()->back()->with('success_object_delete', 'Odstránené.');
    }

    public function getFormulaPartStorePage(){
        return Inertia::render('Admin/AdminFormulaPartStore');
    }

    public function storeFormulaPart(FormulaPartSpecifyRequest $request){
        FormulaPartSpecify::create([
            'formula_part_specify_title' => $request->formula_part_specify_title,
        ]);

        return redirect()->route('dashboard-get-formula-parts')->with('success_object_save', 'Uložené.');
    }

    //////////////////////////////////////////////////DIVISION
    public function getDivisions(){
        $divisions= DB::table('divisions')->orderBy('id', 'DESC')->paginate(7);

        return Inertia::render('Admin/AdminDivisions', [
            'divisions' =>  $divisions,
        ]);
    }

    public function getDivisionDetail($id){
        $division = Division::where('id', $id)->get();

        return Inertia::render('Admin/AdminDivisionDetail', [
            'division' =>  $division,
        ]);
    }

    public function updateDivision(DivisionRequest $request){
        Division::where('id', $request->id)->update([
            'division_title' => $request->division_title,
            'shortcut' => $request->shortcut,
        ]);

        return redirect()->back()->with('success_object_update_save', 'Upravené.');
    }

    public function deleteDivision(Request $request){
        try {
            Division::where('id', $request->id)->delete();
        } catch (\Throwable $e) {
            return redirect()->back()->with('unsuccess_object_delete', 'Záznam nie je možné odstrániť');
        }

        return redirect()->back()->with('success_object_delete', 'Odstránené.');
    }

    public function getDivisionStorePage(){
        return Inertia::render('Admin/AdminDivisionStore');
    }

    public function storeDivision(DivisionRequest $request){
        Division::create([
            'division_title' => $request->division_title,
            'shortcut' => $request->shortcut,
        ]);

        return redirect()->route('dashboard-get-divisions')->with('success_object_save', 'Uložené.');
    }

    //////////////////////////////////////////////////CURRENCY
    public function getCurrencies(){
        $currencies= DB::table('currencies')->orderBy('id', 'DESC')->paginate(7);

        return Inertia::render('Admin/AdminCurrencies', [
            'currencies' =>  $currencies,
        ]);
    }

    public function getCurrencyDetail($id){
        $currency = Currency::where('id', $id)->get();

        return Inertia::render('Admin/AdminCurrencyDetail', [
            'currency' =>  $currency,
        ]);
    }

    public function updateCurrency(CurrencyRequest $request){
        Currency::where('id', $request->id)->update([
            'currency_title' => $request->currency_title,
            'currency_symbol' => $request->currency_symbol,
            'shortcut' => $request->shortcut,
        ]);

        return redirect()->back()->with('success_object_update_save', 'Upravené.');
    }

    public function deleteCurrency(Request $request){
        try {
            Currency::where('id', $request->id)->delete();
        } catch (\Throwable $e) {
            return redirect()->back()->with('unsuccess_object_delete', 'Záznam nie je možné odstrániť');
        }

        return redirect()->back()->with('success_object_delete', 'Odstránené.');
    }

    public function getCurrencyStorePage(){
        return Inertia::render('Admin/AdminCurrencyStore');
    }

    public function storeCurrency(CurrencyRequest $request){
        Currency::create([
            'currency_title' => $request->currency_title,
            'currency_symbol' => $request->currency_symbol,
            'shortcut' => $request->shortcut,
        ]);

        return redirect()->route('dashboard-get-currencies')->with('success_object_save', 'Uložené.');
    }

    //////////////////////////////////////////////////AREA
    public function getAreas(){
        $areas = DB::table('areas')->orderBy('id', 'DESC')->paginate(7);

        return Inertia::render('Admin/AdminAreas', [
            'areas' =>  $areas,
        ]);
    }

    public function getAreaDetail($id){
        $area = Area::where('id', $id)->get();

        return Inertia::render('Admin/AdminAreaDetail', [
            'area' =>  $area,
        ]);
    }

    public function updateArea(AreaRequest $request){
        Area::where('id', $request->id)->update([
            'area_title' => $request->area_title,
        ]);

        return redirect()->back()->with('success_object_update_save', 'Upravené.');
    }

    public function deleteArea(Request $request){
        try {
            Area::where('id', $request->id)->delete();
        } catch (\Throwable $e) {
            return redirect()->back()->with('unsuccess_object_delete', 'Záznam nie je možné odstrániť');
        }

        return redirect()->back()->with('success_object_delete', 'Odstránené.');
    }

    public function getAreaStorePage(){
        return Inertia::render('Admin/AdminAreaStore');
    }

    public function storeArea(AreaRequest $request){
        Area::create([
            'area_title' => $request->area_title,
        ]);

        return redirect()->route('dashboard-get-areas')->with('success_object_save', 'Uložené.');
    }
}
