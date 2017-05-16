@extends('admin.layouts.modal')
{{-- Content --}}
@section('content')

<!-- Tabs -->
<ul class="nav nav-tabs">
    <li class="active">
        <a href="#tab-general" data-toggle="tab" style="font-weight:bold">
            @if (isset($project))
            Project N° {{ $project->id }}
            @else
            {{ trans("admin/modal.general") }}
            @endif
        </a></li>
    <!--
    <li><a href="#tab-timeline" data-toggle="tab"> Timeline </a></li>
    <li><a href="#tab-ids" data-toggle="tab">  IDs </a></li>
    <li><a href="#tab-comments" data-toggle="tab">  Comments </a></li>
    -->
</ul>

@if (isset($project))
{!! Form::model( $project, array('url' => URL::to('admin/project') . '/' . $project->id, 'method' => 'put')) !!}
@else
{!! Form::open(            array('url' => URL::to('admin/project'),                      'method' => 'post')) !!}
@endif



<!-- Form Actions
<div class="form-group" style="float:right">
    <div class="col-md-12">
        <button type="reset" class="btn btn-sm btn-warning close_popup">
            <span class="glyphicon glyphicon-ban-circle"></span> {{
                                                trans("admin/modal.cancel") }}
        </button>
        <button type="reset" class="btn btn-sm btn-default">
            <span class="glyphicon glyphicon-remove-circle"></span> {{
                                                trans("admin/modal.reset") }}
        </button>
        <button type="submit" class="btn btn-sm btn-success">
            <span class="glyphicon glyphicon-ok-circle"></span>
            @if	(isset($project))
            {{ trans("admin/modal.save") }}
            @else
            {{trans("admin/modal.create") }}
            @endif
        </button>
    </div>
</div>
<hr style="clear:both"/>
-->


<!-- Tabs Content -->
<div class="tab-content">

    <!-- General tab -->
    <div class="tab-pane active" id="tab-general">
        <div class="form-group  {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans("admin/modal.title"), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('description') ? 'has-error' : '' }}">
            {!! Form::label('description', "Description", array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('startDate') ? 'has-error' : '' }}">
            {!! Form::label('startDate', "Start Date", array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('startDate', null, array('class' => 'form-control datepicker')) !!}
                <span class="help-block">{{ $errors->first('startDate', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('endDate') ? 'has-error' : '' }}">
            {!! Form::label('endDate', "End Date", array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('endDate', null, array('class' => 'form-control  datepicker')) !!}
                <span class="help-block">{{ $errors->first('endDate', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('officialProjectID') ? 'has-error' : '' }}">
            {!! Form::label('officialProjectID', "official Project ID", array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('officialProjectID', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('officialProjectID', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('sapID') ? 'has-error' : '' }}">
            {!! Form::label('sapID', "SAP ID", array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('sapID', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('sapID', ':message') }}</span>
            </div>
        </div>
        <!--
        <div class="form-group  {{ $errors->has('officialProjectID') ? 'has-error' : '' }}">
            {!! Form::label('id', "internal ID", array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('id', null, array('readonly' => 'readonly')) !!}
                <span class="help-block">{{ $errors->first('id', ':message') }}</span>
            </div>
        </div>
        -->
        <div class="form-group  {{ $errors->has('remarks') ? 'has-error' : '' }}">
            {!! Form::label('remarks', "Remarks", array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('remarks', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('remarks', ':message') }}</span>
            </div>
        </div>
    </div>
    <!-- ./ general tab -->

    <!-- timeline tab
    <div class="tab-pane" id="tab-timeline">
        <div class="form-group  {{ $errors->has('startDate') ? 'has-error' : '' }}">
            {!! Form::label('start date', "Start Date", array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('start date', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('startDate', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('endDate') ? 'has-error' : '' }}">
            {!! Form::label('end date', "End Date", array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('end date', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('endDate', ':message') }}</span>
            </div>
        </div>
    </div>
    -->
    <!-- ids tab
    <div class="tab-pane" id="tab-ids">
        <div class="form-group  {{ $errors->has('officialProjectID') ? 'has-error' : '' }}">
            {!! Form::label('title', "official Project ID", array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('officialProjectID', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('officialProjectID', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('sapID') ? 'has-error' : '' }}">
            {!! Form::label('title', "SAP ID", array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('sapID', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('sapID', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('officialProjectID') ? 'has-error' : '' }}">
            {!! Form::label('id', "internal ID", array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('id', null, array('readonly' => 'readonly')) !!}
                <span class="help-block">{{ $errors->first('id', ':message') }}</span>
            </div>
        </div>
    </div>
    -->
    <!-- comments tab
    <div class="tab-pane" id="tab-comments">
        <div class="form-group  {{ $errors->has('remarks') ? 'has-error' : '' }}">
            {!! Form::label('remarks', "Remarks", array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('remarks', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('remarks', ':message') }}</span>
            </div>
        </div>
    </div>
    -->


    <!-- Form Actions -->
    <div class="form-group" >
        <div class="col-md-12">
            <button type="reset" class="btn btn-sm btn-warning close_popup">
                <span class="glyphicon glyphicon-ban-circle"></span> {{
						trans("admin/modal.cancel") }}
            </button>
            <button type="reset" class="btn btn-sm btn-default">
                <span class="glyphicon glyphicon-remove-circle"></span> {{
						trans("admin/modal.reset") }}
            </button>
            <button type="submit" class="btn btn-sm btn-success">
                <span class="glyphicon glyphicon-ok-circle"></span>
                @if	(isset($project))
                {{ trans("admin/modal.edit") }}
                @else
                {{trans("admin/modal.create") }}
                @endif
            </button>
        </div>
    </div>
    <!-- ./ Form Actions -->
    <!-- ./ tabs content -->
</div>


{!! Form::close() !!}

</div>
@stop
