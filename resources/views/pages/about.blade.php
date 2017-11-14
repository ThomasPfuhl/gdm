@extends('layouts.app')

@section('title') @parent @stop

@section('content')
<div class="row">
    <!--
    <div class="page-header"></div>
    -->
</div>
<div class="row">
    <div class="col-md-12">
        <?php include("appfiles/about.html") ?>

        <table class="table table-hover">
            <tr><td>Data Module:</td> <td>{{ env("GDM_TITLE") }}
            <tr><td>Short Name:</td> <td>{{ env("GDM_NAME") }}
            <tr><td>Data Model Version: <td>{{ env("GDM_DATAMODEL_VERSION") }}
            <tr><td>Authors:</td> <td>{{ env("GDM_AUTHORS") }}
            <tr><td>URL: </td> <td> {{ $_SERVER["HTTP_HOST"] }}
            <tr><td>API Endpoint Documentation:</td> <td> {{ $_SERVER["HTTP_HOST"] }}/api/{{ env("GDM_NAME") }}/{{ env("GDM_DATAMODEL_VERSION") }}
            <tr><td>API Endpoint Documentation:</td> <td> {{ $_SERVER["HTTP_HOST"] }}/api/{{ env("GDM_NAME") }}/{{ env("GDM_DATAMODEL_VERSION") }}/<i>{tablename}</i>/
            <tr><td>API Endpoint for all records:</td> <td> {{ $_SERVER["HTTP_HOST"] }}/api/{{ env("GDM_NAME") }}/{{ env("GDM_DATAMODEL_VERSION") }}/<i>{tablename}</i>/all/
            <tr><td>API Endpoint for record {id}:</td> 
                <td> <a target="apidoc" href="http://{{ $_SERVER['HTTP_HOST'] }}/api/{{ env('GDM_NAME') }}/{{ env('GDM_DATAMODEL_VERSION') }}/{{ env('GDM_MAIN_TABLE') }}/1/"
                        >{{ $_SERVER['HTTP_HOST'] }}/api/{{ env('GDM_NAME') }}/{{ env('GDM_DATAMODEL_VERSION') }}/<i>{tablename}/{id}</i></a>
        </table>

        <div class="well"> 
            For any questions about the presented data, please contact the data module maintainer
            <b>{{ env("GDM_MANAGER_NAME") }}</b>
            <a href="mailto:{{ env('GDM_MANAGER_EMAIL') }}">&lt;{{ env('GDM_MANAGER_EMAIL') }}></a>
        </div>       

        <div class="well"> 
            The
            <div style="display:inline; color:black;font-size:1em;font-weight:bolder;font-family: 'Libre Franklin', sans-serif;">
                <span style="color:green">g</span>eneric
                <span style="color:green">d</span>ata
                <span style="color:green">m</span>odule
            </div>
            software package has been developed by <a href="mailto:thomas.pfuhl@mfn-berlin.de">Thomas Pfuhl</a>
            at the Museum für Naturkunde Berlin.
            <br/>
            Current version: {{ config('app.version') }}
        </div>        

    </div>
</div>
@endsection