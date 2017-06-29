
@extends('layouts.app')

@section('title') @parent @stop

@section('content')
<div class = "page-header">
    <h3>
        Proposal
        <div style="float:right">
            <a href = "{{{ URL::to('proposals/') }}}" class = "btn btn-success btn-sm "
            ><span class = "glyphicon glyphicon-eye-open"></span> {{ " view all" }}</a>
        </div>
    </h3>
</div>

<?php
setlocale(LC_MONETARY, 'de_DE.UTF8');
?>

<table id="maintable" class="vertical">
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
            <div style="width:7em;text-align:right;">{{ money_format("%!#9.2n", $value) }}</div>
            @else
            <div style="min-width:20em;">{{ $value }}</div>
            @endif

            @else
            <a class="toggle-link" href="#maintable" data-toggle="collapse" data-target="#related_{{ $key }}"
               ><span class="glyphicon glyphicon-plus-sign"></span><span class="glyphicon glyphicon-minus-sign hidden"></span></a>
            {{ $value[array_keys($value)[1]] }}
            <div>
                <table id="related_{{ $key }}" class="collapse related">
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


@stop