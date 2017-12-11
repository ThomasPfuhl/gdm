@extends('layouts.app')

@section('title') MODEL_NAME {{$record->id}} :: @parent @stop

@section('content')
    
<div class="row">
    <div class="page-header">
        <span style="vertical-align:top;font-size:1.6em;font-weight:bold;padding-right:3em;">MODEL_NAME {{$record->id}} deleted.</span>
    </div>
</div>

@endsection