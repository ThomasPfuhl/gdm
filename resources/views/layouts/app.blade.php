<?php
$type = "";
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@section('title') @show</title>

        @show @section('meta_author')
        <meta name="author" content="thomas.pfuhl@mfn-berlin.de"/>
        @section('meta_keywords')
        <meta name="keywords" content="GDM; generic data module;"/>
        @show @section('meta_description')
        <meta name="description" content="A generic framework to view and edit database records"/>
        @show
        <link href="{{ asset('css/site.css') }}" rel="stylesheet">
        <script src="{{ asset('js/site.js') }}"></script>

        <link href="https://fonts.googleapis.com/css?family=Libre+Franklin" rel="stylesheet">

        @yield('styles')
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link rel="shortcut icon" href="{!! asset('img/data_module_icon.png')  !!} ">

    </head>
    <body>
        @include('partials.nav')

        <div class="container">
            @yield('content')
        </div>

        @include('partials.footer')


        <!-- Scripts -->
        <script type="text/javascript">
// see assets/js/gdm.js
$(document).ready(function () {

//    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
//        console.log("aha");
//        console.log($('div.tab-pane.active > table'));
//        console.log($.fn.dataTable.tables({visible: true, api: true}));
//        $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
//    });

    var oTable;
    //oTable = $('div.tab-pane.active > table').DataTable
    //oTable = $('#maintable-wide, #maintable-wide2, #maintable-compact').DataTable
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
                "processing": true,
                "serverSide": false,
                //"ajax": "{!! $type !!}/data",
                "fnDrawCallback": function (oSettings) {
                    $(".iframe").colorbox({
                        iframe: true,
                        width: "80%",
                        height: "90%",
                        onClosed: function () {
                            oTable.ajax.reload();
                        }
                    });
                }
            });
    //console.log(oTable);
    //
});
        </script>
        @yield('scripts')

    </body>
</html>
