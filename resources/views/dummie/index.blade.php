
@extends('layouts.default')

{{-- Web site Title --}}
@section('title') Dummies :: @parent @stop

{{-- Content --}}
@section('main')
<div class="page-header">
    <h3>
        Dummies
    </h3>
</div>


<table id="table" class="table table-striped table-hover">
    <thead>
        <tr>
            @foreach ($attributes as $value)
            <th>{{ $value }}</th>
            @endforeach
            <th></th> <!-- placeholder for buttons -->
        </tr>
    </thead>
    <tbody></tbody>
</table>
@stop

{{-- Scripts --}}
@section('scripts')
@stop