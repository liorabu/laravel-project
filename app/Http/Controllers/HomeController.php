<?php

namespace App\Http\Controllers;
use App\User;
use App\Organization;
use App\Detail;
use App\Join;
use App\Meeting;
use App\Task;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $id=Auth::id();
        $user=User::find($id);
        $role = $user->role;
        $organizations=Organization::all();
             
        if (Auth::user()->org_id!=0){

            if($role=='participator'){

                //All tasks of this participator
                $tasks=Task::where('participator_id',$id)->get();
               

                //All the meetings of this participator
                $meeting_ids=DB::table('meeting_users')->where('user_id',$id)->pluck('meeting_id');  
                $meetings=Meeting::whereIn('id',$meeting_ids)->get();

                if($meetings->count()>0){
                    $details=Detail::rightJoin('meetings','details.meeting_id',"=",'meetings.id')
                    ->select( DB::raw('count(details.id) details , meetings.id') )
                     ->groupBy('meetings.id')->whereIn('meetings.id', $meeting_ids)->get('details');     
                }
                else{
                    $details=NULL; 
                }
                

                //All future meetings of this particiapator
                $next_meetings=Meeting::whereIn('id',$meeting_ids)->where('date',">",date('Y-m-d'))->orwhere(
                    function($query) {
                    $query ->where('date','=',date('Y-m-d'))
                    ->Where('start_time','<',strtotime(date("H:i:s")));
                 })->orderBy('date','asc')->orderBy('start_time','asc')->get();

                //the next future meeting of this particiapator
                $next_meeting=$next_meetings->first();
                
                if($tasks->count()>0){
                    //All tasks that were not done
                    if($open_tasks=$tasks->where('status',0)->count()>0){
                    $open_tasks=Task::where('meeting_id',$meeting_ids)->where('status',0)->orderBy('due_date','asc');
    
                    //the earlier task of this user
                    $earliest_task=Task::where('due_date',$open_tasks->min('due_date'))->get();
                    }
                    else{
                        $earliest_task=NULL;
                    } 
                   
                    $tasks_per_meeting= Task::leftJoin('meetings','tasks.meeting_id','=','meetings.id')
                    ->select( DB::raw('count(tasks.id) tasks , meetings.id') )
                     ->groupBy('meetings.id')->where('participator_id', $id)->get('tasks');     
                }
                else{
                    $open_tasks=NULL;
                    $earliest_task=NULL;
                    $tasks_per_meeting=NULL;
                }
                
            }
            elseif($role=='invitor'){

               //All tasks of this invitor
                $tasks=Task::where('invitor_id',$id)->get();
    
                //All the meetings of this invitor
                $meeting_ids=Meeting::where('invitor_id',$id)->get('id');
                $meetings=Meeting::where('invitor_id',$id)->get();

                if($meetings->count()>0){
                    $details=Detail::rightJoin('meetings','details.meeting_id',"=",'meetings.id')
                    ->select( DB::raw('count(details.id) details , meetings.id') )
                     ->groupBy('meetings.id')->whereIn('meetings.id', $meeting_ids)->get('details');     
                }
                else{
                    $details=NULL; 
                }

                //All future meetings of this invitor
                $next_meetings=Meeting::where('invitor_id',$id)->where('date',">",date('Y-m-d'))->orwhere(
                    function($query) {
                    $query ->where('date','=',date('Y-m-d'))
                    ->Where('start_time','<',strtotime(date("H:i:s")));
                 })->orderBy('date','asc')->orderBy('start_time','asc')->get();

                 //the next future meeting of this invitor
                 $next_meeting=$next_meetings->first();

                 if($tasks->count()>0){
                    //All tasks that were not done
                    if($tasks->where('status',0)->count() > 0){

                         $open_tasks=$tasks->where('status',1)->first();

                         //the earlier task of this invitor
                        $earliest_task=Task::where('due_date',$open_tasks->min('due_date'))->get();

                        $tasks_per_meeting= Task::leftJoin('meetings','tasks.meeting_id','=','meetings.id')
                    ->select( DB::raw('count(tasks.id) tasks , meetings.id') )
                     ->groupBy('meetings.id')->where('tasks.invitor_id', $id)->get('tasks');  
                    }
                    else{
                        $earliest_task=NULL;
                    }  
                }
                else{
                    $open_tasks=NULL;
                    $earliest_task=NULL;
                    $tasks_per_meeting=NULL;
                }
                
            }

            else{

                //All the meetings of this admin
                $meeting_ids=DB::table('meeting_users')->where('user_id',$id)->pluck('meeting_id');  
                $meetings=Meeting::whereIn('id',$meeting_ids)->orderBy('date','asc')->get();

                if($meetings->count()>0){
                    $details=Detail::rightJoin('meetings','details.meeting_id',"=",'meetings.id')
                    ->select( DB::raw('count(details.id) details , meetings.id') )
                     ->groupBy('meetings.id')->whereIn('meetings.id', $meeting_ids)->get('details');     
                }
                else{
                    $details=NULL; 
                }
               
                //All future meetings of this admin
                $next_meetings=Meeting::whereIn('id',$meeting_ids)->where('date',">",date('Y-m-d'))->orwhere(
                    function($query) {
                    $query ->where('date','=',date('Y-m-d'))
                    ->Where('start_time','<',strtotime(date("H:i:s")));
                 })->orderBy('date','asc')->orderBy('start_time','asc')->get();

                //the next future meeting of this admin
                $next_meeting=$next_meetings->first();

                //All tasks for this admin
                $tasks=Task::whereIn('meeting_id',$meeting_ids)->get();


                if($tasks->count()>0){
                    //All tasks that were not done
                    if($open_tasks=$tasks->where('status',0)->count()>0){
                        $open_tasks=Task::whereIn('meeting_id',$meeting_ids)->where('status',0)->orderBy('due_date','asc');

                        //the earlier task of this admin
                        $earliest_task=Task::where('due_date',$open_tasks->min('due_date'))->get();

                        $tasks_per_meeting= Task::leftJoin('meetings','tasks.meeting_id','=','meetings.id')
                        ->select( DB::raw('count(tasks.id) tasks , meetings.id') )
                         ->groupBy('meetings.id')->whereIn('meetings.id',  $meeting_ids)->get('tasks'); 
                    }
                    else{
                        $earliest_task=NULL;
                    } 
                }
                else{
                    $open_tasks=NULL;
                    $earliest_task=NULL;
                    $tasks_per_meeting=NULL;
                } 
                
                if($meetings->count()>0){
                   $meetings_length= $meetings->whereIn('id',$meeting_ids)->get(strtotime('finish_time')-strtotime('start_time'));
                }
                else{
                    $meetings_length=NULL; 
                 }

            }
            
            $organization=Organization::where('org_num',Auth::user()->org_id)->value('org_name');
            $owner=User::where('org_id',Auth::user()->org_id)->where('role','owner')->value('name');

            if($tasks->count()==0){
                $tasks=NULL;
            }
            if($meetings->count()==0){
                $meetings=null;
                $meetings_length=NULL; 
            }

            return view('dashboard',['user'=>$user,'meetings' => $meetings,'next_meetings'=>$next_meetings, 'next_meeting'=> $next_meeting,'tasks'=>$tasks, 'earliest_task'=>$earliest_task, 'organization'=>$organization,'owner'=>$owner,'tasks_per_meeting'=>$tasks_per_meeting,'details'=>$details]);
            
        }
        return view('connect',compact('organizations'));     
    }
    
    public function re(Request $request)
    {
        $join=new Join();
       $user_id=Auth::id();
        $join->id=$user_id;
        $org_id=Organization::where('org_name',$request->organization)->first()->org_num;
        $join->org_id=$org_id;
       $join->save();
       return view('connect');
    }

       




}