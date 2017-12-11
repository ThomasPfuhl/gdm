<nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" title="GDM" href="/admin/dashboard">GDM - Administration</a>
    </div>
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="{{ URL::to('') }}"><i class="fa fa-backward"></i> Go to frontend</a>
                </li>
                <li>
                    <a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="{{url('admin/update-ui')}}"><i class="glyphicon glyphicon-cog"></i> update UI</a>
                </li>
                <li>
                    <a href="{{url('admin/users')}}"><i class="glyphicon glyphicon-user"></i> Users</a>
                </li>
                <li>
                    <a href="{{url('admin/languages')}}"><i class="glyphicon glyphicon-globe"></i> Languages</a>
                </li>
                <li>
                    <a href="{{ URL::to('auth/logout') }}"><i class="fa fa-sign-out"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>