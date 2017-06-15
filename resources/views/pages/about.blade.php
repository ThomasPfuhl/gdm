@extends('layouts.app')
@section('title') About :: @parent @stop
@section('content')
<div class="row">
    <!--
<div class="page-header">
<h2>Projektmetadaten</h2>
</div>
    -->
</div>
<div class="row">
    <div class="col-md-12">

        <?php include("appfiles/about.html") ?>
    </div>
</div>

@endsection