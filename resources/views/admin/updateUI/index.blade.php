@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') updateUI :: @parent @stop

{{-- Content --}}
@section('main')
<div class="page-header">
    <h3>
        Updating User Interface
        <div class="pull-right">
            <div class="pull-right" style="display:none">
                <a href="{!! URL::to('admin/update-ui') !!}"
                   class="btn btn-sm  btn-primary iframe"><span
                        class="glyphicon glyphicon-plus-sign"></span> go !</a>
            </div>
        </div>
    </h3>
</div>

<pre>
    <?php
    chdir(getcwd() . "/../lib/tools");
    include("make_ui.php");
    ?>
</pre>

@stop

{{-- Scripts --}}
@section('scripts')
@stop
