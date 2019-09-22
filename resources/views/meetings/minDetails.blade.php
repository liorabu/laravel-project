@extends('layouts.app', ['activePage' => 'meetings', 'titlePage' => __('Min Details')])

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            @canany(['owner', 'admin']) 
              <form method="post" action="{{action('MeetingController@UpdateDetails')}}" autocomplete="off" class="form-horizontal">
              @method('HEAD')
              {{csrf_field()}}
              <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Min Details') }}</h4>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('meetings.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                </div>
                            </div>
                            

                            <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('min details') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('min') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('min') ? ' is-invalid' : '' }}" name="min" id="input-min" type="text" placeholder="{{ __('Min') }}" value="{{ old('min', $min) }}" required="true" aria-required="true"/>
                      @if ($errors->has('min'))
                        <span id="min-error" class="error text-danger" for="input-min">{{ $errors->first('min') }}</span>
                      @endif
                    </div>
                  </div>
                </div>


                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
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