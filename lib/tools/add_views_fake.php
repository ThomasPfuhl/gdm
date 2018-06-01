<?php

/**
 * add Fake Views for hidden GDM tables
 * index, view
 *
 */
echo " fake index views ";

///////////////////////////////////////////////////////////
// INDEX

$content = <<<'PHPCODE'

@extends('layouts.app')

@section('title') CNAME :: @parent @stop

@section('content')
<div class="page-header">
    <span style="vertical-align:top;font-size:1.6em;font-weight:bold;padding-right:3em;">CNAME</span>
</div>

@if(Session::has('message'))
<div class="alert alert-info"><strong>{{ Session::get('message') }}</strong></div>
@endif

<div class="well">
  These data cannot be presented.
</div>

@stop
PHPCODE;

$content = str_replace('CNAME', ucfirst($name), $content);
$content = str_replace('NAME', $name, $content);

@mkdir("../../resources/views/data/" . $name);
file_put_contents("../../resources/views/data/" . $name . "/index.blade.php", $content);
