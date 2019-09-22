 @extends('layouts.app', [ 'activePage' => 'home', 'titlePage' => __('Hello '.Auth::user()->name)])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
@if(!(DB::table('joins')->where('id',Auth::id())->count()>0))
<form method="get" action="{{action('HomeController@re')}}"  autocomplete="off" class="form=horizontal">
@csrf

    <div class="card ">
        <div class="card-header card-header-primary">
            <h4 class="card-title">{{ __('Find Your Organization') }}</h4>
            <p class="card-category"></p>
        </div>
        <div class="card-body ">
        <div class="row">
                   
                    <div class="col-sm-7 ">
                        <div class="form-group{{ $errors->has('organization') ? ' has-danger' : '' }}">
                                <select class="form-control{{ $errors->has('organization') ? ' is-invalid' : '' }}" name="organization" id="input-organization" type="text" value="{{ old('organization') }}" required="true" aria-required="true"/>
                                  
                                @foreach($organizations as $org)
                                <option >{{$org->org_name}}</option>
                                @endforeach

                                </select>
                                @if ($errors->has('organization'))
                                  <span id="organization-error" class="error text-danger" for="input-organization">{{ $errors->first('organization') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                          <br>
                          <i class="material-icons">search</i>
                        </div>
                    </div>
                    <div class="card-footer md-auto mr-auto ">
                <button type="submit" class="btn btn-primary">{{ __('Send Request') }}</button>
              </div>
            </div>
          </form>
          @else
          <div class="alert alert-info col-sm-8" role="alert">
             <h4>Your request sent to the organization. Please wait until it will be confirmed.</h4>
        </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection