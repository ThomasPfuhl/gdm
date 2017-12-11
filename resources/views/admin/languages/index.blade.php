@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') {!! trans("admin/language.languages") !!} ::
@parent @stop

{{-- Content --}}
@section('main')
<div class="page-header">
    <h3>
        {!! trans("admin/language.languages") !!}
        <div class="pull-right">
            <a href="{!!  URL::to('admin/languages/create') !!}"
               class="btn btn-sm  btn-primary iframe"><span
                    class="glyphicon glyphicon-plus-sign"></span> {!!
                trans("admin/modal.new") !!}</a>
        </div>
    </h3>
    @if (Session::has('message'))
    <div class="alert alert-info"><strong>{{ Session::get('message') }}</strong></div>
    @endif
</div>

<table id="table" class="maintable table table-striped table-hover">
    <thead>
        <tr>
            <th class="rotate"><div>ID</div></th>
            <th class="rotate"><div> {!! trans("admin/language.isocode") !!}</div></th>
            <th class="rotate"><div> {!! trans("admin/language.name") !!}</div></th>
            <th class="rotate"><div> {!! trans("admin/admin.action") !!}</div></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>



<div class="row">
    <h3>Localisation</h3>
    <div class='alert alert-info'>
        The localised messages are stored in the folder  '/resources/lang/'. 
        For each language there is a subfolder with the ISO alpha2 code, .e.g. '/resources/lang/de' for German localisation files.
        Feel free to add new languages and messages.
    </div>
</div>

@stop

{{-- Scripts --}}
@section('scripts')
@stop
