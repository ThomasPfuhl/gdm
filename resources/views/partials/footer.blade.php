<hr/>
<div id="footer">
    <div class="container">
        <div class="row">

            <div class="col-md-4" style="margin:20px 0;">
                <img valign="top" src="img/institution_logo.png"/>
            </div>

            <div class="col-md-4" style="margin:20px 0;">
                <img valign="top" src="img/app_logo.png" height="60"/>
                <div style="display:inline-block; margin-left:1em; font-weight:bolder; font-size:1.2em;">
                    <?php
                    echo env('GDM_NAME');
                    echo "<br/><a href='mailto:" . env('GDM_MANAGER_EMAIL') . "'>" . env('GDM_MANAGER_NAME') . "</a>";
                    ?>
                </div>
            </div>

            <div class="col-md-4" style="margin:20px 0;">
                <span style="color:black;font-size:1.8em;font-weight:bolder;line-height:24px;font-family: 'Libre Franklin', sans-serif;">
                    <span style="color:#d50000">g</span>eneric<br/>
                    <span style="color:#d50000">d</span>ata<br/>
                    <span style="color:#d50000">m</span>odule
                </span>
                <br/>
                <h4 class="footertext" style="text-align:right;max-width:15em;">
                    <span style="color:black;font-size:0.6em;" >
                        version: <span style="color:black">r0.3alpha 07/2017</span>
                        <br/>
                        author: <a href="mailto:thomas.pfuhl@mfn-berlin.de">thomas.pfuhl@mfn-berlin.de</a>
                        <br/>
                        source code:
                        <a href="https://code.naturkundemuseum.berlin/Thomas.Pfuhl/pmd" target="gitlab">MfN GitLab</a>
                        and <a href = "https://github.com/MfN-Berlin/gdm/" target = "github">GitHub</a>
                        <!--
                        <br/>
                        built with <a href = "http://laravel.com/" alt = "Laravel 5.1">Laravel 5.1</a></span>
                        -->
                    </span>
                </h4>
            </div>

        </div>
    </div>
</div>
