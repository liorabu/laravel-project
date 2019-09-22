@extends('layouts.app', ['activePage' => 'meetings', 'titlePage' => __('Meetings')])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ action('DetailController@update', $detail->id) }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Edit Detail') }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body ">
                    
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ route('showInfo',['meeting_id'=>$meeting->id]) }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                  </div>
                </div>

                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Description') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" id="input-description" type="text" placeholder="{{ __('Description') }}" value="{{ old('description', $detail->description) }}" required="true" aria-required="true"/>
                      @if ($errors->has('description'))
                        <span id="description-error" class="error text-danger" for="input-description">{{ $errors->first('description') }}</span>
                      @endif
                    </div>
                  </div>
                </div>

                
               @if(DB::table('details')->where('meeting_id',$meeting->id)->count() > $min_details)
                    <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Meeting') }}</label>
                    <div class="col-sm-7">
                        <div class="form-group{{ $errors->has('meeting') ? ' has-danger' : '' }}">
                                <select class="form-control{{ $errors->has('meeting') ? ' is-invalid' : '' }}" name="meeting" id="input-meeting" type="text" value="{{ old('meeting') }}" required="true" aria-required="true"/>
                                @foreach($meetings as $newMeeting)
                                <option {{$meeting->id==$newMeeting->id ? 'selected': ''}}>{{$newMeeting->title}}</option>
                                @endforeach
                                </select>
                                @if ($errors->has('meeting'))
                                  <span id="meeting-error" class="error text-danger" for="input-meeting">{{ $errors->first('meeting') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                

                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Start Time') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('start_time') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('start_time') ? ' is-invalid' : '' }}" name="start_time" id="input-description" type="time" placeholder="{{ __('Start Time') }}" value="{{ old('start_time',$detail->start_time) }}" required="true" aria-required="true"/>
                        @if ($errors->has('start_time'))
                            <span id="start_time-error" class="error text-danger" for="input-start_time">{{ $errors->first('start_time') }}</span>
                        @endif
                    </div>
                </div>
            </div>
                            
            <div class="row">
                <label class="col-sm-2 col-form-label">{{ __('Finish Time') }}</label>
                <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('finish_time') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('finish_time') ? ' is-invalid' : '' }}" name="finish_time" id="input-description" type="time" placeholder="{{ __('Finish Time') }}" value="{{ old('finish_time',$detail->finish_time) }}" required="true" aria-required="true"/>
                        @if ($errors->has('finish_time'))
                            <span id="finish_time-error" class="error text-danger" for="input-finish_time">{{ $errors->first('finish_time') }}</span>
                        @endif
                    </div>
                </div>
            </div>

                <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

