@extends('layouts.app')

@section('title') @parent @stop

@section('content')
<div class="row">
    <div class="page-header">
        <h3>General Description of the Generic Data Module.</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        The GDM has been designed at the Museum für Naturkunde,
        in the aim to fill in the gap 
        concerning the sustainability of research and project data 
        which are not covered by the traditional storage policy.
    </div>
</div>

<hr/>
<div id="footer">
    <div class="container-fluid" style="margin:auto 5%">
        <div class="row">

            <div class="col-md-3" >
                <img valign="top" src="/img/institution_logo.png"/>
            </div>

            <div class="col-md-5" >
                <div style="float:right;color:black;font-size:1.1em;font-weight:bolder;">
                    <span style="color:green">g</span>eneric<br/>
                    <span style="color:green">d</span>ata<br/>
                    <span style="color:green">m</span>odule
                </div>
                <div style="float:right;margin-right:2em;margin-top:5px;display:inline-block;text-align:right;color:black;font-size:0.8em;">
                    author: <a href="mailto:thomas.pfuhl@mfn-berlin.de">thomas.pfuhl@mfn-berlin.de</a>
                    <br/>
                    source code:
                    <a href="https://code.naturkundemuseum.berlin/Thomas.Pfuhl/gdm" target="gitlab">MfN GitLab</a>
                    and <a href = "https://github.com/MfN-Berlin/gdm/" target = "github">GitHub</a>
                    <!--
                    <br/>
                    built with <a href = "http://laravel.com/" alt = "Laravel 5.1">Laravel 5.1</a></span>
                    -->
                </div>
            </div>

        </div>
    </div>
</div>


</body>
</html>

@endsection
