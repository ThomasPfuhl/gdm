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
                    <a href="{{ URL::to('about-gdm') }}"
                       ><i class="fa fa-info-circle"></i> About GDM</a>
                </li>

                @if (Auth::guest())

                <li class="{{ (Request::is('sign-in') ? 'active' : '') }}"
                    ><a href="{{ URL::to('sign-in') }}"
                    ><i class="fa fa-sign-in"></i> Sign in</a>
                </li>
<!--
                <li class="{{ (Request::is('auth/login') ? 'active' : '') }}"
                    ><a href="{{ URL::to('auth/login') }}"
                    ><i class="fa fa-cog"></i> Administration</a>
                </li>
                <li class="{{ (Request::is('keyclaok/authorize') ? 'active' : '') }}"
                    ><a href="{{ URL::to('keycloak/authorize') }}"
                    ><i class="fa fa-sign-in"></i> <b>Login</b></a>
                </li>
                 <li class="{{ (Request::is('auth/register') ? 'active' : '') }}"
                    ><a href="{{ URL::to('auth/register') }}">Register</a>
                </li>
-->
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
