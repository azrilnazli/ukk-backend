@extends('layouts.master')

@section('title', 'Welcome to RTM e-TVCMS')


@section('content')
    @include('home.general')
    @include('home.users')
    @foreach($tenderDetails as $tender)
        @include('home.tenders')
    @endforeach
    @include('home.proposals')

    @include('home.videos')

@endsection




@section('head')
<link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
@stop

@section('script')
<script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
@stop
