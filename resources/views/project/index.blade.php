@extends('layouts.app')
{{-- Web site Title --}}
@section('title')
@parent
@stop

@section('content')
<div class="page-header">
    <span style="vertical-align:top;font-size:1.6em;padding-right:3em;">Project Views</span>
    <!-- Tabs -->
    <ul class="nav nav-tabs" style="display:inline-block;">
        <li class="active"> <a href="#tab-wide" data-toggle="tab"> wide </a></li>
        <li>                <a href="#tab-compact" data-toggle="tab"> compact </a></li>
    </ul>
</div>


<!-- Tabs Content -->
<div class="tab-content">

    <!-- wide tab -->
    <div class="tab-pane active" id="tab-wide">
        <table id="maintable" class="table table-striped table-hover">
            <thead>
                <tr>
                    @foreach ($propertyNames as $value)
                    <th class="rotate"><div><span>{{ $value }}</span></div></th>
                    @endforeach
                    <th></th> <!-- placeholder for buttons -->
                </tr>
            </thead>
            <tbody>
                @foreach ($extPropertyValues as $row=>$record)
                <tr>
                    @foreach ($record as $key=>$item)
                    <td>
                        @if (is_scalar($item) && $key == "id")
                        <a href="{{ URL::to('project/' . $item  ) }}" class="btn btn-success btn-sm "
                           ><span class="glyphicon glyphicon-eye-open"></span> {{ $item }}</a>
                        @elseif (is_scalar($item))
                        {{ $item }}
                        @elseif (is_object($item))
                        @elseif (is_array($item))
                        <a class="toggle-link" href="#maintable" data-toggle="collapse" data-target="#related_{{ $row }}_{{ $key }}"
                           ><span class="glyphicon glyphicon-plus-sign"></span><span class="glyphicon glyphicon-minus-sign hidden"></span></a>
                        {{ $item[array_keys($item)[0]] }}
                        <table id="related_{{ $row }}_{{ $key }}" class="collapse related" >
                            @foreach ($item as $k=>$v)
                            <tr><td>{{ $k }}</td><td>{{ $v }}</td></tr>
                            @endforeach
                        </table>
                        @endif
                    </td>
                    @endforeach
                    <td style="display:none;border:none;"></td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <!-- compact tab -->
    <div class="tab-pane" id="tab-compact">
        <ul style="margin:0;padding:0;list-style-type:none;">
            @foreach($records as $project)
            <li style="border:1px solid #ccc;padding:10px;margin:10px;float:left;width: 200px;">
                <h4>{{ $project->title }}</h4>
                <h5>{{ $project->description }}</h5>
                <div>[ {!! $project->officialProjectID !!} ]</div>
                <span class="badge badge-info">{!! $project->startDate !!} </span>
                &rarr;
                <span class="badge badge-info">{!! $project->endDate !!} </span>

                <div style="margin-top:10px;">
                    <a class="btn btn-success" href="{{ URL::to('project/'.$project->id) }}"
                       >Read more</a>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>




@stop
