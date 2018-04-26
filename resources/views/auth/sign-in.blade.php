@extends('layouts.app')

{{-- Web site Title --}}
@section('title') {!!  trans('site/user.login') !!} :: @parent @stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="page-header">
            <h2>Please sign in</h2>
        </div>
        {{--
        <pre>{{ print_r(config('app'),true) }}</pre>
        <hr>
        <pre>{{ print_r(config('eloquent-oauth'),true) }}</pre>
        --}}
    </div>

    <div class="container-fluid">
        <div class="panel panel-default">
          <div class="panel-body">

            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <ul class="nav nav-tabs">
                <li class="active" style="width:50%;font-weight:bold;">
                  <a href="#keycloak" data-toggle="tab" style="background-color:#a2c026">Museum</a>
                </li>
                <li style="width:50%">
                  <a href="#local" data-toggle="tab">Local</a>
                </li>
              </ul>
            </div>
          </div>


        <div class="tab-content ">
          <div id="keycloak" class="tab-pane active" >
            <div class="row">
              <div class="col-md-8 col-md-offset-2">

                <h3><img valign="top" src="/img/institution_logo.png" height="40"/> {!! trans('site/user.login') !!} with your Museum credentials</h3>
                <div class="well">
                    Please sign in with the Museum's  <a href="keycloak/authenticate"><b>Central Authentication Service</b></a>.
                  </div>
                {{--
                  <pre>keycloak server: {{ config('app')['kc_server'] }}</pre>
                  <pre>keycloak realm: {{ config('app')['kc_realm'] }}</pre>
                  <pre>{{ print_r(config('eloquent-oauth'),true) }}</pre>

                  <iframe id="museum-login" scrolling="no" width="100%" height="400" frameborder="0"
                    src="{{ env('GDM_PROTOCOL') }}://{{ env('GDM_URL') }}/keycloak/authenticate" >
                  </iframe>
                --}}
              </div>
            </div>
          </div>
          <div id="local" class="tab-pane" >
            <div class="row">
              <div class="col-md-8 col-md-offset-2" >
                <h3> <img valign="top" src="/img/app_logo.png" height="40"/>
                  {!! trans('site/user.login_to_account') !!}
                </h3>
                <div class="well">
                    Please ask
                    <b>{{ env("GDM_MANAGER_NAME") }}</b>
                    <a href="mailto:{{ env('GDM_MANAGER_EMAIL') }}">&lt;{{ env('GDM_MANAGER_EMAIL') }}></a>
                    for local access credentials.
                </div>

                {!! Form::open(array('url' => URL::to('auth/login'), 'method' => 'post', 'files'=> true)) !!}
                <div class="form-group  {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::label('email', "E-Mail Address", array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::text('email', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group  {{ $errors->has('password') ? 'has-error' : '' }}">
                    {!! Form::label('password', "Password", array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::password('password', array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                    </div>
                </div>

                <div class="form-group">
                        <div class="col-md-6">
                            <div class="checkbox">
                              <label>
                                  <input type="checkbox" name="remember"> Remember Me
                              </label>
                            </div>
                       </div>

                      <div class="pull-right">
                          <a href="{{ URL::to('/password/email') }}">Forgot Your Password?</a>
                          &nbsp;
                          <button type="submit" class="btn btn-primary" id="login" name="login" >
                              Login
                          </button>
                      </div>


                </div>
                {!! Form::close() !!}

              </div>

          </div>
         </div>
        </div>


    </div>
  </div>
</div>


@endsection
