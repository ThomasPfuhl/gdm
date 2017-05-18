<ul class="nav navbar-nav">
                <!--
                <li class="{{ (Request::is('/') ? 'active' : '') }}">
                    <a href="{{ URL::to('') }}"><i class="fa fa-home"></i> Start</a>
                </li>
                -->
                <li class="{{ (Request::is('projects') ? 'active' : '') }}">
                    <a href="{{ URL::to('projects') }}"><i class="fa fa-home"/> Projekte</a>
                </li>
            <li class="{{ (Request::is('dummy') ? 'active' : '') }}"><a href="{{ URL::to('dummy') }}">Dummy</a></li></ul>