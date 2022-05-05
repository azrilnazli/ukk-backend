@extends('layouts.master')

@section('name', 'Dashboard')
@section('content')

<div class="alert alert-light" role="alert">
    <h4 class="alert-heading">TVCMS Admin</h4>
    <p>This is TVCMS Administration System. Main navigation is using Side Menu on the left.</p>
</div>

<div class="row">
    <div class="col-sm-6 first-column">
      <h5>Newly registered vendor</h5>
        @foreach($users as $user)
            <div class="alert alert-secondary" role="alert">
                {{$user->email}} just signed up {{$user->created_at->diffForHumans()}}.
            </div>
        @endForeach
    </div>
    <div class="col-sm-6 second-column">
        <h5>Request for Approval</h5>
        @foreach($requested as $user)
            <div class="alert alert-info" role="alert">
                {{$user->name}} requested {{$user->created_at->diffForHumans()}}.
            </div>
        @endForeach
    </div> 
  </div>

  <div class="row">
    <div class="col-sm-6 first-column">
      <h5>Approved</h5>
        @foreach($approved as $user)
            <div class="alert alert-success" role="alert">
                {{$user->name}} was approved {{$user->created_at->diffForHumans()}}.
            </div>
        @endForeach
    </div>
    <div class="col-sm-6 second-column">
        <h5>Rejected</h5>
        @foreach($rejected as $user)
            <div class="alert alert-danger" role="alert">
                {{$user->name}} request was rejected {{$user->created_at->diffForHumans()}}.
            </div>
        @endForeach
    </div> 
  </div>





@endsection



@section('head')
<link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
@stop

@section('script')
<script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
@stop
