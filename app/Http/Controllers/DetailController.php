<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Meeting;
use App\Detail;
use App\Task;
use App\Organization;
use Session;
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
        $min_details=DB::table('organizations')->where('org_num',$org_id)->value("schedule");
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
      
        session()->forget('flash_message');
        $id = Auth::user()->id;
        $org_id=Auth::user()->org_id;
        $meeting_id=DB::table('meetings')->where('invitor_id', Auth::user()->id)->max('id');
        $users_in=DB::table('meeting_users')->where('meeting_id',$meeting_id)->pluck("user_id");
        $min_details=DB::table('organizations')->where('org_num',$org_id)->value("schedule");


        if($request->start_time>$request->finish_time){
            Session::flash('flash_message', 'The finish time was earlier than the start time. Please enter the detail again');
            return view('details.create',['org_id'=>$org_id,'min_details'=>$min_details,'meeting_id'=>$meeting_id,'invitor'=>$id,'time'=>$request->start_time]);   
        }


        $detail = new Detail();
        $detail->description = $request->description;
        $detail->start_time = $request->start_time;
        $detail->finish_time = $request->finish_time;
        $detail->meeting_id = $meeting_id;
        $detail->invitor_id=$id;
        $detail->save();

        $first_start=Detail::where('meeting_id',$meeting_id)->min('start_time');
        $last_finish=Detail::where('meeting_id',$meeting_id)->max('finish_time');
        Meeting::where('id', $meeting_id)->update( array('start_time'=>$first_start, 'finish_time'=>$last_finish));

        $count_details=Detail::where('meeting_id',$meeting_id)->count();
        if($count_details<$min_details){
            Session::flash('low_message', 'you entered '.$count_details.' details from minimum '.$min_details);
            return view('details.create',['org_id'=>$org_id,'min_details'=>$min_details,'meeting_id'=>$meeting_id,'invitor'=>$id,'time'=>$request->start_time]);  

        }

        
     

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
        $detail=Detail::find($id);

        //current meeting
        $meeting=Meeting::where('id',$detail->meeting_id)->first();

        //over meetings of the invitor for change meeting id to this detail
        $meetings=Meeting::where('invitor_id',Auth::user()->id)->where(  'date','>',date('Y-m-d')) ->orwhere('id',$meeting->id)->orwhere(
            function($query) {
            $query ->where('date','=',date('Y-m-d'))
            ->Where('start_time','<',strtotime(date("H:i:s")));
         })->get();

       $min_details=Organization::where('org_num',Auth::user()->org_id)->value('schedule');

        return view('details.edit',['detail'=>$detail,'meeting'=>$meeting,'meetings'=>$meetings,'min_details'=>$min_details]);
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
        
        $detail=Detail::find($id);
        $current_meeting_id=$detail->meeting_id;


        $detail->meeting_id=Meeting::where('title',$request->meeting)->first()->id;
        $detail->start_time=$request->start_time;
        $detail->finish_time=$request->finish_time;

        
        $first_start=Detail::where('meeting_id',$current_meeting_id)->min('start_time');
        $last_finish=Detail::where('meeting_id',$current_meeting_id)->max('finish_time');
        Meeting::where('id', $current_meeting_id)->update( array('start_time'=>$first_start, 'finish_time'=>$last_finish));
        $detail->save();

        $first_start=Detail::where('meeting_id',$detail->meeting_id)->min('start_time');
        $last_finish=Detail::where('meeting_id',$detail->meeting_id)->max('finish_time');
        Meeting::where('id', $detail->meeting_id)->update( array('start_time'=>$first_start, 'finish_time'=>$last_finish));

        return redirect()->back();
       

        
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
    public function showInfo($id)
    {
        $meeting=Meeting::find($id);
        $details=Detail::where('meeting_id',$id)->get();
        return view('details.showInfo',['meeting'=>$meeting,'details'=>$details]);
    }
    public function change_status($id)
    {
        $detail=Detail::find($id);
        $detail->status=1;
        $detail->save();
       
        
        $meeting=Meeting::where('id', $detail->meeting_id)->first();
        $tasks=Task::all()->where('meeting_id',$meeting->id);
        $details=Detail::all()->where('meeting_id',$meeting->id);
        return view('details.showInfo',['meeting'=>$meeting,'tasks'=>$tasks,'details'=>$details]);


    }
}
