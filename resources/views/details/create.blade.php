@extends('layouts.app', ['activePage' => 'add detail', 'titlePage' => __('Add Detail')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{action('DetailController@store')}}" autocomplete="off" class="form-horizontal">
                {{csrf_field()}}
                <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('New Detail') }}</h4>
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
                            @if(Session::has('low_message'))
                            <div class="row">
                                <div class="col-sm-12">
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="material-icons">close</i>
                                    </button>
                                    {{ Session::get('low_message') }}
                                </div>
                                </div>
                            </div>
                        @endif         
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Description') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" id="input-description" type="text" placeholder="{{ __('Description') }}" value="{{ old('description') }}" required="true" aria-required="true"/>
                                        @if ($errors->has('description'))
                                            <span id="description-error" class="error text-danger" for="input-description">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <label class="col-sm-2 col-form-label">{{ __('Start Time') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('start_time') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('start_time') ? ' is-invalid' : '' }}" name="start_time" id="input-description" type="time" placeholder="{{ __('Start Time') }}" value="{{ old('start_time') }}" required="true" aria-required="true"/>
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
                                        <input class="form-control{{ $errors->has('finish_time') ? ' is-invalid' : '' }}" name="finish_time" id="input-description" type="time" placeholder="{{ __('Finish Time') }}" value="{{ old('finish_time') }}" required="true" aria-required="true"/>
                                        @if ($errors->has('finish_time'))
                                            <span id="finish_time-error" class="error text-danger" for="input-finish_time">{{ $errors->first('finish_time') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <span class="td-actions text-left">
                                <button type="submit" class="btn btn-primary">{{ __('Add Detail') }}</button>
                                                          
                           </span> 
                           
                           @if(!(DB::table('details')->where('meeting_id',$meeting_id)->count()<$min_details))
                           <span class="td-actions text-right">
                        
                                <a href="{{route('add_users')}}"  class=" btn btn-primary ">add participants</a>
                                </span>
                                @endif 

                                       
                       </div>
                    </div>
                   
                </form>
               
                
            </div>
        </div>
    </div>
</div>
@endsection