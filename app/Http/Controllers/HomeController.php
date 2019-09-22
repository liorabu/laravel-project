<?php

namespace App\Http\Controllers;
use App\User;
use App\Organization;
use App\Join;
use\Illuminate\Support\Facades\Auth;
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
        $organizations=Organization::all();
        $role = User::find($id)->role;
        if (Auth::user()->org_id!=0){
            return view('dashboard');
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