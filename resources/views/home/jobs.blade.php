@extends('layouts.master')

@section('name', 'Video Jobs Dashboard')

@section('content')
    <div class="embed-responsive embed-responsive-1by1">
        <iframe class="embed-responsive-item" src="{{url('/jobs')}}">Your browser isn't compatible</iframe>
    </div>
@endsection