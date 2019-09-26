@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')

  <div class="content">
    <div class="container-fluid">

      <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">person</i>
              </div>
              <p class="card-category">User</p>
              <h3 class="card-title">{{$user->name}}</h3>
            </div>

            <div class="card-footer">
              <div class="stats">
                <i class="material-icons"></i> role: {{$user->role}}
              </div>
            </div>
          </div>
        </div>

        @if($next_meeting)
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">people_alt</i>
                </div>
                <p class="card-category">Next Meeting</p>
                <h3 class="card-title">{{ $next_meeting->title}}</h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                <i class="material-icons">date_range</i>{{date('d-M-y',strtotime($next_meeting->date))}}
                </div>
              </div>
            </div>
          </div>
        
        @else
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">people_alt</i>
                </div>
                <p class="card-category">Next Meeting</p>
                <h3 class="card-title">No future meetings</h3>
              </div>
              <div class="card-footer">
              </div>
            </div>
          </div>
        
        @endif

        @if($earliest_task)
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">assignment</i>
              </div>
              <p class="card-category">Next task</p>
              <h3 class="card-title">{{$earliest_task->pluck('description')->first()}}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
              <i class="material-icons">date_range</i> {{date('d-M-y',strtotime($earliest_task->pluck("due_date")->first()))}}
              </div>
            </div>
          </div>
        </div>
        
        @elseif($earliest_task=='')
          <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">assignment</i>
              </div>
              <p class="card-category">Next task</p>
              <h3 class="card-title">There are no open tasks</h3>
            </div>
            <div class="card-footer">
            </div>
          </div>
        </div>
        
        @endif

        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
              <i class="material-icons">people</i>
              </div>
              <p class="card-category">Organization</p>
              <h3 class="card-title">{{$organization}}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">person</i> Owner: {{$owner}}
              </div>
            </div>
          </div>
        </div>

      </div>  

      <div class="row">
        <div class="col-md-6">
          <div class="card card-chart">
           @if($meetings)
            <div class="card-body alert-info" >
              <h4 class="card-title">Meetings related to you</h4>
              <p class="card-category">Total Meetings: {{$meetings->count()}}</p>
              <p class="card-category">Meetings Held: {{$meetings->count()-$next_meetings->count()}} , {{number_format(($meetings->count()-$next_meetings->count())/$meetings->count()*100,2)}}%  </p>
              <p class="card-category">Future Meetings: {{$next_meetings->count()}} , {{number_format(($next_meetings->count())/$meetings->count()*100,2)}}%  </p>
            </div>
          @else
            <div class="card-body alert-info" >
            <h4 class="card-title">Meetings related to you</h4>
            <p class="card-category">There are no meetings for you </p>
            </div>
          @endif
          </div>
        </div>
        
        @php
          $delayded_tasks=0;
        @endphp
        @if($tasks)
        @foreach($tasks as $task) 
          @if($task->status==1 AND strtotime($task->execution_date)>strtotime($task->due_date))
              @php
                $delayded_tasks+=1;
              @endphp  
          @endif  
        @endforeach
        @endif  
        
        <div class="col-md-6">
          <div class="card card-chart">
          @if($tasks)
            <div class="card-body alert-info" >
              <h4 class="card-title">Tasks Per Meeting</h4>
              <p class="card-category">Total Tasks: {{$tasks->count()}}</p>
              <p class="card-category">Open Tasks: {{$tasks->where('status',0)->count()}} , {{number_format($tasks->where('status',0)->count()/$tasks->count()*100,2)}}% </p>
              <p class="card-category">Tasks performed on time: {{$tasks->count()-$delayded_tasks-$tasks->where('status',0)->count()}} , {{number_format(($tasks->count()-$delayded_tasks-$tasks->where('status',0)->count())/$tasks->count()*100,2)}}% </p>
              <p class="card-category">Delayed tasks: {{$delayded_tasks}} , {{number_format($delayded_tasks/$tasks->count()*100,2)}}% </p>   
            </div>
            @else
            <div class="card-body alert-info" >
            <h4 class="card-title">Tasks related to you</h4>
            <p class="card-category">There are no tasks for you </p>
            </div>
          @endif
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="card card-chart">
          @if($tasks_per_meeting)
            <div class="card-body alert-info" >
              <h4 class="card-title">Tasks Per Meeting</h4>
              <p class="card-category">Max Tasks Per Meeting: {{$tasks_per_meeting->max('tasks')}}</p>
             
              @if($meetings->count() > $tasks->count('DISTINCT meeting_id')) 
              <p class="card-category">Min Tasks Per Meeting: 0 </p>
              @else
              <p class="card-category">Min Tasks Per Meeting: {{$tasks_per_meeting->min('tasks')}} </p>
              @endif
              <p class="card-category">Average Tasks Per Meeting: {{number_format($tasks->count()/$meetings->count(),2)}}  </p>  
            </div>
            @else
            <div class="card-body alert-info" >
            <h4 class="card-title">Tasks related to you</h4>
            <p class="card-category">There are no tasks for you </p>
            </div>
          @endif
          </div>
        </div>


        @php
          $max_time=0;
          $min_time=10000;
          $longest_meeting=0;
          $shortest_meeting=0;
        @endphp
        @if($meetings)
        @foreach($meetings as $meeting) 
          @if((strtotime($meeting->finish_time )-strtotime($meeting->start_time )) > $max_time)
              @php
                $max_time=strtotime($meeting->finish_time)-strtotime($meeting->start_time);
                $longest_meeting=$meeting;
              @endphp  
          @elseif(strtotime($meeting->finish_time )-strtotime($meeting->start_time ) < $min_time) 
            @php
            $min_time=strtotime($meeting->finish_time)-strtotime($meeting->start_time);
            $shortest_meeting=$meeting;
            @endphp
          @endif
        @endforeach
        @endif 
        @if($details)
        @php
          $max_details=$details->max('details');
          $max_details_meeting=$details->where('details',$max_details)->min('id');
          $max_details_meeting= $meetings->where('id',$max_details_meeting);

          $min_details=$details->min('details');
          $min_details_meeting=$details->where('details',$min_details)->min('id');
          $min_details_meeting= $meetings->where('id',$min_details_meeting);
        
        @endphp 
        @endif

        <div class="col-md-6">
          <div class="card card-chart">
          @if($meetings)
            <div class="card-body alert-info" >
              <h4 class="card-title">Meeting Details</h4>
              <p class="card-category">The longest meeting: {{$longest_meeting->title}} </p>
              <p class="card-category">The shortest meeting: {{$shortest_meeting->title}} </p>
              <p class="card-category">The meeting with the most meeting details: {{$max_details_meeting->first()->title}} </p>
              <p class="card-category">The meeting with the least meeting details: {{$min_details_meeting->first()->title}} </p>
              
            </div>
            @else
            <div class="card-body alert-info" >
            <h4 class="card-title">Tasks related to you</h4>
            <p class="card-category">There are no tasks for you </p>
            </div>
          @endif
          </div>
        </div>


    </div>

      <!--div class="row">
        <div class="col-lg-6 col-md-12">
          <div class="card">
            <div class="card-header card-header-tabs card-header-primary">
              <div class="nav-tabs-navigation"> 
                <div class="nav-tabs-wrapper">
                <h4> <span  class="nav-tabs-title">Tasks:</span> 
                  <ul class="nav nav-tabs" data-tabs="tabs"> </h4>
                  </ul>
                </div>
              </div>
            </div>

            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="profile">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="" >
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>

                        <td>Sign contract for "What are conference organizers afraid of?"</td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>

                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>

                        <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                        </td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="" >
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td>Create 4 Invisible User Experiences you Never Knew About</td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <div class="card">
            <div class="card-header card-header-warning">
              <h4 class="card-title">Employees</h4>
              <p class="card-category">List of employees </p>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-hover">
                <thead class="text-warning">
                  <th>ID</th>
                  <th>Name</th>
                  <th>Rule</th>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Dakota Rice</td>
                    <td>Owner</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Minerva Hooper</td>
                    <td>Admin</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Sage Rodriguez</td>
                    <td>$Invites the meeting</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Philip Chaney</td>
                    <td>Participant</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div-->
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush