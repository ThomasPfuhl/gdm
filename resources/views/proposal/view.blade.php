@extends('layouts.app')
{{-- Web site Title --}}
@section('title') { :: @parent @stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h3>
        Proposal
        <a href="{{{ URL::to('proposals/') }}}" class="btn btn-success btn-sm "
           ><span class="glyphicon glyphicon-eye-open"></span> {{ " view all" }}</a>

    </h3>
</div>


<table id="maintable" class="vertical">
    @foreach ($extPropertyValues as $key=>$value)
    <tr>
        <td>{{ $key }}:</td>
        <td>
            @if (!is_array($value))
            {{ $value }}
            @else
            <a class="toggle-link" href="#maintable" data-toggle="collapse" data-target="#related_{{ $key }}"
               ><span class="glyphicon glyphicon-plus-sign"></span><span class="glyphicon glyphicon-minus-sign hidden"></span></a>
            {{ $value[array_keys($value)[0]] }}
        <td><table id="related_{{ $key }}" class="collapse related">
                @foreach ($value as $k=>$v)
                <tr><td>{{ $k }}</td><td>{{ $v }}</td></tr>
                @endforeach
            </table></td>
        </td>
        @endif
    </tr>
    @endforeach
</table>


@stop
