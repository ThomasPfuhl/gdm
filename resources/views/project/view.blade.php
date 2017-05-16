@extends('layouts.app')
{{-- Web site Title --}}
@section('title') {!!  $project->title !!} :: @parent @stop

{{-- Content --}}
@section('content')
<h3>{{ $project->title }}</h3>
<h4>{!! $project->description !!}</h4>
<div>
    <span>[ {!! $project->officialProjectID !!} ]</span>
    <span class="badge badge-info">{!! $project->startDate !!} </span>
    &rarr;
    <span class="badge badge-info">{!! $project->endDate !!} </span>
</div>

<hr/>
<ul>
    @foreach ($project["attributes"] as $key=>$value)
    <li>
        <div style="display:inline-block;color:#666;width:10em;">{{ $key }}:</div>
        <div style="display:inline-block;color:black;">{{ $value }}</div>
    </li>
    @endforeach
</ul>


@stop
