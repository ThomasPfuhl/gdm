
@extends('layouts.app')

@section('title') Aggregations :: @parent @stop

@section('content')
<div class="page-header">
    <span style="vertical-align:top;font-size:1.6em;font-weight:bold;padding-right:3em;">Aggregations</span>
    <div class="pull-right">
            @if ($has_aggregated_view)
            <a href="{!! URL::to('gdm_aggregations/aggregated') !!}"
               class="btn btn-sm btn-success"><span
                    class="glyphicon glyphicon-eye-open"></span> Aggregated View</a>
            @endif
            @if(Auth::check())
            @if(Auth::user()->admin==1)
            <a href="{!! URL::to('gdm_aggregations/create') !!}"
                   class="btn btn-sm btn-primary iframe"><span
                        class="glyphicon glyphicon-plus-sign"></span> {{
                    trans("admin/modal.new") }}</a>
            @endif
            @endif
    </div>
    
    @if(Session::has('message'))
    <div class="alert alert-info"><strong>{{ Session::get('message') }}</strong></div>
    @endif
</div>


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
                <a href="{{ URL::to('gdm_aggregations/' . $item  ) }}" class="btn btn-success btn-sm"
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
                <div>{{ money_format("%!#9.2n", $item) }}</div>
                
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
            @endforeach
            <td>
            @if(Auth::check())
            @if(Auth::user()->admin==1)

                <a href="{{ URL::to('gdm_aggregations/' . $record['id'] . '/edit' ) }}" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-pencil"></span> {{ trans("admin/modal.edit") }}</a>
                <!--
                <a href="{{ URL::to('gdm_aggregations/' . $record['id'] . '/destroy' ) }}" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> {{ trans("admin/modal.delete") }}</a>
                -->
            @endif
            @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>
@stop