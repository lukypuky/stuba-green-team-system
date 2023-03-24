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
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Task as TaskRequest;

class TaskController extends Controller
{
    public function getModalTaskData(){
        $tasks = Task::where('user_id_assigned', Auth::user()->id)->get(); 
        $taskTypes = TaskType::all();
        $taskPriorities = TaskPriority::all();
        $divisions = Division::all();
        $areas = Area::all();

        return Inertia::render('DashboardTasks', [
            'tasks' =>  $tasks,
            'taskTypes' =>  $taskTypes,
            'taskPriorities' =>  $taskPriorities,
            'divisions' =>  $divisions,
            'areas' =>  $areas,
        ]);
    }

    public function storeNewTask(TaskRequest $request){
        Task::create([
            'task_title' => $request->task_title,
            'description' => $request->description,
            'user_id_created' => Auth::user()->id,
            'user_id_assigned' => Auth::user()->id,
            'type_id' => $request->type_id,
            'task_priority_id' => $request->task_priority_id,
            'division_id' => $request->division_id,
            'area_id' => $request->area_id,
            'deadline' => $request->deadline,
            // 'attachment',
        ]);

        return redirect()->back()->with('success_object_save', 'uspesny task save');
    }

    public function getTaskDetail($id){
        $users = User::select('id', 'name')->get();
        $task = Task::where('tasks.id', $id)->get();
        $taskTypes = TaskType::all();
        $taskPriorities = TaskPriority::all();
        $taskStatuses = TaskStatus::all();
        $divisions = Division::all();
        $areas = Area::all();

        $comments = Comment::where('comments.task_id', $id)
        ->join('users', 'comments.user_id', '=', 'users.id')
        ->orderBy('comments.id', 'asc')
        ->select(['comments.id', 'users.name', 'comments.comment_body', 'comments.created_at'])
        ->get();
        
        return Inertia::render('DashboardTaskDetail', [
            'users' => $users,
            'task' =>  $task,
            'taskTypes' =>  $taskTypes,
            'taskPriorities' =>  $taskPriorities,
            'taskStatuses' =>  $taskStatuses,
            'divisions' =>  $divisions,
            'areas' =>  $areas,
            'comments' => $comments,
        ]);
    }

    public function updateTask(TaskRequest $request){
        Task::where('id', $request->id)->update([
            'description' => $request->description,
            'user_id_assigned' => $request->user_id_assigned,
            'type_id' => $request->type_id,
            'task_priority_id' => $request->task_priority_id,
            'division_id' => $request->division_id,
            'status_id' => $request->status_id,
            'area_id' => $request->area_id,
            'deadline' => $request->deadline,
        ]);

        return redirect()->back()->with('success_object_update_save', 'uspesny task update');
    }

    public function getAllTasks(){
        $tasks = Task::join('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
            ->join('users', 'tasks.user_id_assigned', '=', 'users.id')
            ->orderBy('tasks.id', 'desc')
            ->select(['tasks.id' ,'tasks.task_title', 'task_statuses.task_status_title', 'users.name', 'tasks.created_at'])
            ->paginate(7);

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
        ->paginate(7);

        return $searchedTasks;
    }

    public function deleteTask(Request $request){
        Comment::where('task_id', $request->id)->delete();
        Task::where('id', $request->id)->delete();
        
        return redirect()->route('dashboard-tasks')->with('success_object_delete', 'uspesny task delete');
    }

    public function storeComment(Request $request){
        Comment::create([
            'user_id' => Auth::user()->id,
            'task_id' => $request->task_id,
            'comment_body' => $request->comment_body,
        ]);

        return redirect()->back();
    }
}
