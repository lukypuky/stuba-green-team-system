<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Report;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Report as ReportResource;
use App\Http\Resources\Task as TaskResource;

class CalendarController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $reports = Report::where('user_id', Auth::user()->id)->get();
        $tasks = Task::all();
        return Inertia::render('DashboardReport', [
            'reports' => response()->json(ReportResource::collection($reports)),
            'modalTasks' =>  response()->json(TaskResource::collection($tasks)),
        ]);
    }
}
