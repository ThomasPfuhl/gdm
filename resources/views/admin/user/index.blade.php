@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') {!! trans("admin/users.users") !!} :: @parent
@stop

{{-- Content --}}
@section('main')
<div class="page-header">
    <h3>
        {!! trans("admin/users.users") !!}
        <div class="pull-right">
            <div class="pull-right">
                <a href="{!! URL::to('admin/user/create') !!}"
                   class="btn btn-sm  btn-primary iframe"><span
                        class="glyphicon glyphicon-plus-sign"></span> {{
					trans("admin/modal.new") }}</a>
            </div>
        </div>
    </h3>
</div>

<table id="table" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>{!! trans("admin/users.name") !!}</th>
            <th>Username</th>
            <th>{!! trans("admin/users.email") !!}</th>
            <th>Confirmation Code</th>
            <th>{!! trans("admin/users.active_user") !!}</th>
            <th>admin ?</th>
            <th>{!! trans("admin/admin.language") !!}</th>
            <th>{!! trans("admin/admin.created_at") !!}</th>
            <th>{!! trans("admin/admin.updated_at") !!}</th>
            <th>{!! trans("admin/admin.deleted_at") !!}</th>
            <th>{!! trans("admin/admin.action") !!}</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
@stop

{{-- Scripts --}}
@section('scripts')
@stop
