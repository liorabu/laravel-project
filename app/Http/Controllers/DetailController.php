<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Meeting;
use App\Detail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;


class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('invitor')) {
            abort(403,"You are not allowed to add a detail");
        } 
        return view('details.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $id = Auth::user()->id;
        $org_id=Auth::user()->org_id;
        $meeting_id=DB::table('meetings')->where('invitor_id', Auth::user()->id)->max('id');
        $users_in=DB::table('meeting_users')->where('meeting_id',$meeting_id)->pluck("user_id");
        $min_details=DB::table('organizations')->where('org_num',$org_id)->pluck("schedule");

        

        $detail = new Detail();
        $detail->description = $request->description;
        $detail->start_time = $request->start_time;
        $detail->finish_time = $request->finish_time;
        $detail->meeting_id = $meeting_id;
        $detail->invitor_id=$id;
        $detail->save();

        return view('details.create',['org_id'=>$org_id,'min_details'=>$min_details,'meeting_id'=>$meeting_id,'invitor'=>$id,'time'=>$request->start_time]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function add_users(){
        //return view('meetings.index');
        $meeting_id=DB::table('meetings')->where('invitor_id', Auth::user()->id)->max('id');
        $users=DB::table('users')->where('org_id',Auth::user()->org_id)->where('role','!=','invitor')->get();

        return view('meetings.addUsers',['users'=>$users,'meeting_id'=>$meeting_id]);
    }
}
