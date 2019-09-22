@extends('layouts.app', ['activePage' => 'requests', 'titlePage' => __('User Requests')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('Requests') }}</h4>
                <p class="card-category"> {{ __('Here you can manage user requests') }}</p>
              </div>
              <div class="card-body">
            
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th class="col-md-3">
                          {{ __('user name') }}
                      </th>
                      <th class="col-md-3">
                        {{ __('organization name') }}
                      </th>
                      <th class="col-md-3">
                      </th>
                      <th class="col-md-3">
                      </th>

        
                      @foreach($joins as $join)
                
                      <?php
                        $userp = DB::table('users')->where('id',$join->id)->first();
                        $username = $userp->name;
                        $org = DB::table('organizations')->where('org_num',$join->org_id)->first();
                        $orgname = $org->org_name;
                        ?>
                 
                    </thead>
                    <tbody>
                    
                        <tr>
                          <td>
                         
                          {{$username}}
                          </td>
                          <td>
                          
                         {{$orgname}}
                          </td>
                          <td class="td-actions text-right">
                          <a class="btn btn-success " href="{{route('status', ['id'=>$join->id,'status'=>$join->status,'org_id'=>$join->org_id])}}">confirm</a>
                            </td>
                          <td class="td-actions text-left">
                          <form  method='post' action="{{action('JoinController@destroy',$join->id)}}">
                            @csrf
                            @method('DELETE')

                    
                           
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Delete"> 
                            
                            </form>
                           </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
               
                 
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
    
                                
                          
@endsection