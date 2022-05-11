@extends('layouts.master')

@section('name', 'Dashboard')
@section('content')

<div class="alert alert-light" role="alert">
    <h4 class="alert-heading">TVCMS Admin</h4>
    <p>This is TVCMS Administration System. Main navigation is using Side Menu on the left.</p>
</div>

<div class="row">
    <div class="col-sm-6 first-column">
      <h5>Newly registered vendor <a href="{{ route('is_new') }}" class="btn btn-sm btn-primary">VIEW</a></h5>
        @foreach($users as $user)
            <div class="alert alert-secondary" role="alert">
                {{$user->email}} just signed up {{$user->created_at->diffForHumans()}}.
            </div>
        @endForeach
    </div>
    <div class="col-sm-6 second-column">
        <h5>Request for Approval <a href="{{ route('is_pending') }}" class="btn btn-sm btn-primary">VIEW</a></h5>  
        @foreach($requested as $user)
            <div class="alert alert-info" role="alert">
                {{ $user->name ? $user->name : $user->email }} requested {{$user->updated_at->diffForHumans()}}.
            </div>
        @endForeach
    </div> 
  </div>

  <div class="row">
    <div class="col-sm-6 first-column">
      <h5>Approved <a href="{{ route('is_approved') }}" class="btn btn-sm btn-primary">VIEW</a></h5>
        @foreach($approved as $user)
            <div class="alert alert-success" role="alert">
                {{ $user->name ? $user->name : $user->email }} was approved {{$user->updated_at->diffForHumans()}}.
            </div>
        @endForeach
    </div>
    <div class="col-sm-6 second-column">
        <h5>Rejected <a href="{{ route('is_rejected') }}" class="btn btn-sm btn-primary">VIEW</a></h5>
        @foreach($rejected as $user)
            <div class="alert alert-danger" role="alert">
                {{ $user->name ? $user->name : $user->email }} request was rejected {{$user->updated_at->diffForHumans()}}.
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
