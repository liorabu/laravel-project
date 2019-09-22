<?php

namespace App\Http\Controllers;

use App\User;
use App\Meeting;
use App\Detail;
use App\Task;
use App\Organization;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;


use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $org_id=Auth::user()->org_id;
        $user_id=Auth::user()->id;
        $role=Auth::user()->role;
        if($role=="invitor")
        {
            $meetings=Meeting::where('org_id',$org_id)->where('invitor_id',$user_id)->orderBy('date', 'asc')->get();
        }
        else
        {
            $meeting_id=DB::table('meeting_users')->where('user_id', $user_id)->pluck('meeting_id');
            $meetings=Meeting::where('org_id',$org_id)->whereIn('id',$meeting_id)->orderBy('date', 'asc')->get();
        }
        
        $last_meeting_id=Meeting::where('org_id',$org_id)->where('invitor_id',$user_id)->orderBy('id','Desc')->max('id');
        
        
      $last_meeting=Meeting::where('id',$last_meeting_id)->get();

       
        $schedule_last_update=Organization::where('org_num',$org_id)->pluck('schedule_update');

        $min_details=Organization::where('org_num',$org_id)->pluck("schedule");

        $num_of_details = Detail::rightJoin('meetings', 'details.meeting_id', '=', 'meetings.id')
          ->select( DB::raw('count(details.id) row , meetings.id') )
           ->groupBy('meetings.id')->where('meetings.id', $last_meeting_id)->pluck('row');

          
            
      if($last_meeting->pluck('created_at') > $schedule_last_update AND $num_of_details < $min_details){
      
    return $this->destroy($last_meeting_id);
   }
    return view('meetings.index',['meetings'=>$meetings]);     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('invitor')) {
            abort(403,"You are not allowed to add a meeting");
        } 
        return view('meetings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('invitor')) {
            abort(403,"You are not allowed to add a meeting");
       }

       $meeting = new Meeting();
        $id = Auth::id();
        $org_id=Auth::user()->org_id;
        $meeting->title = $request->title;
        $meeting->invitor_id = $id;
        $meeting->date = $request->date;
        $meeting->org_id=$org_id;

        if($request->date<date('Y-m-d')){
            Session::flash('flash_message', 'The date has already passed.');
            return view('meetings.create');
        }
        $meeting->save();
       $users_in=DB::table('meeting_users')->where('meeting_id',$meeting->id)->pluck("user_id");
       $min_details=DB::table('organizations')->where('org_num',$org_id)->value("schedule");
      
      return view('details.create',['org_id'=>$org_id,'meeting_id'=>$meeting->id,'min_details'=>$min_details,'invitor'=>$id,'users_in'=>$users_in]);

    
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
        if (Gate::denies('invitor')) {
            abort(403,"You are not allowed to be here");
        }

        $meeting = Meeting::find($id);
        $org_id=Auth::user()->org_id;

        $users_id=DB::table('meeting_users')->where('meeting_id', $id)->pluck('user_id');
        $users=DB::table('users')->whereIn('id', $users_id)->get();
        return view('meetings.edit',['meeting'=>$meeting],['users'=>$users]);
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
        $meeting = Meeting::findOrFail($id);
        if (Gate::denies('invitor')) {
           if($meeting->invitor_id!=Auth::user()->id)
                abort(403,"You are not allowed to edit this meeting");
       } 
       $meeting->update($request->except(['_token']));
       return redirect('meetings'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $meeting=Meeting::find($id);
       $meeting->delete();
       //$meetings=DB::table('meeting_users')->where('meeting_id', $id)->delete();
       $details=Detail::where('meeting_id', $id)->delete();
       $tasks=Task::where('meeting_id', $id)->delete();
       return redirect('meetings');
    }

    public function show_users(){


    }

    public function connect_between($user_id,$meeting_id){ 
        $users_in=DB::table('meeting_users')->where('meeting_id',$meeting_id)->where('user_id',$user_id)->count();
        if($users_in>0)
        {       
            DB::table('meeting_users')->where('meeting_id',$meeting_id)->where('user_id',$user_id)->delete();
        }
        else{       
            DB::table('meeting_users')->insert(
                ['meeting_id' => $meeting_id, 'user_id' => $user_id]
            );   
        }
        $org_id=Auth::user()->org_id;
        
        $meeting_id=DB::table('meetings')->where('invitor_id', Auth::user()->id)->max('id');
        $users=DB::table('users')->where('org_id',Auth::user()->org_id)->where('role','!=','invitor')->get();
        $users_new=DB::table('meeting_users')->where('meeting_id',$meeting_id)->pluck("user_id");
        return view('meetings.addUsers',['invitor'=>Auth::user(),'users_in'=>$users_new,'org_id'=>$org_id,'meeting_id'=>$meeting_id,'users'=>$users]);
    }
    public function minDetails(){
        $id=Auth::id();
        $org_num=User::where('id',$id)->value('org_id');
        $min=Organization::where('org_num',$org_num)->value('schedule');
        return view('meetings.minDetails',['org_num'=>$org_num,'min'=>$min]);
    }


    public function UpdateDetails(Request $request){ 
        $id=Auth::id();
        $org_num=User::where('id',$id)->value('org_id');
        $min=$request->min;



        DB::table('organizations')
            ->where('org_num', $org_num)
           ->update(['schedule' => $min,'schedule_update'=>now()]);
           return redirect('meetings');

    }

    
}
