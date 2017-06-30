@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') Projects :: @parent @stop

{{-- Content --}}
@section('main')
<div class="page-header">
    <h3>
        Projects  +++ not yet functional for editing +++
        <div class="pull-right">
            <div class="pull-right">
                <a href="{!! URL::to('admin/project/create') !!}"
                   class="btn btn-sm  btn-primary iframe"><span
                        class="glyphicon glyphicon-plus-sign"></span> {{ trans("admin/modal.new") }}</a>
            </div>
        </div>
    </h3>
</div>



<table id="table" class="table table-striped table-hover">
    <thead>
        <tr>
            @foreach ($attributes as $value)
            <th>{{ $value }}</th>
            @endforeach
            <th>actions</th> <!-- placeholder for buttons -->
        </tr>
    </thead>
    <tbody></tbody>
</table>
@stop

{{-- Scripts --}}
@section('scripts')
@stop
