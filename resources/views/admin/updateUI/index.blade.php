@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') updateUI :: @parent @stop

{{-- Content --}}
@section('main')
<div class="page-header">
    <h3>
        Update User Interface
    </h3>
</div>

<div class="row">      
    <div class="alert alert-warning"><strong>
        By clicking on the button below the User Interface will be completely regenerated.
        This operation is necessary after each modification of the data model.
        </strong>
    </div>     
</div>

<div class="row">
    <a href="{!! URL::to('admin/update-ui/go') !!}"
       class="btn btn-lg  btn-primary "><span
            class="glyphicon glyphicon-cog"></span> renegerate user interface NOW </a>
</div>

@stop

{{-- Scripts --}}
@section('scripts')
@stop
