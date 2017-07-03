
<li class="{{ (Request::is('bars') ? 'active' : '') }}">
    <a href="{{ URL::to('bars') }}">Bars</a>
</li>

<li class="{{ (Request::is('foos') ? 'active' : '') }}">
    <a href="{{ URL::to('foos') }}">Foos</a>
</li>
