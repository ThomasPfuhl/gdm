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
                <a href="{!! URL::to('admin/users/create') !!}"
                   class="btn btn-sm  btn-primary iframe"><span
                        class="glyphicon glyphicon-plus-sign"></span> {{
                    trans("admin/modal.new") }}</a>
            </div>
        </div>
    </h3>
</div>

<table id="table" class="maintable table table-striped table-hover">
    <thead>
        <tr>
            <th class="rotate"><div>ID</div></th>
            <th class="rotate"><div>{!! trans("admin/users.name") !!}</div></th>
            <th class="rotate"><div>{!! trans("admin/users.username") !!}</div></th>
            <th class="rotate"><div>{!! trans("admin/users.email") !!}</div></th>
            <th class="rotate"><div>{!! trans("admin/users.confirmation_code") !!}</div></th>
            <th class="rotate"><div>{!! trans("admin/users.active_user") !!}</div></th>
            <th class="rotate"><div>{!! trans("admin/users.is_admin") !!}</div></th>
            <th class="rotate"><div>{!! trans("admin/admin.language") !!}</div></th>
            <th class="rotate"><div>{!! trans("admin/admin.created_at") !!}</div></th>
            <th class="rotate"><div>{!! trans("admin/admin.updated_at") !!}</div></th>
            <th class="rotate"><div>{!! trans("admin/admin.deleted_at") !!}</div></th>
            <th class="rotate"><div>{!! trans("admin/admin.action") !!}</div></th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
@stop

{{-- Scripts --}}
@section('scripts')
@stop
