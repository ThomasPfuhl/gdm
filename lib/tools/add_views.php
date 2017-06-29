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

<?php
setlocale(LC_MONETARY, 'de_DE.UTF8');
?>

@section('content')
<div class="page-header">
    <span style="vertical-align:top;font-size:1.6em;padding-right:3em;">CNAME</span>
</div>


<table id="maintable" class="maintable table  table-hover table-responsive table-condensed">
    <thead>
        <tr>
            @foreach ($propertyNames as $value)
            <th class="rotate"><div><span>{{ $value }}</span></div></th>
            @endforeach
            <th style="border-bottom:none;"></th> <!-- ugly hack -->
        </tr>
    </thead>
    <tbody>
        @foreach ($extPropertyValues as $row=>$record)
        <tr>
            @foreach ($record as $key=>$item)
            <td>
                @if (is_scalar($item) && $key == "id")
                <a href="{{ URL::to('NAME/' . $item  ) }}" class="btn btn-success btn-sm "
                   ><span class="glyphicon glyphicon-eye-open"></span> {{ $item }}</a>

                @elseif (is_string($item))
                <div id="related_{{ $row }}_{{ $key }}" class="collapse" style="width:10em;">{{ $item}}</div>
                @if (strlen($item) < 30)
                {{ $item }}
                @else
                <!--
                <a class="toggle-link" href="#maintable" data-toggle="collapse" data-target="#related_{{ $row }}_{{ $key }}"
                  ><span class="glyphicon glyphicon-plus-sign"></span><span class="glyphicon glyphicon-minus-sign hidden"></span></a>
                -->
                <a class="toggle-link" href="#maintable" data-toggle="modal" data-target="#related-text-{{ $row }}-{{ $key }}"
                   ><span class="glyphicon glyphicon-plus-sign"></span></a> {{ str_limit($item, 30) }}
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
                <div style="padding-right:1em;text-align:right;">{{ money_format("%!#9.2n", $item) }}</div>

                @elseif (is_array($item))
                <a class="toggle-link" href="#maintable" data-toggle="collapse" data-target="#related_{{ $row }}_{{ $key }}"
                   ><span class="glyphicon glyphicon-plus-sign"></span><span class="glyphicon glyphicon-minus-sign hidden"></span></a>
                {{ $item[array_keys($item)[1]] }}
                <table id="related_{{ $row }}_{{ $key }}" class="collapse related" >
                    @foreach ($item as $k=>$v)
                    <tr><td>{{ $k }}</td><td>{{ $v }}</td></tr>
                    @endforeach
                </table>
                @endif
            </td>
            @endforeach
            <td style="display:none;border:none;"></td>
        </tr>
        @endforeach
    </tbody>
</table>


</div>
@stop
PHPCODE;


$content = str_replace('CNAME', ucfirst($name), $content);
$content = str_replace('NAME', $name, $content);

//echo $content;
@mkdir("../../resources/views/" . $name);
file_put_contents("../../resources/views/" . $name . "/index.blade.php", $content);




///////////////////////////////////////////////////////////
// VIEW

$content = <<<'PHPCODE'

@extends('layouts.app')

@section('title') @parent @stop

@section('content')
<div class = "page-header">
    <h3>
        MODEL_NAME
        <div style="float:right">
            <a href = "{{{ URL::to('NAME/') }}}" class = "btn btn-success btn-sm "
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
PHPCODE;


$content = str_replace('CNAME', ucfirst($name), $content);
$content = str_replace('MODEL_NAME', singularize(ucfirst($name)), $content);
$content = str_replace('NAME', $name, $content);

//echo $content;
@mkdir("../../resources/views/" . $name);
file_put_contents("../../resources/views/" . $name . "/view.blade.php", $content);
