@extends('layouts.master')

@section('name', 'Dashboard')
@section('content')

<div class="alert alert-light" role="alert">
    <h4 class="alert-heading">TVCMS Admin</h4>
    <p>This is TVCMS Administration System. Main navigation is using Side Menu on the left.</p>
</div>

@foreach($users as $user)

<div class="alert alert-success" role="alert">
    {{$user->email}} just signed up {{$user->created_at->diffForHumans()}}.
</div>
@endForeach


@endsection



@section('head')
<link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
@stop

@section('script')
<script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
@stop
