<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Task;
use App\Http\Requests\Report as ReportRequest;

class ReportController extends Controller
{
    public function getReports(){
        $reportsTmp = Report::where('user_id', Auth::user()->id)->get();
        $reports = array();

        foreach($reportsTmp as $report){
            $row = array();
            $row['id'] = $report->id;
            $row['title'] = $report->report_title;
            $row['description'] = $report->description;
            $row['user_id'] = $report->user_id;
            $row['task_id'] = $report->task_id;
            $row['start'] = $report->start_time;
            $row['end'] = $report->end_time;
            $row['color'] = $report->color;
            $row['textColor'] = $report->textColor;

            array_push($reports, $row);
        }

        $tasks = Task::all();
        return Inertia::render('DashboardReport', [
            'reports' => $reports,
            'modalTasks' =>  $tasks,
        ]);
    }

    public function storeReport(ReportRequest $request){
        Report::create([
            'report_title' => $request->report_title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'task_id' => $request->task_id,
            'start_time'=> $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('dashboard')->with('success_object_save', 'uspesne report pridanie');
    }

    public function updateReport(ReportRequest $request){
        Report::where('id', $request->id)->update([
            'report_title' => $request->report_title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'task_id' => $request->task_id,
            'start_time'=> $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with('success_object_update_save', 'uspesny report update');
    }

    public function deleteReport(Request $request){
        Report::where('id', $request->id)->delete();

        return redirect()->route('dashboard')->with('success_object_delete', 'uspesny delete');
    }
}
