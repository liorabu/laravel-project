@extends('layouts.app', ['activePage' => 'meetings', 'titlePage' => __('Meetings')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            @can("invitor")
                <form method="post" action="{{action('MeetingController@store')}}" autocomplete="off" class="form-horizontal">
                {{csrf_field()}}
                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('New Meeting') }}</h4>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body ">
                        @if(Session::has('flash_message'))
                            <div class="row">
                                <div class="col-sm-12">
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="material-icons">close</i>
                                    </button>
                                    {{ Session::get('flash_message') }}
                                </div>
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('meetings.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Title') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" id="input-title" type="text" placeholder="{{ __('Title') }}" value="{{ old('name') }}" required="true" aria-required="true"/>
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
                                        <input class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" min=date("Y/m/d")  id="input-date" type="date" placeholder="{{ __('Date') }}" value="{{ old('date') }}" required />
                                        @if ($errors->has('date'))
                                        <span id="date-error" class="error text-danger" for="input-date">{{ $errors->first('date') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary">{{ __('Add Details') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                @endcan
                
            </div>
        </div>
    </div>
</div>
@endsection

