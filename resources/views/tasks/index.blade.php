@extends('layouts.app', ['activePage' => 'tasks', 'titlePage' => __('Tasks')])

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
    <div class="col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header card-header-tabs card-header-primary">
              <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                  <span class="nav-tabs-title"><h4>Tasks:</h4></span>
                  <ul class="nav nav-tabs" data-tabs="tabs">
                  </ul>
                </div>
              </div>
            </div>
            
            @can("invitor")
            <div class="card-body">
              <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary">{{ __('New Task') }}</a>
                  </div>
                </div>
              @endcan

                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                          {{ __('Description') }}
                      </th>
                      <th>
                        {{ __('Participator name') }}
                      </th>
                      <th>
                        {{ __('Invitor name') }}
                      </th>
                      <th >
                        {{ __('Due date') }}
                      </th>
                      <th></th>
                    </thead>
                    <tbody>

                      @foreach($tasks as $task)
                      <tr>
                        <td>{{$task->description}}</td>
                        <td>{{DB::table('users')->where('id', $task->participator_id)->first()->name}} </td>
                        <td>{{DB::table('users')->where('id', $task->invitor_id)->first()->name}} </td>
                        <td>{{ date('d-M-y', strtotime($task->due_date)) }}</td>
                       
                       @if(!$task->status)
                       @can("participator")
                       <td class="td-actions text-right">
                       <a href="{{route('update_status', [ $task->id])}}" type="button" rel="tooltip" title="Done" class="btn btn-primary btn-link btn-sm">
                       <i class="material-icons"a href="{{route('update_status', [ $task->id])}}">check_circle_outline</i>
                       </a>
                       @endcan
                       @can("invitor")
                       <td class="td-actions text-left">
                          <a href="{{route('tasks.edit', $task->id, $task->invitor_id)}}" type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                          <i class="material-icons">edit</i>
                          </button>
                      
                          
                          <form style="display:inline-block;  margin-left:30px"  method='post' action="{{action('TaskController@destroy', $task->id)}}"> 
                              @csrf
                              @method('DELETE')
                              <button type="submit" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                              <i class="material-icons">close</i>
                              </button>
                          </form>
                           </td>
                          @endcan 

                          @canany(['owner', 'admin']) 
                       <td class="td-actions text-left">
                            Task in process
                           </td>
                          @endcan

                        @else
                            @if(strtotime($task->execution_date)>strtotime($task->due_date))
                            <td style="color:red;font-weight:bold">
                                <i class="material-icons">warning</i>
                              The task was delayed
                               </td>
                            @else
                              <td class="td-actions text-left">
                                <i class="material-icons">done</i>
                              </td> 
                            @endif
                         @endif                        
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
</div>
@endsection
