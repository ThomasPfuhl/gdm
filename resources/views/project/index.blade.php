@extends('layouts.app')
{{-- Web site Title --}}
@section('title')
@parent
@stop

@section('content')


@foreach($projects as $project)

<h3>{{ $project->title }}</h3>
<h4>{{ $project->description }}</h4>
<div>
    <span>[ {!! $project->officialProjectID !!} ]</span>
    <span class="badge badge-info">{!! $project->startDate !!} </span>
    &rarr;
    <span class="badge badge-info">{!! $project->endDate !!} </span>
</div><!--
<table border="1" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            @foreach ($propertyNames as $val)
            <th>
                {{ $val }}
            </th>
            @endforeach
            <th>createdAt</th>
            <th>updatetAt</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($propertyValues as $record)
        <tr>
            @foreach ($record as $coll)
            <td>
                {{ $coll }}
            </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
-->
<div style="margin-top:20px;">
    <a class="btn btn-success" href="{{ URL::to('project/'.$project->id) }}"
       >Read more</a>
</div>
@endforeach


{!! $projects->render() !!}
@stop
