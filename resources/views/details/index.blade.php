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
              <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{ route('meetings.index') }}" class="btn btn-sm btn-primary">{{ __('return to list') }}</a>
                  </div>
                </div>
                <h1>Details</h1>
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                          {{ __('Description') }}
                      </th>
                      <th>
                        {{ __('Start Time') }}
                      </th>
                      <th >
                        {{ __('Finish Time') }}
                      </th>
                      <th></th>
                    </thead>
                    <tbody>
                    @foreach($details as $detail)
                      <tr>
                        <td style="font-weight:bold">{{$detail->description}}</td>
                        <td>{{$detail->start_time}}</td>
                        <td>{{$detail->finish_time}}</td>
                        <td>
 @if(($meeting->date > date('Y-m-d')) OR ($meeting->date==date('Y-m-d') AND $meeting->start_time > date("H:i:s")))                            @if(!$detail->status)
                            @can('invitor')
                            <a href="{{route('change_status',['detail->id'=>$detail->id])}}" type="button" rel="tooltip" title="Done" class="btn btn-primary btn-link btn-sm">
                              <i class="material-icons"a href="{{route('change_status',['id'=>$detail->id])}}">check_circle_outline</i>
                              </a>
                            @endcan
                            @else {{'This detail is already being discussed'}}
                            @endif
                       @endif
                        </td>
                        @can('invitor')
                            @if($meeting->date==date('Y-m-d')||($meeting->date==date('Y-m-d')&&strtotime($meeting->start_time)>(strtotime(date("H:i:s")))))
                                
                            @endif
                        @endcan
                    </tr>
                        @endforeach






@endsection