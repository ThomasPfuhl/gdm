
<li class="{{ (Request::is('agencies') ? 'active' : '') }}">
    <a href="{{ URL::to('agencies') }}">Agencies</a>
</li>

<li class="{{ (Request::is('agents') ? 'active' : '') }}">
    <a href="{{ URL::to('agents') }}">Agents</a>
</li>

<li class="{{ (Request::is('institutions') ? 'active' : '') }}">
    <a href="{{ URL::to('institutions') }}">Institutions</a>
</li>

<li class="{{ (Request::is('networkPartners') ? 'active' : '') }}">
    <a href="{{ URL::to('networkPartners') }}">NetworkPartners</a>
</li>

<li class="{{ (Request::is('networks') ? 'active' : '') }}">
    <a href="{{ URL::to('networks') }}">Networks</a>
</li>

<li class="{{ (Request::is('projects') ? 'active' : '') }}">
    <a href="{{ URL::to('projects') }}">Projects</a>
</li>

<li class="{{ (Request::is('proposals') ? 'active' : '') }}">
    <a href="{{ URL::to('proposals') }}">Proposals</a>
</li>

<li class="{{ (Request::is('bars') ? 'active' : '') }}">
    <a href="{{ URL::to('bars') }}">Bars</a>
</li>

<li class="{{ (Request::is('foos') ? 'active' : '') }}">
    <a href="{{ URL::to('foos') }}">Foos</a>
</li>
