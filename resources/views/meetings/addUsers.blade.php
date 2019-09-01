@extends('layouts.app', ['activePage' => 'ass-users-to-meeting', 'titlePage' => __('Add Participants')])

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header card-header-tabs card-header-primary">
              <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                  <span class="nav-tabs-title"><h4>Add Participants:</h4></span>
                  <ul class="nav nav-tabs" data-tabs="tabs">
                  </ul>
                </div>
              </div>
            </div>
            <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                          {{ __('Name') }}
                      </th>
                      <th>
                        {{ __('Role') }}
                      </th>
                      @can("invitor")
                      <th></th>
                      @endcan
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->role}}</td>                       
                        @if(DB::table('meeting_users')->where('meeting_id',$meeting_id)->where('user_id',$user->id)->count()>0)                     
                        <td>
                          <a href="{{route('connect_between', [$user->id,$meeting_id])}}" type="button" rel="tooltip" title="remove participator" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons"a href="{{route('connect_between', [$user->id,$meeting_id])}}">clear</i>
                          </a>
                          </td>
                        @else
                        <td>
                          <a href="{{route('connect_between', [$user->id,$meeting_id])}}" type="button" rel="tooltip" title="add participator" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons"a href="{{route('connect_between', [$user->id,$meeting_id])}}">done</i>
                          </a>
                          </td>
                        @endif
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                  <div class="col-md-3 text-left">
                      <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary">{{ __('Add Tasks') }}</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection