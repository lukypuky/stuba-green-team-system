<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Http\Requests\Report as ReportRequest;
use App\Http\Resources\Report as ReportResource;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::where('user_id', Auth::user()->id)->get();
        return response()->json(ReportResource::collection($reports));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Report::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'user_id' => $request->get('user_id'),
            // 'task_id' => $request->get('task_id'),
            'start_time'=> $request->get('start_time'),
            'end_time' => $request->get('end_time'),
            // 'booked_by' => (Auth::user()->is_admin ? $request->get('user_id') : $request->get('user_id')),
        ]);

        return redirect()->back()->with('success_report_save', 'uspesne pridanie');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Report::where('id', $request->get('id'))->update([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'user_id' => $request->get('user_id'),
            'start_time'=> $request->get('start_time'),
            'end_time' => $request->get('end_time'),
        ]);

        return redirect()->back()->with('success_report_update_save', 'uspesny update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Report::where('id', $id)->delete();

        return redirect()->back()->with('success_report_delete', 'uspesny delete');
    }
}
