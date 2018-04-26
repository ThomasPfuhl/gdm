<nav class="navbar navbar-default ">
    <div class="container-fluid" style="margin:auto 5%">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/about">
                <img  alt="logo" src="{!! asset('img/app_logo.png') !!}"/>
                @section('sitename') @show</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
               <li class="{{ (Request::is('about') ? 'active' : '') }}">
                  <a href="{{ URL::to('about') }}"
                     ><i class="fa fa-info-circle"></i> About</a>
               </li>

               {{-- @include("partials/menu-start-item") --}}
@if(Auth::check())
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"
                       ><i class="fa fa-table"></i> Tables <i class="fa fa-caret-down"></i></a>

                    <ul class="dropdown-menu" role="menu">
                        @include("partials/menu-items")
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"
                       ><i class="fa fa-table"></i> Meta-Tables <i class="fa fa-caret-down"></i></a>

                    <ul class="dropdown-menu" role="menu">
                        @include("partials/menu-meta-items")
                    </ul>
                </li>
@endif
            </ul>

            <ul class="nav navbar-nav navbar-right">

                <li class="{{ (Request::is('about-gdm') ? 'active' : '') }}">
                    <a href="{{ URL::to('about-gdm') }}" title="get more info about the Generic Data Module"
                       ><i class="fa fa-info-circle"></i>
                          <img height="18" src="/img/data_module_logo.png" alt="GDM"/>
                        {{--
                          <div style="margin-left:1em;float:right;font-size:1em;font-weight:bold">
                           <span style="color:#a2c026">G</span><span style="font-size:0.8em;">eneric</span>
                           <span style="color:#a2c026">D</span><span style="font-size:0.8em;">ata</span>
                           <span style="color:#a2c026">M</span><span style="font-size:0.8em;">odule</span>
                       </div>
                       --}} </a>
                </li>

                @if (Auth::guest())
                <li class="{{ (Request::is('sign-in') ? 'active' : '') }}"
                    ><a href="{{ URL::to('sign-in') }}"
                    ><i class="fa fa-sign-in"></i> Sign in</a>
                </li>
                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"
                       ><i class="fa fa-user"></i> {{ Auth::user()->name }} <i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        @if(Auth::check())

                        @if(Auth::user()->admin==1)
                        <li>
                            <a href="{{ URL::to('admin/dashboard') }}"><i class="fa fa-tachometer"></i> Admin Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ URL::to('auth/logout') }}"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                        @else
                        <li>
                            <a href="{{ URL::to('keycloak/profile') }}"><i class="fa fa-info-circle"></i> Profile</a>
                        </li>
                        <li>
                              <a href="{{ URL::to('keycloak/logout') }}"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                        <li role="presentation" class="divider"></li>
                        <li>
                            <a href="{{ URL::to('http://accounts.dina-web.local:8080/auth/realms/dina/.well-known/openid-configuration') }}"><i class="fa fa-address-card"></i> open-id config</a>
                        </li>

                        @endif
                        @endif
                    </ul>
                </li>
                @endif
            </ul>

        </div>
    </div>
</nav>
