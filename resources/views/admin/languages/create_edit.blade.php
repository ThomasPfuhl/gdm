@extends('admin.layouts.modal')
{{-- Content --}}
@section('content')
<!-- Tabs 
<ul class="nav nav-tabs">
        <li class="active"><a href="#tab-general" data-toggle="tab"> {{
                        trans("admin/modal.general") }}</a></li>
</ul>
-->
<!-- ./ tabs -->
@if (isset($language))
{!! Form::model($language, array('url' => URL::to('admin/languages') . '/' . $language->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
@else
{!! Form::open(            array('url' => URL::to('admin/languages'),                       'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
@endif
<div class="tab-content">
    <div class="tab-pane active" id="tab-general">
        <div class="form-group  {{ $errors->has('name') ? 'has-error' : '' }}">
            {!! Form::label('name', "Name", array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('alpha2_code') ? 'has-error' : '' }}">
            {!! Form::label('alpha2_code', trans("admin/language.isocode"), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('alpha2_code', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('alpha2_code', ':message') }}</span>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-md-12">
        <button type="reset" class="btn btn-md btn-warning close_popup">
            <span class="glyphicon glyphicon-ban-circle"></span> {{
            trans("admin/modal.cancel") }}
        </button>
        <button type="reset" class="btn btn-md btn-default">
            <span class="glyphicon glyphicon-remove-circle"></span> {{
            trans("admin/modal.reset") }}
        </button>
        <button type="submit" class="btn btn-md btn-success">
            <span class="glyphicon glyphicon-ok-circle"></span> 
            @if (isset($language)) 
            {{ trans("admin/modal.save") }}
            @else 
            {{trans("admin/modal.create") }}
            @endif
        </button>
    </div>
</div>
{!! Form::close() !!}
@stop
