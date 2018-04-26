@extends('layouts.app')

@section('title') @parent @stop

@section('content')
<div class = "page-header">
    <h3>
        {{ $user["username"] }}'s Profile
    </h3>
</div>

@if(Session::has('message'))
<div class="alert alert-info"><strong>{{ Session::get('message') }}</strong></div>
@endif

<div class="row">
<div class="col-md-11">

<table id="maintable" class="table table-striped table-hover vertical">
    {{--
    @foreach ($user as $key=>$value)
    <tr>
        <td>{{ $key }}: </td>
        <td>{{ $value }}</td>
    </tr>
    @endforeach
    --}}
    <tr><td colspan="2"><h4>Authentication</h4></td></tr>
    <tr><td>name </td><td>{{ $user["name"] }}</td></tr>
    <tr><td>username </td><td>{{ $user["username"] }}</td></tr>
    <tr><td>email </td><td>{{ $user["email"] }}</td></tr>
    <tr><td colspan="2"><h4>Authorisations</h4></td></tr>
    <tr><td>read</td><td>yes</td></tr>
    <tr><td>write</td><td>no</td></tr>
    <tr><td>administrator</td><td>no</td></tr>
</table>


</div>


<div class="col-md-1">
    @if(Auth::check())
    @if(Auth::user()->admin==1)

        <div class="pull-right">
            <a href="{{ URL::to('Communities/' . $id . '/edit' ) }}" class="btn btn-md btn-info"><span class="glyphicon glyphicon-pencil"></span> {{ trans("admin/modal.edit") }}</a>
        </div>

        <div class="pull-right" style="margin-top:20px">
        </div>
    @endif
    @endif
</div>
</div>

@stop
