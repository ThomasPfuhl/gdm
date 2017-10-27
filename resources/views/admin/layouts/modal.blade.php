<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@section('title') Administration @show</title>

        @show @section('meta_author')
        <meta name="author" content="Thomas Pfuhl"/>

        @show
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
        <link href="{{ asset('css/admin.css') }}" rel="stylesheet">


        <!--
        <link  href="{{ asset('vendor/dropzoner/dropzone/dropzone.min.css') }}" rel="stylesheet">
        <script src="{{ asset('vendor/dropzoner/dropzone/config.js') }}"></script>


        <link  href="{{ asset('css/dropzone.css') }}" rel="stylesheet">
        <script src="{{ asset('js/dropzone.js') }}"></script>
        -->
        @yield('styles')

        <script src="{{ asset('js/admin.js') }}"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/i18n/jquery-ui-i18n.js"></script>
    </head>

    <!-- Container -->
    <div class="container">
        <div class="page-header">
            &nbsp;
            <div class="pull-right">
                <button class="btn btn-primary btn-xs close_popup">
                    <span class="glyphicon glyphicon-backward"></span> {!! trans('admin/admin.back')!!}
                </button>
            </div>
        </div>
        <!-- Content -->
        @yield('content')
        <!-- ./ Content -->


        <script type="text/javascript">

$(function () {
    $('textarea').summernote({height: 120});
    $('form').submit(function (event) {
        event.preventDefault();
        //bool = event.defaultPrevented;
        var form = $(this);
        console.log(form.serialize());

        //if (form.attr('id') == '' || form.attr('id') != 'fupload')
        {
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize()
            }).done(function () {
                setTimeout(function () {
                    parent.$.colorbox.close();
                }, 10);
            }).fail(function (jqXHR, textStatus, errorThrown) {
                // Optionally alert the user of an error here...
                var textResponse = jqXHR.responseText;
                var alertText = "One of the following conditions is not met:\n\n";
                var jsonResponse = jQuery.parseJSON(textResponse);
                $.each(jsonResponse, function (n, elem) {
                    alertText = alertText + elem + "\n";
                });
                alert(alertText);
            });
        }
        /*else {
         var formData = new FormData(this);
         $.ajax({
         type: form.attr('method'),
         url: form.attr('action'),
         data: formData,
         mimeType: "multipart/form-data",
         contentType: false,
         cache: false,
         processData: false
         }).done(function () {
         setTimeout(function () {
         parent.$.colorbox.close();
         }, 10);
         }).fail(function (jqXHR, textStatus, errorThrown) {
         // Optionally alert the user of an error here...
         var textResponse = jqXHR.responseText;
         console.log(" status:" + textStatus);
         var alertText = "One of the following conditions is not met:\n\n";
         var jsonResponse = jQuery.parseJSON(textResponse);
         $.each(jsonResponse, function (n, elem) {
         alertText = alertText + n + ": " + elem + "\n";
         });
         alert(alertText);
         console.log(alertText);
         });
         }
         */
        ;
    });
    $('.close_popup').click(function () {
        parent.$.colorbox.close();
    });
    $(".datepicker").datepicker($.datepicker.regional[ "de" ]);
});
        </script>
        @yield('scripts')
    </div>
</body>
</html>
