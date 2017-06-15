

<li class = "{{ (Request::is('foobar') ? 'active' : '') }}">
    <a href = "{{ URL::to('foobars') }}">Foobars</a>
</li>
