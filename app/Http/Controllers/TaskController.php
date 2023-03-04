<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Task;
use App\Models\TaskType;
use App\Models\TaskPriority;
use App\Models\Division;
use App\Models\TaskStatus;
use App\Models\Area;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Task as TaskResource;
use App\Http\Resources\TaskType as TaskTypeResource;
use App\Http\Resources\TaskPriority as TaskPriorityResource;
use App\Http\Resources\TaskStatus as TaskStatusResource;
use App\Http\Resources\Division as DivisionResource;
use App\Http\Resources\Area as AreaResource;


class TaskController extends Controller
{
    public function getModalTaskData(){
        $tasks = Task::where('user_id_assigned', Auth::user()->id)->get(); 
        $taskTypes = TaskType::all();
        $taskPriorities = TaskPriority::all();
        $divisions = Division::all();
        $areas = Area::all();

        return Inertia::render('DashboardTasks', [
            'tasks' =>  response()->json(TaskResource::collection($tasks)),
            'taskTypes' =>  response()->json(TaskTypeResource::collection($taskTypes)),
            'taskPriorities' =>  response()->json(TaskPriorityResource::collection($taskPriorities)),
            'divisions' =>  response()->json(DivisionResource::collection($divisions)),
            'areas' =>  response()->json(AreaResource::collection($areas)),
        ]);
    }

    public function saveNewTask(Request $request){
        Task::create([
            'task_title' => $request->task_title,
            'description' => $request->description,
            'user_id_created' => Auth::user()->id,
            'user_id_assigned' => Auth::user()->id,
            'type_id' => $request->type_id,
            'priority_id' => $request->priority_id,
            'division_id' => $request->division_id,
            'area_id' => $request->area_id,
            'deadline' => $request->deadline,
            // 'attachment',
        ]);

        return redirect()->back()->with('success_task_save', 'uspesny task save');
    }

    public function getTaskDetail($id){
        $users = User::select('id', 'name')->get();
        $task = Task::where('tasks.id', $id)->get();
        $taskTypes = TaskType::all();
        $taskPriorities = TaskPriority::all();
        $taskStatuses = TaskStatus::all();
        $divisions = Division::all();
        $areas = Area::all();
        
        return Inertia::render('DashboardTaskDetail', [
            'users' => $users,
            'task' =>  response()->json(TaskResource::collection($task)),
            'taskTypes' =>  response()->json(TaskTypeResource::collection($taskTypes)),
            'taskPriorities' =>  response()->json(TaskPriorityResource::collection($taskPriorities)),
            'taskStatuses' =>  response()->json(TaskStatusResource::collection($taskStatuses)),
            'divisions' =>  response()->json(DivisionResource::collection($divisions)),
            'areas' =>  response()->json(AreaResource::collection($areas)),
        ]);
    }

    public function updateTask(Request $request){
        Task::where('id', $request->id)->update([
            'description' => $request->description,
            'user_id_assigned' => $request->user_id_assigned,
            'type_id' => $request->type_id,
            'priority_id' => $request->priority_id,
            'division_id' => $request->division_id,
            'status_id' => $request->status_id,
            'area_id' => $request->area_id,
            'deadline' => $request->deadline,
        ]);

        return redirect()->back()->with('success_task_update_save', 'uspesny task update');
    }

    public function getAllTasks(){
        $tasks = Task::join('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
            ->join('users', 'tasks.user_id_assigned', '=', 'users.id')
            ->orderBy('tasks.id', 'desc')
            ->select(['tasks.id' ,'tasks.task_title', 'task_statuses.task_status_title', 'users.name', 'tasks.created_at'])
            ->paginate(5);

        return Inertia::render('DashboardAllTasks', [
            'tasks' =>  $tasks,
        ]);
    }

    public function getSearchedTasks(Request $request){
        $searchedTasks = Task::where('tasks.task_title', 'like', '%' . $request->findTaskString . '%')
        ->join('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
        ->join('users', 'tasks.user_id_assigned', '=', 'users.id')
        ->orderBy('tasks.id', 'desc')
        ->select(['tasks.id' ,'tasks.task_title', 'task_statuses.task_status_title', 'users.name', 'tasks.created_at'])
        ->paginate(5);

        return $searchedTasks;
    }
}
