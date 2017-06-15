{{-- @todo
recognize automatically fields that are foreign keys
--}}

@extends('layouts.app')

@section('title') Proposals :: @parent @stop

<?php
setlocale(LC_MONETARY, 'de_DE.UTF8');
?>

@section('content')
<div class="page-header">
    <span style="vertical-align:top;font-size:1.6em;padding-right:3em;">Proposal Views</span>
    <!-- Tabs
    <ul class="nav nav-tabs" style="display:inline-block;">
        <li class="active"><a href="#tab-wide" data-toggle="tab"> wide </a></li>
        <li>               <a href="#tab-wide2" data-toggle="tab"> wide2 </a></li>
        <li>               <a href="#tab-compact" data-toggle="tab"> compact </a></li>
    </ul>
    -->
</div>


<table id="maintable" class="maintable table table-striped table-hover table-responsive table-condensed">
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
                <a href="{{ URL::to('proposal/' . $item  ) }}" class="btn btn-success btn-sm "
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

<!-- Tabs Content
<div class="tab-content">


    <div class="tab-pane active " id="tab-wide">

        <table id="maintable-wide" class="maintable table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    @foreach ($propertyNames as $value)
                    <th class="rotate"><div><span>{{ $value }}</span></div></th>
                    @endforeach
                    <th></th>
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

            @elseif (is_string($item))
            <div id="related_{{ $row }}_{{ $key }}" class="collapse" style="width:10em;">{{ $item}}</div>
            @if (strlen($item) < 30)
            {{ $item }}
            @else
            <a class="toggle-link" href="#maintable" data-toggle="collapse" data-target="#related_{{ $row }}_{{ $key }}"
               ><span class="glyphicon glyphicon-plus-sign"></span><span class="glyphicon glyphicon-minus-sign hidden"></span></a>
            {{ str_limit($item, 30) }}
            @endif

            @elseif (is_float($item))
            <div style="padding-right:1em;text-align:right;">{{ money_format("%!#9.2n", $item) }}</div>

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



<div class="tab-pane" id="tab-compact">


    <table id="maintable-compact" class="maintable table table-striped table-hover table-responsive table-condensed">
        <thead style="display:hidden;">
            <tr style="display:inline-block;vertical-align:top;">
                @foreach ($propertyNames as $value)
                <th style="border:1px solid #ccc;padding:10px;margin-right:10px;width:150px;line-height:25px;display:block;">
                    {{ $value }}
                </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr style="display:inline-block;vertical-align:top;">
                <td style="border:1px solid #ccc;padding:10px;margin-right:10px;width:150px;line-height:25px;display:block;">

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
                    <div style="padding-right:1em;text-align:right;">{{ money_format("%!#9.2n", $record->$value) }}</div>
                    @else
                    <div>{{  str_limit($record->$value, 30)  }}</div>
                    @endif
                    @endforeach


                    <div style="margin-top:10px;">
                        <a class="btn btn-success" href="{{ URL::to('proposal/'.$record->id) }}"
                           >Read more</a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


</div>
-->

</div>
@stop