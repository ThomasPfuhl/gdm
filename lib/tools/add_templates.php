<?php

/**
 * add Templates
 *
 */
$content = <<<'PHPCODE'

@extends('layouts.app')

{{-- Web site Title --}}
@section('title') CNAMEs :: @parent @stop

{{-- Content --}}
@section('main')
<div class="page-header">
    <h3>
        CNAMEs
    </h3>
</div>


<table id="table" class="table table-striped table-hover">
    <thead>
        <tr>
            @foreach ($propertyValues as $value)
            <th>{{ $value }}</th>
            @endforeach
            <th></th> <!-- placeholder for buttons -->
        </tr>
    </thead>
    <tbody></tbody>
</table>
@stop

{{-- Scripts --}}
@section('scripts')
@stop
PHPCODE;

$name = $argv[1];

$content = str_replace('CNAME', ucfirst($name), $content);
$content = str_replace('NAME', $name, $content);

echo $content;
@mkdir("../../resources/views/" . $name);
file_put_contents("../../resources/views/" . $name . "/index.blade.php", $content);
