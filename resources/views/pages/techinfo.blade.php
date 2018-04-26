<div class="row">
    <div class="col-md-12">

        <table class="table table-hover">
            <tr><td>Data Module:</td> <td>{{ env("GDM_TITLE") }}
            <tr><td>Short Name:</td> <td>{{ env("GDM_NAME") }}
            <tr><td>Data Model Version: <td>{{ env("GDM_DATAMODEL_VERSION") }}
            <tr><td>Authors:</td> <td>{{ env("GDM_AUTHORS") }}
            <tr><td>URL: </td> <td> {{ $_SERVER["HTTP_HOST"] }}
            <tr><td>API Endpoints General Documentation:</td>
                <td><a target="apidoc" href="http://{{ $_SERVER['HTTP_HOST'] }}/api/{{ env('GDM_NAME') }}/{{ env('GDM_DATAMODEL_VERSION') }}"
                         >{{ $_SERVER["HTTP_HOST"] }}/api/{{ env("GDM_NAME") }}/{{ env("GDM_DATAMODEL_VERSION") }}</a>
        </table>

        <div class="well">
            Please contact
            <b>{{ env("GDM_MANAGER_NAME") }}</b>
            <a href="mailto:{{ env('GDM_MANAGER_EMAIL') }}">&lt;{{ env('GDM_MANAGER_EMAIL') }}></a>
            for any questions, and to get local access credentials if you cannot sign in via the central authentication service.
        </div>

    </div>
</div>
