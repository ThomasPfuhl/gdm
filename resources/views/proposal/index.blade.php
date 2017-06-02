{{-- @todo
recognize automatically fields that are foreign keys
--}}

@extends('layouts.app')

@section('title') Proposals :: @parent @stop

@section('content')
<div class="page-header">
    <h3>
        Proposals
    </h3>
</div>


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


@stop