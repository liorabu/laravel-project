@extends('layouts.app', ['activePage' => 'meetings', 'titlePage' => __('Meetings')])

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
    <div class="col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header card-header-tabs card-header-primary">
              <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                  <span class="nav-tabs-title"><h4>Meetings:</h4></span>
                  <ul class="nav nav-tabs" data-tabs="tabs">
                  </ul>
                </div>
              </div>
            </div>
            
            @can("invitor")
            <div class="card-body">
              <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{ route('meetings.create') }}" class="btn btn-sm btn-primary">{{ __('New Meeting') }}</a>
                  </div>
                </div>
              @endcan

              @canany(['owner', 'admin']) 
            <div class="card-body">
            
            
              <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{route('minDetails')}}" class="btn btn-sm btn-primary">{{ __('Min Schedule Items') }}</a>
                  </div>
                </div>
              @endcan

             
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                          {{ __('Title') }}
                      </th>
                      <th>
                        {{ __('Invitor name') }}
                      </th>
                      <th >
                        {{ __('Date') }}
                      </th>
                      @can("invitor")
                      <th></th>
                      @endcan
                    </thead>
                    <tbody>

                      @foreach($meetings as $meeting)
                      
                      <tr>
                        <td><a href="{{ route('showInfo', ['meeting_id'=>$meeting->id])}}">{{$meeting->title}}</a></td>
                        <td>{{DB::table('users')->where('id', $meeting->invitor_id)->first()->name}} </td>
                        <td>{{ date('d-M-y', strtotime($meeting->date)) }}</td>
                        @can("invitor")
                        @if($meeting->invitor_id==Auth::user()->id)
                       
                        <td class="td-actions text-left">
                        @if(($meeting->date > date('Y-m-d')) OR ($meeting->date==date('Y-m-d') AND $meeting->start_time > date("H:i:s")))
                          <a href="{{route('meetings.edit', $meeting->id)}}" type="button" rel="tooltip" title="Edit" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                         
                         
                         
                          <form style="display:inline-block;  margin-left:30px"  method='post' action="{{action('MeetingController@destroy', $meeting->id)}}"> 
                              @csrf
                              @method('DELETE')
                              <button type="submit" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                              <i class="material-icons">close</i>
                              </button>
                          </form>

                         
                          @endif
                        </td>  
                           @endcan
                        @endcan 
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
</div>
            

@endsection