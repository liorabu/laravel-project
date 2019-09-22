<?php



namespace App\Http\Controllers;
use App\Join;
use App\ User;
use App\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class JoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $joins=Join::all();
        $users=User::all();
        $organizations=Organization::all();
       return view("requests.index",compact('joins','users','organizations'));

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
        //
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
    public function destroy($userid)
    {
        $join=Join::find($userid);
        $join->delete();
        return redirect ('requests');


    }
    public function status($id,$status,$org_id)
    {
        $join=Join::find($id);
        $status=!($status);
        $join->status=$status;
        $user=User::find($id);
        $user->org_id=$org_id;
        $join->delete();
        $user->save();
        return redirect ('requests');
    }  
}