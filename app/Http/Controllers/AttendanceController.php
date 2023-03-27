<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Meeting;
use App\Models\MeetingUser;
use App\Models\MeetingType;
use App\Models\AttendanceStatus;
use App\Models\Division;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Meeting as MeetingRequest;
use \DateTime;

class AttendanceController extends Controller
{
    public function getAttendance(){
        $meetingIds = array();
        $rows = array();

        $users = User::select('id','name')->where('active', 1)->get();
        $divisions = Division::all();
        $meetingTypes = MeetingType::all();
        $attendanceStatuses = AttendanceStatus::all();
        $meetingDate = Carbon::now()->year.'-'.Carbon::now()->month;
        $meetings = $this->getMeetingsQuery(1, null, $meetingDate);

        foreach($meetings as $key => $meeting){
            array_push($meetingIds, $meeting->id);
        }
        
        $attendances = MeetingUser::whereIn('meeting_id', $meetingIds)
            ->join('users', 'meeting_users.user_id', '=', 'users.id')
            ->join('meetings', 'meeting_users.meeting_id', '=', 'meetings.id')
            ->select(['meeting_users.attendance_status_id', 'users.name', 'users.id', 'meetings.meeting_date'])
            ->get();

        foreach($users as $user){
            $row = array();
            $count = 0;
 
            foreach($attendances as $attendance){
                if($user->name == $attendance->name){
                    if(!isset($row['username'])){
                        $row['username'] = $attendance->name;
                        $row['userId'] = $attendance->id;
                    }
                    $tmp = $attendance->meeting_date;
                    $date = strtotime($tmp);
                    $row[ date('d.m.Y', $date)] = $attendance->attendance_status_id;
                    
                    if($attendance->attendance_status_id == 1){
                        $count++;
                    }
                    elseif($attendance->attendance_status_id == 3){
                        $count--;
                    }
                }
            }
            
            if(!empty($row)){
                $row['body'] = $count;
                array_push($rows, $row);
            }
        }

        return Inertia::render('DashboardAttendance',[
            'users' => $users,
            'meetingDates' => $meetings,
            'attendances' => $rows,
            'meetingTypes' => $meetingTypes,
            'divisions' => $divisions,
            'attendanceStatuses' => $attendanceStatuses,
        ]);
    }

    public function getMeetingsQuery($meetingType, $divisionId, $meetingDate){
        if(is_null($meetingDate)){
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
        }
        else{
            $tmpDate = explode('-', $meetingDate);
            $year = $tmpDate[0];
            $month = $tmpDate[1];
        }

        $meetings = Meeting::whereMonth('meetings.meeting_date', $month)
            ->whereYear('meetings.meeting_date', $year)
            ->where('meetings.meeting_type_id', $meetingType)
            ->where('meetings.division_id', $divisionId) 
            ->join('meeting_types', 'meetings.meeting_type_id', '=', 'meeting_types.id')
            ->select(['meetings.id', 'meetings.meeting_date'])
            ->orderBy('meetings.meeting_date', 'asc')
            ->get();
        
        return $meetings;
    }

    public function changeMeetingType(Request $request){
        $meetingIds = array();
        $rows = array();
        $meetingTypeId = $request->meetingTypeId;

        if($meetingTypeId == 3){
            $users = User::select('id','name')->where('active', 1)->where('role_id', 1)->orWhere('role_id', 2)->get();
        }
        elseif(!is_null($request->divisionId)){
            $users = User::select('id','name')->where('active', 1)->where('division_id', $request->divisionId)->get();
        }
        else{
            $users = User::select('id','name')->where('active', 1)->get();
        }

        $divisions = Division::all();
        $meetingTypes = MeetingType::all();

        if(is_null($meetingTypeId)){
            $meetingTypeId = 1;
        }
        $meetings = $this->getMeetingsQuery($meetingTypeId, $request->divisionId, $request->meetingDate);

        foreach($meetings as $key => $meeting){
            array_push($meetingIds, $meeting->id);
        }
        
        $attendances = MeetingUser::whereIn('meeting_id', $meetingIds)
            ->join('users', 'meeting_users.user_id', '=', 'users.id')
            ->join('meetings', 'meeting_users.meeting_id', '=', 'meetings.id')
            ->select(['meeting_users.attendance_status_id', 'users.name', 'users.id', 'meetings.meeting_date'])
            ->get();

        foreach($users as $user){
            $row = array();
            $count = 0;
 
            foreach($attendances as $attendance){
                if($user->name == $attendance->name){
                    if(!isset($row['username'])){
                        $row['username'] = $attendance->name;
                        $row['userId'] = $attendance->id;
                    }

                    $tmp = $attendance->meeting_date;
                    $date = strtotime($tmp);
                    $row[ date('d.m.Y', $date)] = $attendance->attendance_status_id;
                    
                    if($attendance->attendance_status_id == 1){
                        $count++;
                    }
                    elseif($attendance->attendance_status_id == 3){
                        $count--;
                    }
                }
            }
            
            if(!empty($row)){
                $row['body'] = $count;
                array_push($rows, $row);
            }
        }

        $data = [
            'users' => $users,
            'meetingDates' => $meetings,
            'attendances' => $rows,
            'meetingTypes' => $meetingTypes,
            'divisions' => $divisions,
        ];

        return $data;
    }

    public function storeAttendance(MeetingRequest $request){
        $meeting = new Meeting();
        $meeting->meeting_date = $request->meeting_date;
        $meeting->meeting_type_id = $request->meeting_type_id;
        $meeting->division_id= $request->division_id;
        $meeting->save();

        foreach($request->attendance as $value){
            MeetingUser::create([
                'attendance_status_id' => $value['attendance_status_id'],
                'user_id' => $value['user_id'],
                'meeting_id' => $meeting->id,
            ]);
        }

        return redirect()->back()->with('success_object_save', 'Uložené');
    }

    public function updateAttendance(Request $request){
        foreach($request->attendance as $value){
            MeetingUser::where('meeting_id', $request->meeting_id)->where('user_id', $value['user_id'])->update([
                'attendance_status_id' => $value['attendance_status_id'],
            ]);
        }

        return redirect()->back()->with('success_object_update_save', 'Upravené');
    }

    public function deleteAttendance(Request $request){
        MeetingUser::where('meeting_id', $request->meeting_id)->delete();
        Meeting::where('id', $request->meeting_id)->delete();
        
        redirect()->back()->with('success_object_delete', 'Odstránené');
    }
}
