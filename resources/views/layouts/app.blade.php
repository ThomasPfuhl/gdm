<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('layouts.sitename')

        <title>@section('sitename') @show</title>

        @section('meta_author')
        <meta name="author" content="thomas.pfuhl@mfn-berlin.de"/>
        @section('meta_keywords')
        <meta name="keywords" content="GDM; generic data module;"/>
        @section('meta_description')
        <meta name="description" content="A generic framework to view and edit database records"/>
        @show
        <link rel="shortcut icon" href="{!! asset('img/data_module_icon.png') !!} ">

        <link href="{{ asset('css/site.css') }}" rel="stylesheet">
        <script src="{{ asset('js/site.js') }}"></script>

        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <script src="{{ asset('js/custom.js') }}"></script>

        @yield('styles')
    </head>
    <body>
        @include('partials.nav')

        <div class="container-fluid" style="margin:auto 5%">
            @yield('content')
        </div>

        @include('partials.footer')

        <!-- Scripts -->
        <script type="text/javascript">
            $(document).ready(function () {

            var oTable;
            oTable = $('#maintable').DataTable
                    ({
                    "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                            "sPaginationType": "bootstrap",
                            "oLanguage": {
                            "sProcessing": "{{ trans('table.processing') }}",
                                    "sLengthMenu": "{{ trans('table.showmenu') }}",
                                    "sZeroRecords": "{{ trans('table.noresult') }}",
                                    "sInfo": "{{ trans('table.show') }}",
                                    "sEmptyTable": "{{ trans('table.emptytable') }}",
                                    "sInfoEmpty": "{{ trans('table.view') }}",
                                    "sInfoFiltered": "{{ trans('table.filter') }}",
                                    "sInfoPostFix": "",
                                    "sSearch": "{{ trans('table.search') }}:",
                                    "sUrl": "",
                                    "oPaginate": {
                                    "sFirst": "{{ trans('table.start') }}",
                                            "sPrevious": "{{ trans('table.prev') }}",
                                            "sNext": "{{ trans('table.next') }}",
                                            "sLast": "{{ trans('table.last') }}"
                                    }
                            },
                            "pageLength": 25,
                            "processing": false,
                            "serverSide": false,
                    });
            });
            $('[data-toggle=confirmation]').confirmation({
            rootSelector: "[data-toggle=confirmation]",
                    title: "{{ trans('admin/admin.confirm_operation') }}",
                    btnOkLabel: "{{ trans('admin/admin.yes') }}",
                    btnOkClass: "btn-md btn-success",
                    btnOkIcon: "glyphicon glyphicon-ok",
                    onConfirm: function(){$(this)[0].submit(); return true; },
                    btnCancelLabel: "{{ trans('admin/admin.no') }}",
                    btnCancelClass: "btn-md btn-default",
                    btnCancelIcon: "glyphicon glyphicon-remove",
                    onCancel: function(){return false; },
            });
         </script>
        @yield('scripts')

    </body>
</html>
