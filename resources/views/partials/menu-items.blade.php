
<li class="{{ (Request::is('communities') ? 'active' : '') }}">
    <a href="{{ URL::to('communities') }}">Communities</a>
</li>

<li class="{{ (Request::is('deposits') ? 'active' : '') }}">
    <a href="{{ URL::to('deposits') }}">Deposits</a>
</li>

<li class="{{ (Request::is('members') ? 'active' : '') }}">
    <a href="{{ URL::to('members') }}">Members</a>
</li>

<li class="{{ (Request::is('products') ? 'active' : '') }}">
    <a href="{{ URL::to('products') }}">Products</a>
</li>
