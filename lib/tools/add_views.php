<?php

/**
 * add Views
 * index, view
 *
 * for embedded tables (.e.g the value is an arry, we show the second field,
 * which ist the field after the autoincrement id-field,
 * such assuming that it shows some valuable info.
 *
 */
echo "\n adding views for " . $name;

///////////////////////////////////////////////////////////
// INDEX

$content = <<<'PHPCODE'

@extends('layouts.app')

@section('title') CNAME :: @parent @stop

@section('content')
<div class="page-header">
    <span style="vertical-align:top;font-size:1.6em;font-weight:bold;padding-right:3em;">CNAME</span>
        <div class="pull-right">
            @if ($has_aggregated_view)
            <a href="{!! URL::to('NAME/aggregated') !!}"
               class="btn btn-md btn-success"><span
                    class="glyphicon glyphicon-eye-open"></span> {!! trans('displaymodes.aggregated') !!}</a>
            @endif
            @if(Auth::check())
            @if(Auth::user()->admin==1)
            <a href="{!! URL::to('NAME/create') !!}"
                   class="btn btn-md btn-primary iframe"><span
                        class="glyphicon glyphicon-plus-sign"></span> {{
                    trans("admin/modal.new") }}</a>
            @endif
            @endif
        </div>

</div>

@if(Session::has('message'))
<div class="alert alert-info"><strong>{{ Session::get('message') }}</strong></div>
@endif

<table id="maintable" class="maintable table table-hover table-responsive table-condensed">
    <thead>
        <tr>
            @foreach ($propertyNames as $value)
               <th class="rotate"><div><span>{{ $value }}</span></div></th>
            @endforeach
            <th class="rotate"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($extPropertyValues as $row=>$record)
        <tr>
            @foreach ($record as $key=>$item)
            <td>
                @if (is_scalar($item) && $key == "id")
                <a href="{{ URL::to('NAME/' . $item  ) }}" class="btn btn-success btn-md"
                   ><span class="glyphicon glyphicon-eye-open"></span> {{ $item }}</a>

                @elseif (is_string($item))
                <div id="related_{{ $row }}_{{ $key }}" class="collapse" style="width:10em;">{!! $item !!}</div>
                @if (starts_with($item, "http"))
                    <a target='blank' title="open link in new tab"  href='{{ $item }}'>{!! $item!!}</a>
                @elseif (strlen($item) < 80)
                    {!! $item !!}
                @else
                <a class="toggle-link" href="#maintable" data-toggle="modal" data-target="#related-text-{{ $row }}-{{ $key }}"
                   ><span class="glyphicon glyphicon-resize-full"></span></a> {!! str_limit($item, 50) !!}
                <!-- Modal -->
                <div class="modal fade" id="related-text-{{ $row }}-{{ $key }}" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"> {{ $key }} for ID {{ $record[array_keys($record)[0]] }}</h4>
                            </div>

                            <div class="modal-body">
                                <p>{!! $item !!}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @elseif (is_float($item))
                <div>{{ money_format("%!#9.2n", $item) }}</div>

                @elseif (is_int($item))
                <div>{{ $item }}</div>

                @elseif (is_array($item))
                <a class="toggle-link" href="#maintable" data-toggle="collapse" data-target="#related_{{ $row }}_{{ $key }}" aria-expanded="false"
                   ><span title="expand" class="glyphicon glyphicon-plus-sign plusplus"></span><span title="collapse" class="glyphicon glyphicon-minus-sign minusminus"></span></a>
                   @if (starts_with($item[array_keys($item)[2]], "http"))
                       <a target='blank' title="open link in new tab" href='{{ $item[array_keys($item)[2]] }}'>{{ $item[array_keys($item)[2]] }}</a>
                  @else {
                         {{ $item[array_keys($item)[2]] }}
                       }
                  @endif
                <table id="related_{{ $row }}_{{ $key }}" class="table table-condensed collapse related" >
                    @foreach ($item as $k=>$v)
                    <tr><td>{{ $k }}</td><td>{{ $v }}</td></tr>
                    @endforeach
                </table>
                @endif
            </td>
            @endforeach
            <td>
            @if(Auth::check())
            @if(Auth::user()->admin==1)

                <a href="{{ URL::to('NAME/' . $record['id'] . '/edit' ) }}" class="btn btn-md btn-info"><span class="glyphicon glyphicon-pencil"></span> {{ trans("admin/modal.edit") }}</a>

            @endif
            @if(Auth::user()->admin==1)

                {!! Form::open(['method' => 'DELETE', 'url' => URL::to('NAME/' . $record['id'] . '/delete' ), 'style'=>'display:inline']) !!}
                {!! Form::button( trans("admin/modal.delete"), ['class' => 'btn btn-md btn-danger', 'type' => 'submit']) !!}
                {!! Form::close() !!}

            @endif
            @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>
@stop
PHPCODE;

$content = str_replace('CNAME', ucfirst($name), $content);
$content = str_replace('NAME', $name, $content);

@mkdir("../../resources/views/data/" . $name);
file_put_contents("../../resources/views/data/" . $name . "/index.blade.php", $content);


/////////////////////////////////////////////////////////////
// AGGREGATED INDEX

$content = <<<'PHP_CODE'

@extends('layouts.app')

@section('title') CNAME :: @parent @stop

@section('content')
<div class="page-header">
    <span style="vertical-align:top;font-size:1.6em;font-weight:bold;padding-right:3em;">CNAME &mdash; {!! trans('displaymodes.all') !!}</span>
    <div class="pull-right">
        <a href="{!! URL::to('NAME') !!}"
           class="btn btn-md  btn-success"><span
                class="glyphicon glyphicon-eye-open"></span> {!! trans('displaymodes.general') !!}</a>
    </div>
</div>

@if(Session::has('message'))
<div class="alert alert-info"><strong>{{ Session::get('message') }}</strong></div>
@endif

<table id="maintable" class="maintable table table-hover table-responsive table-condensed">
    <thead>
        <tr>
            @foreach ($propertyNames as $value)
            @if  ($value != "id")
            <th class="rotate"><div><span>{{ $value }}</span></div></th>
            @endif
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($extPropertyValues as $row=>$record)
        <tr>
            @foreach ($record as $key=>$item)
            @if ($key != "id")
            <td>

                @if (is_string($item))
                <div id="related_{{ $row }}_{{ $key }}" class="collapse" style="width:10em;">{{ $item}}</div>
                @if (strlen($item) < 30)
                {{ $item }}
                @else
               <a class="toggle-link" href="#maintable" data-toggle="modal" data-target="#related-text-{{ $row }}-{{ $key }}"
                   ><span class="glyphicon glyphicon-resize-full"></span></a> {{ str_limit($item, 30) }}
                <!-- Modal -->
                <div class="modal fade" id="related-text-{{ $row }}-{{ $key }}" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"> {{ $key }} for ID {{ $record[array_keys($record)[0]] }}</h4>
                            </div>
                            <div class="modal-body">
                                <p>{{ $item }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @elseif (is_float($item))
                <div>{{ money_format("%!#9.2n €", $item) }}</div>

                @elseif (is_int($item))
                <div>{{ $item }}</div>

                @elseif (is_array($item))
                <a class="toggle-link" href="#maintable" data-toggle="collapse" data-target="#related_{{ $row }}_{{ $key }}"
                   ><span class="glyphicon glyphicon-plus-sign"></span><span class="glyphicon glyphicon-minus-sign hidden"></span></a>
                {{ $item[array_keys($item)[2]] }}
                <table id="related_{{ $row }}_{{ $key }}" class="table table-condensed collapse related" >
                    @foreach ($item as $k=>$v)
                    <tr><td>{{ $k }}</td><td>{{ $v }}</td></tr>
                    @endforeach
                </table>
                @endif
            </td>
            @endif
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>


</div>
@stop
PHP_CODE;

$content = str_replace('CNAME', ucfirst($name), $content);
$content = str_replace('MODEL_NAME', singularize(ucfirst($name)), $content);
$content = str_replace('NAME', $name, $content);

@mkdir("../../resources/views/data/" . $name);
file_put_contents("../../resources/views/data/" . $name . "/index_aggregated.blade.php", $content);

///////////////////////////////////////////////////////////
// SINGLE RECORD

$content = <<<'PHPCODE'

@extends('layouts.app')

@section('title') @parent @stop

@section('content')
<div class = "page-header">
    <h3>
        MODEL_NAME {{$id}}
        <div style="float:right">
            <a href = "{{{ URL::to('NAME/') }}}" class = "btn btn-success btn-md"
            ><span class = "glyphicon glyphicon-eye-open"></span> {!! trans('displaymodes.all') !!}</a>
        </div>
    </h3>
</div>

@if(Session::has('message'))
<div class="alert alert-info"><strong>{{ Session::get('message') }}</strong></div>
@endif

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
            <a class="toggle-link" href="#maintable" data-toggle="collapse" data-target="#related_{{ $key }}" aria-expanded="false"
               ><span class="glyphicon glyphicon-plus-sign plusplus"></span><span class="glyphicon glyphicon-minus-sign minusminus"></span></a>
            {{ $value[array_keys($value)[2]] }}</a>
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
            <a href="{{ URL::to('NAME/' . $id . '/edit' ) }}" class="btn btn-md btn-info"><span class="glyphicon glyphicon-pencil"></span> {{ trans("admin/modal.edit") }}</a>
        </div>

        <div class="pull-right" style="margin-top:20px">
        </div>
    @endif
    @endif
</div>
</div>

@stop
PHPCODE;


$content = str_replace('CNAME', ucfirst($name), $content);
$content = str_replace('MODEL_NAME', singularize(ucfirst($name)), $content);
$content = str_replace('NAME', $name, $content);

@mkdir("../../resources/views/data/" . $name);
file_put_contents("../../resources/views/data/" . $name . "/view.blade.php", $content);

///////////////////////////////////////////////////////////
// CREATE

$content = <<<'PHPCODE'
@extends('layouts.app')

@section('title') @parent @stop

@section('content')
<div class = "page-header">

        <span style="vertical-align:top;font-size:1.6em;font-weight:bold;padding-right:3em;">add MODEL_NAME</span>

        <div style="float:right">
            <a href = "{{{ URL::to('NAME/') }}}" class = "btn btn-success btn-md"
            ><span class = "glyphicon glyphicon-eye-open"></span> {!! trans('displaymodes.all') !!}</a>
        </div>

</div>

{!! form($form) !!}

@endsection
PHPCODE;

$content = str_replace('MODEL_NAME', singularize(ucfirst($name)), $content);
$content = str_replace('NAME', $name, $content);

@mkdir("../../resources/views/data/" . $name);
file_put_contents("../../resources/views/data/" . $name . "/create.blade.php", $content);


///////////////////////////////////////////////////////////
// DESTROY

$content = <<<'PHPCODE'
@extends('layouts.app')

@section('title') MODEL_NAME {{$id}} :: @parent @stop

@section('content')

<div class = "page-header">
    <h3>
        MODEL_NAME {{$id}}
        <div style="float:right">
            <a href = "{{{ URL::to('NAME/') }}}" class = "btn btn-success btn-md"
            ><span class = "glyphicon glyphicon-eye-open"></span> {!! trans('displaymodes.all') !!}</a>
        </div>
    </h3>
</div>

<div class="row">
    @if(Session::has('message'))
    <div class="alert alert-info"><strong>MODEL_NAME {{$id}} {{ Session::get('message') }}</strong></div>
    @endif
</div>

@endsection
PHPCODE;

$content = str_replace('MODEL_NAME', singularize(ucfirst($name)), $content);
$content = str_replace('NAME', $name, $content);

@mkdir("../../resources/views/data/" . $name);
file_put_contents("../../resources/views/data/" . $name . "/destroy.blade.php", $content);


///////////////////////////////////////////////////////////
// EDIT

$content = <<<'PHPCODE'
@extends('layouts.app')

@section('title') MODEL_NAME {{$record->id}} :: @parent @stop

@section('content')

<div class="row">
    <div class="page-header">
        <span style="vertical-align:top;font-size:1.6em;font-weight:bold;padding-right:3em;">MODEL_NAME {{$record->id}}</span>
        &nbsp;
        <div class="pull-right">
                <a href="../" class="btn btn-primary btn-md">
                    <span class="glyphicon glyphicon-backward"></span> {!! trans('admin/admin.back') !!}
                </a>
        </div>
    @if(Session::has('message'))
        <div class="alert alert-info"><strong>{{ Session::get('message') }}</strong></div>
    @endif
    </div>
</div>

<div class="row">
{!! form($form) !!}
</div>


<div class="row" style="display:none">
<hr/>
<div class="well"><h4>Referenced Tables:</h4></div>
    @foreach ($referenced_tables as $tablename=>$table)
    <div class="col-md-3">
        <h3>{{$tablename}}</h3>
        <table class="table table-condensed table-striped table-hover" style="font-size:0.9em;">
        @foreach ($table as $key=>$value)
            <tr><td>{{$key}}: <td>{{$value}}</tr>
        @endforeach
        </table>
    </div>
    @endforeach
</div>

@stop

PHPCODE;

$content = str_replace('MODEL_NAME', singularize(ucfirst($name)), $content);

@mkdir("../../resources/views/data/" . $name);
file_put_contents("../../resources/views/data/" . $name . "/edit.blade.php", $content);
