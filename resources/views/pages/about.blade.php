@extends('layouts.app')

@section('title') @parent @stop

@section('content')
<div class="row">
    <div class="page-header">
         @include('pages.userinfo')
    </div>
</div>

@include('pages.techinfo')

@endsection
