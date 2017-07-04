<?php
//$sitename = trim(file_get_contents("appfiles/sitename.txt"));
$sitename = env('GDM_NAME');
?>
@section('sitename') {{ $sitename }} @endsection