<?php

namespace App\Http\Controllers;

use App\User;
use App\Task;
use App\Detail;
use App\Meeting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role= Auth::user()->role;
        $id= Auth::user()->id;
        $org_id=Auth::user()->org_id;

        if($role=="participator")
        {
            $tasks = Task::where('participator_id',  $id)->where('org_id', $org_id)->get();
        }
        else if($role=="invitor")
        {
            $tasks = Task::where('invitor_id',  $id)->where('org_id', $org_id)->get();
        }
        else{
            $tasks=Task::where('org_id', $org_id)->get();   
        }
       
        return view('tasks.index', compact('tasks')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $meeting_id=DB::table('meetings')->where('invitor_id', Auth::user()->id)->max('id');
        $users_in=DB::table('meeting_users')->where('meeting_id',$meeting_id)->pluck('user_id');
        $users=User::whereIn('id',$users_in)->where('role',"participator")->get();

        return view('tasks.create',['users'=>$users,'meeting_id'=>$meeting_id]);
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
            abort(403,"You are not allowed to add a task");
       }
       $id=Auth::user()->id;
       $meeting_id=DB::table('meetings')->where('invitor_id', $id)->max('id');
       $users_in=DB::table('meeting_users')->where('meeting_id',$meeting_id)->pluck("user_id");
       $org_id=Auth::user()->org_id;

        $task = new Task();
        $id = Auth::user()->id;
        $task->description = $request->description;
       // $task->participator_id=User::where('name',$request->participator)->first()->id;
        $task->invitor_id=$id;
        $task->meeting_id=$meeting_id;
        $task->due_date=$request->due_date;
        $task->status = 0;
        $task->org_id=Auth::user()->org_id;
        $task->save();

        $users=User::whereIn('id',$users_in)->where('role',"participator")->get();

        return view('tasks.create',['users'=>$users]);

        
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
        $task = Task::find($id);
        $meeting_id=$task->meeting_id;

        $users_in=DB::table('meeting_users')->where('meeting_id',$meeting_id)->pluck('user_id');
        $participators=User::whereIn('id',$users_in)->where('role',"participator")->get();

        $org_id=Auth::user()->org_id;
        
        return view('tasks.edit',['task'=>$task],['participators'=> $participators]);
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
        $task = Task::findOrFail($id);

        if (Gate::denies('invitor')) {
            abort(403,"You are not allowed to be here");
       }
       if(!$task->invitor_id == Auth::id()) return(redirect('tasks'));
            $id = Auth::id();
            $task->description = $request->description;
            $task->participator_id=User::where('name',$request->participator)->first()->id;
            $task->due_date=$request->due_date;
            $task->save();
            return redirect('tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if (Gate::denies('invitor')) {
            abort(403,"You are not allowed to be here");
       }
       
       $user_id=Auth::user()->id;
       $invitor_id=Task::find($id)->invitor_id;

       if($invitor_id==$user_id){
            $task=Task::find($id);
            $task->delete();
        }
        return redirect ('tasks');
    }

    
    public function update_status( $id)
       {
        if (Gate::denies('participator')) {
            abort(403,"sorry, you do not hold permission update the status");
        }
       $user_id=Auth::user()->id;
        $participator_id=Task::find($id)->participator_id;
        if($user_id==$participator_id ){
            $task = Task::find($id);
            $task->status = 1;
            $task->execution_date = date('Y-m-d'); 
            $task->save();
            return redirect('tasks');
        }
        else{
            abort(403,"sorry, this is not your task");
        }
       }
}


