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
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="profile"> 
                    
                    <form method = 'post' action="{{action('MeetingController@update', $meeting->id)}}">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Title') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" id="input-title" type="text" placeholder="{{ __('title') }}" value="{{ old('title', $meeting->title) }}" required="true" aria-required="true"/>
                      @if ($errors->has('title'))
                        <span id="title-error" class="error text-danger" for="input-title">{{ $errors->first('title') }}</span>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Date') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('date') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="input-description" type="date" placeholder="{{ __('date') }}" value="{{ old('date', $meeting->date) }}" required="true" aria-required="true"/>
                      @if ($errors->has('date'))
                        <span id="date-error" class="error text-danger" for="input-date">{{ $errors->first('date') }}</span>
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
    </div>
  </div>
</div>

@endsection