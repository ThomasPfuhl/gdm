<div class="row">
    <div class="col-md-12">

        <table class="table table-hover">
            <tr><td>Data Module:</td> <td>{{ env("GDM_TITLE") }}
            <tr><td>Short Name:</td> <td>{{ env("GDM_NAME") }}
            <tr><td>Data Model Version: <td>{{ env("GDM_DATAMODEL_VERSION") }}
            <tr><td>Authors:</td> <td>{{ env("GDM_AUTHORS") }}
            <tr><td>URL: </td> <td> {{ $_SERVER["HTTP_HOST"] }}
            <tr><td>API Endpoints General Documentation:</td>
                <td><a target="apidoc" href="http://{{ $_SERVER['HTTP_HOST'] }}/restricted/api/{{ env('GDM_NAME') }}/{{ env('GDM_DATAMODEL_VERSION') }}"
                         >{{ $_SERVER["HTTP_HOST"] }}/restricted/api/{{ env("GDM_NAME") }}/{{ env("GDM_DATAMODEL_VERSION") }}</a>
<!--
            <tr><td>API Endpoint Documentation for a given table:</td>    <td> {{ $_SERVER["HTTP_HOST"] }}/restricted/api/{{ env("GDM_NAME") }}/{{ env("GDM_DATAMODEL_VERSION") }}/<i>{tablename}</i>/
            <tr><td>API Endpoint for all records for a given table:</td>   <td> {{ $_SERVER["HTTP_HOST"] }}/restricted/api/{{ env("GDM_NAME") }}/{{ env("GDM_DATAMODEL_VERSION") }}/<i>{tablename}</i>/all/
            <tr><td>API Endpoint for record {id} for a given table::</td>  <td> {{ $_SERVER['HTTP_HOST'] }}/restricted/api/{{ env('GDM_NAME') }}/{{ env('GDM_DATAMODEL_VERSION') }}/<i>{tablename}/{id}</i>
-->
        </table>

        <div class="well">
            Please contact
            <b>{{ env("GDM_MANAGER_NAME") }}</b>
            <a href="mailto:{{ env('GDM_MANAGER_EMAIL') }}">&lt;{{ env('GDM_MANAGER_EMAIL') }}></a>
            for any questions, and to get access credentials if you do not have a valid login.
        </div>

    </div>
</div>
