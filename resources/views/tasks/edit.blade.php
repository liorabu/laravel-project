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
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="profile"> 
                    
                    <form method = 'post' action="{{action('TaskController@update', $task->id)}}">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Description') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" id="input-description" type="text" placeholder="{{ __('description') }}" value="{{ old('description', $task->description) }}" required="true" aria-required="true"/>
                      @if ($errors->has('description'))
                        <span id="description-error" class="error text-danger" for="input-description">{{ $errors->first('description') }}</span>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="row">
            <label class="col-sm-2 col-form-label">{{ __('Participator') }}</label>
                <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('participator') ? ' has-danger' : '' }}">
                        <select class="form-control{{ $errors->has('participator') ? ' is-invalid' : '' }}" name="participator" id="input-participator" type="text" value="{{ old('name') }}" required="true" aria-required="true"/>
                        @foreach((DB::table('users')->where('org_id', Auth::user()->org_id)->where('role', "participator")->get()) as $participator)
                        <option>{{$participator->name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('participator'))
                        <span id="participator-error" class="error text-danger" for="input-participator">{{ $errors->first('participator') }}</span>
                        @endif
                    </div>
                </div>
            </div>

                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Due date') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('due_date') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('due_date') ? ' is-invalid' : '' }}" name="due_date" id="input-description" type="date" placeholder="{{ __('due_date') }}" value="{{ old('due_date', $task->due_date) }}" required="true" aria-required="true"/>
                      @if ($errors->has('due_date'))
                        <span id="due_date-error" class="error text-danger" for="input-due_date">{{ $errors->first('due_date') }}</span>
                      @endif
                    </div>
                  </div>
                </div>

               

              
                <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
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