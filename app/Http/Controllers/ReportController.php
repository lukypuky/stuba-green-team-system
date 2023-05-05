<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Task;
use App\Models\User;
use App\Http\Requests\Report as ReportRequest;
use Carbon\Carbon;
use \DateTime;

class ReportController extends Controller
{
    public function getReports(){
        $users = User::where('active', 1)->get();
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
            'users' => $users,
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

        return redirect()->route('dashboard')->with('success_object_save', 'Uložené.');
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

        return redirect()->back()->with('success_object_update_save', 'Upravené.');
    }

    public function deleteReport(Request $request){
        Report::where('id', $request->id)->delete();

        return redirect()->route('dashboard')->with('success_object_delete', 'Odstránené.');
    }

    public function getAllReports(){
        $userIds = array();
        $rows = array();
        $reportDates = array();

        $users = User::select('id','name')->where('active', 1)->get();
        foreach($users as $key => $user){
            array_push($userIds, $user->id);
        }

        $reports = Report::whereIn('user_id', $userIds)
            ->whereMonth('start_time', Carbon::now()->month)
            ->whereYear('start_time', Carbon::now()->year)
            ->orderBy('start_time', 'asc')
            ->get();

        foreach($users as $user){
            $row = array();
            $hour = 0;
            $mins = 0;

            if(!isset($row['username'])){
                $row['username'] = $user->name;
                $row['userId'] = $user->id;
            }

            foreach($reports as $report){
                $reportDate = ['date' => date('d.m.Y', strtotime($report->start_time))];
                array_push($reportDates, $reportDate);

                if($user->id == $report->user_id){
                    $start_time = new DateTime($report->start_time);//start time
                    $end_time = new DateTime($report->end_time);//end time
                    $result = $start_time->diff($end_time);
            
                    $hour += $result->h;
                    $mins += $result->i;
                    
                    $row[date('d.m.Y', strtotime($report->start_time))] = $result->h.'h '.$result->i.'min';
                }
            }

            if(!empty($row)){
                $row['finalTime'] = $hour.'h '.$mins.'min';
                array_push($rows, $row);
            }
        }

        $result = array_unique($reportDates, SORT_REGULAR);
        
        return Inertia::render('DashboardReports', [
            'reportDates' => $result,
            'reportTimes' => $rows,
        ]);
    }

    public function changeReportsMonth(Request $request){
        $userIds = array();
        $rows = array();
        $reportDates = array();

        $users = User::select('id','name')->where('active', 1)->get();
        foreach($users as $key => $user){
            array_push($userIds, $user->id);
        }

        if(is_null($request->reportDate)){
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
        }
        else{
            $tmpDate = explode('-', $request->reportDate);
            $year = $tmpDate[0];
            $month = $tmpDate[1];
        }

        $reports = Report::whereIn('user_id', $userIds)
        ->whereMonth('start_time', $month)
        ->whereYear('start_time', $year)
        ->orderBy('start_time', 'asc')
        ->get();

        foreach($users as $user){
            $row = array();
            $hour = 0;
            $mins = 0;

            if(!isset($row['username'])){
                $row['username'] = $user->name;
                $row['userId'] = $user->id;
            }

            foreach($reports as $report){
                $reportDate = ['date' => date('d.m.Y', strtotime($report->start_time))];
                array_push($reportDates, $reportDate);

                if($user->id == $report->user_id){
                    $start_time = new DateTime($report->start_time);//start time
                    $end_time = new DateTime($report->end_time);//end time
                    $result = $start_time->diff($end_time);
            
                    $hour += $result->h;
                    $mins += $result->i;
                    
                    $row[date('d.m.Y', strtotime($report->start_time))] = $result->h.'h '.$result->i.'min';
                }
            }

            if(!empty($row)){
                $row['finalTime'] = $hour.'h '.$mins.'min';
                array_push($rows, $row);
            }
        }

        $result = array_unique($reportDates, SORT_REGULAR);

        $data = [
            'reportDates' => $result,
            'reportTimes' => $rows,
        ];

        return $data;
    }

    public function changeReportUser(Request $request){
        $reportsTmp = Report::where('user_id', $request->id)->get();
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

        $data = [
            'reports' => $reports,
        ];

        return $data;
    }
}
