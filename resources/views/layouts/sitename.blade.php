<?php
$sitename = trim(file_get_contents("appfiles/sitename.txt"));
?>
@section('sitename') {{ $sitename }} @endsection