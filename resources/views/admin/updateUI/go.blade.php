@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') updateUI :: @parent @stop

{{-- Content --}}
@section('main')
<div class="page-header">
    <h3>
        Regenerating User Interface ...
    </h3>
</div>

<div class="row">
    <pre>
        <?php
        chdir("../lib/tools");
        include("make_ui.php");
        ?>
    </pre>
</div>
@stop

{{-- Scripts --}}
@section('scripts')
@stop
