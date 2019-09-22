@extends('layouts.app', ['activePage' => 'tasks', 'titlePage' => __('Tasks')])

@section('content')

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{action('TaskController@store',['meeting_id'=>$meeting_id])}}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('GET')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('New Task') }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ route('meetings.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Description') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" id="input-description" type="text" placeholder="{{ __('Description') }}" value="{{ old('name') }}" required="true" aria-required="true"/>
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
                        @foreach($users as $participator)
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
                <label class="col-sm-2 col-form-label">{{ __('Due Date') }}</label>
                <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('due_date') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('due_date') ? ' is-invalid' : '' }}" name="due_date" id="input-due_date" type="date" placeholder="{{ __('Due Date') }}" value="{{ old('due_date') }}" required />
                        @if ($errors->has('due_date'))
                        <span id="due_date-error" class="error text-danger" for="input-due_date">{{ $errors->first('due_date') }}</span>
                        @endif
                    </div>
                </div>
            </div>
              
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Add Task') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection