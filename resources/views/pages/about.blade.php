@extends('layouts.app')

@section('title') @parent @stop

@section('content')
<div class="row">
    <!--
    <div class="page-header"></div>
    -->
</div>
<div class="row">
    <div class="col-md-12">
        <?php include("appfiles/about.html") ?>
    </div>
</div>
@endsection