
@extends('layouts.app')

@section('title') @parent @stop

@section('content')
<div class = "page-header">
    <h3>
        Aggregation {{$id}}
        <div style="float:right">
            <a href = "{{{ URL::to('gdm_aggregations/') }}}" class = "btn btn-success btn-md "
            ><span class = "glyphicon glyphicon-eye-open"></span> {{ " view all" }}</a>
        </div>
    </h3>
    @if(Session::has('message'))
    <div class="alert alert-info"><strong>{{ Session::get('message') }}</strong></div>
    @endif
</div>

<div class="row">
<div class="col-md-11">

<table id="maintable" class="table table-striped table-hover vertical">
    @foreach ($extPropertyValues as $key=>$value)
    <tr>
        <td>{{ $key }}:</td>
        <td>
            @if (!is_array($value))
            <?php
            if (strpos($key, "accept") !== FALSE)
            $class = "success";
            elseif (strpos($key, "reject") !== FALSE)
            $class = "danger";
            else
            $class = "info";
            ?>

            @if (strpos($key, "Date"))
            @if (strpos($key, "end") !== FALSE ) &longrightarrow; @endif
            <div class="label label-{{ $class }}">
                {{ $value }}
            </div>
            @if (strpos($key, "start") !== FALSE) &longrightarrow;  @endif
            <br/>
            @elseif (is_int($value))
            {{ $value }}
            @elseif (is_float($value))
            <div>{{ money_format("%!#9.2n", $value) }}</div>
            @else
            <div style="min-width:20em;">{{ $value }}</div>
            @endif

            @else
            <a class="toggle-link" href="#maintable" data-toggle="collapse" data-target="#related_{{ $key }}"
               ><span class="glyphicon glyphicon-plus-sign"></span><span class="glyphicon glyphicon-minus-sign hidden"></span></a>
            {{ $value[array_keys($value)[2]] }}
            <div>
                <table id="related_{{ $key }}" class="table table-condensed collapse related">
                    @foreach ($value as $k=>$v)
                    <tr>
                        <td>{{ $k }}</td>
                        <td>{{ $v }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </td>
        @endif
    </tr>
    @endforeach
</table>
</div>

<div class="col-md-1">
    @if(Auth::check())
    @if(Auth::user()->admin==1)

        <div class="pull-right">
            <a href="{{ URL::to('gdm_aggregations/' . $id . '/edit' ) }}" class="btn btn-md btn-info"><span class="glyphicon glyphicon-pencil"></span> {{ trans("admin/modal.edit") }}</a>
        </div>

        <div class="pull-right" style="margin-top:20px">
        </div>
    @endif
    @endif
</div>
</div>

@stop