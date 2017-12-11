<hr/>
<div id="footer">
    <div class="container-fluid" style="margin:auto 5%">
        <div class="row">

            <div class="col-md-3" >
                <img valign="top" src="/img/institution_logo.png"/>
            </div>

            <div class="col-md-4" >
                <img valign="top" style="vertical-align:top" src="/img/app_logo.png" height="60"/>
                <div style="display:inline-block; margin-left:1em; font-weight:bolder;">                   
                    {{ env('GDM_NAME') }}
                    <br/>
                    {{ env('GDM_TITLE') }}
                    <br/>
                    <a href="mailto:{{ env('GDM_MANAGER_EMAIL') }}">  {{ env('GDM_MANAGER_NAME') }} </a>

                </div>
            </div>

            <div class="col-md-5" >
                <div style="float:right;color:black;font-size:1.1em;font-weight:bolder;">
                    <span style="color:green">g</span>eneric<br/>
                    <span style="color:green">d</span>ata<br/>
                    <span style="color:green">m</span>odule
                </div>
                <div style="float:right;margin-right:2em;margin-top:5px;display:inline-block;text-align:right;color:black;font-size:0.8em;">
                    version: <span style="color:black">{{ config('app.version') }}</span>
                    <br/>
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
