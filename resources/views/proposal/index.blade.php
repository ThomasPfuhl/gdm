{{-- @todo
recognize automatically fields that are foreign keys
--}}

@extends('layouts.app')

@section('title') Proposals :: @parent @stop

@section('content')
<div class="page-header">
    <span style="vertical-align:top;font-size:1.6em;padding-right:3em;">Proposal Views</span>
    <!-- Tabs -->
    <ul class="nav nav-tabs" style="display:inline-block;">
        <li class="active"> <a href="#tab-wide" data-toggle="tab"> wide </a></li>
        <li>                <a href="#tab-compact" data-toggle="tab"> compact </a></li>
    </ul>
</div>

<!-- Tabs Content -->
<div class="tab-content">

    <!-- wide tab -->
    <div class="tab-pane active" id="tab-wide">

        <table id="maintable" class="table table-striped table-hover">
            <thead>
                <tr>
                    @foreach ($propertyNames as $value)
                    <th class="rotate"><div><span>{{ $value }}</span></div></th>
                    @endforeach
                    <th></th> <!-- placeholder for buttons -->
                </tr>
            </thead>
            <tbody>
                @foreach ($extPropertyValues as $row=>$record)
                <tr>
                    @foreach ($record as $key=>$item)
                    <td>
                        @if (is_scalar($item) && $key == "id")
                        <a href="{{ URL::to('proposal/' . $item  ) }}" class="btn btn-success btn-sm "
                           ><span class="glyphicon glyphicon-eye-open"></span> {{ $item }}</a>
                        @elseif (is_scalar($item))
                        {{ $item }}
                        @elseif (is_object($item))
                        @elseif (is_array($item))
                        <a class="toggle-link" href="#maintable" data-toggle="collapse" data-target="#related_{{ $row }}_{{ $key }}"
                           ><span class="glyphicon glyphicon-plus-sign"></span><span class="glyphicon glyphicon-minus-sign hidden"></span></a>
                        {{ $item[array_keys($item)[0]] }}
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

    <!-- compact tab -->
    <div class="tab-pane" id="tab-compact">
        <ul style="margin:0;padding:0;list-style-type:none;">
            <li style="border:1px solid #ccc;padding:10px;margin:10px;float:left;width:200px;line-height:25px;">
                @foreach ($propertyNames as $value)
                <div>{{ $value }}</div>
                @endforeach
            </li>
            @foreach($records as $record)
            <li style="border:1px solid #ccc;padding:10px;margin:10px;float:left;width:150px;line-height:25px;">
                @foreach ($propertyNames as $value)
                <?php
                setlocale(LC_MONETARY, 'de_DE.UTF8');

                if (strpos($value, "accept") !== FALSE)
                    $class = "success";
                elseif (strpos($value, "reject") !== FALSE)
                    $class = "danger";
                else
                    $class = "info";
                ?>
                @if (strpos($value, "Date"))
                @if (strpos($value, "end") !== FALSE ) &longrightarrow; @endif
                <div class="label label-{{ $class }}">
                    {{ $record->$value }}
                </div>
                @if (strpos($value, "start") !== FALSE) &longrightarrow;  @endif
                <br/>
                @elseif (is_int($record->$value))
                <div>{{ $record->$value }}</div>
                @elseif (is_float($record->$value))
                <div style="text-align:right;display:none">{{ number_format($record->$value, 2, ",", ".") }}</div>
                <div style="font-family:monospace;">{{ money_format("%!=*#9.2n", $record->$value) }}</div>
                @else
                <div>{{ $record->$value }}</div>
                @endif
                @endforeach


                <div style="margin-top:10px;">
                    <a class="btn btn-success" href="{{ URL::to('proposal/'.$record->id) }}"
                       >Read more</a>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@stop