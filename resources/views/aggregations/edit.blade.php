@extends('layouts.app')

@section('title') Aggregation {{$record->id}} :: @parent @stop

@section('content')

<div class="row">
        <div class="page-header">
            <span style="vertical-align:top;font-size:1.6em;font-weight:bold;padding-right:3em;">Aggregation {{$record->id}}</span>
            &nbsp;
            <div class="pull-right">
                <a href="../" class="btn btn-primary btn-md ">
                    <span class="glyphicon glyphicon-backward"></span> {!! trans('admin/admin.back')!!}
                </a>
            </div>
        </div>
</div>

<div class="row">
{!! form($form) !!}
</div>


@stop
