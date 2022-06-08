@extends('layouts.master')

@section('title', 'Scoring Proposal List')


@section('head')
<link href="/css/video-js.css" rel="stylesheet" />
<link href="/css/videojs-hls-quality-selector.css" rel="stylesheet" />
@stop

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
</nav>
@stop



@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h5>NEED STATEMENT</h5>
        </div>    
        <div class="card-item text-right">
        
        </div>
    </div>
   
    <div class="card-body">

        <h2>PDF</h2>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js" integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <div style="height:720px" id="document"></div>
        <script>PDFObject.embed("/pdf/need_statement.pdf", "#document");</script>
    </div>
    <div class="card-footer"></div>
</div>

@stop
