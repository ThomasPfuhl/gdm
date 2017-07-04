<div id="footer">
    <div class="container">
        <div style="float:left;margin-right:1em;margin-top:25px;">
            <img valign="top" src="img/institution_logo.png"/>
        </div>

        <div style="float:left;margin-right:1em;margin-top:25px;">
            <span style="text-align:left;float:left;margin-left:2em;color:black;font-size:1.8em;font-weight:bolder;line-height:24px;font-family: 'Libre Franklin', sans-serif;">
                <span style="color:#d50000">g</span>eneric<br/>
                <span style="color:#d50000">d</span>ata<br/>
                <span style="color:#d50000">m</span>odule
            </span>
        </div>

        <div style="float:left;margin-left:4em;margin-right:1em;margin-top:25px;">
            <img valign="top" src="img/app_logo.png" height="60"/>
            <div style="display:inline-block; margin-left:1em; font-weight:bolder; font-size:1.2em;">
                <?php
                echo env('GDM_NAME');
                echo "<br/><a href='mailto:" . env('GDM_MANAGER_EMAIL') . "'>" . env('GDM_MANAGER_NAME') . "</a>";
                ?>
            </div>
        </div>

        <p class="" style="margin-top:10px;
           padding-top:12px;
           border-top:1px solid black;
           ">
            <span class="hidden-phone" style="text-align:right;
                  float:right;
                  ">
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
        </p>
    </div>
</div>