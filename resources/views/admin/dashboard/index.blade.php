@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') {!! $title !!} :: @parent @stop

{{-- Content --}}
@section('main')
<div class="page-header">
    <h3>
        {{$title}}
    </h3>
</div>

<div class="row">

    <div class="col-lg-3 col-md-3">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="row">

                    <div class="col-xs-3">
                        <a href="{{URL::to('admin/update-ui')}}">
                            <i class="glyphicon glyphicon-cog fa-3x"></i></a>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="large"><a href="{{URL::to('admin/update-ui')}}">update UI</a></div>
                        <div>regenerate the User Interface</div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">
                    Do it after each modification of the data model.
                </span>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <a href="{{URL::to('admin/users')}}">
                        <div class="col-xs-3">
                            <i class="glyphicon glyphicon-user fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="large">{{$nb_users}} {{ trans("admin/admin.users") }}</div>
                            <div>system users</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">
                    Administrate the system users and their rights.
                </span>
                <div class="clearfix"></div>
            </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-3">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <a href="{{URL::to('admin/languages')}}">
                        <div class="col-xs-3">
                            <i class="glyphicon glyphicon-globe fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="large">{{$nb_languages}} {{ trans("admin/admin.languages") }}</div>
                            <div>system languages</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">
                    Administrate the system languages.
                </span>
                <div class="clearfix"></div>
            </div>
            </a>
        </div>
    </div>

    <!--
     <div class="col-lg-3 col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <a href="{{URL::to('admin/tables')}}">
                        <div class="col-xs-3">
                            <i class="glyphicon glyphicon-list-alt fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="large">{{ trans("admin/admin.tables") }}</div>
                            <div>data base tables</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">
                    Show the Data Architecture.
                </span>
                <div class="clearfix"></div>
            </div>
            </a>
        </div>
    </div>
-->
</div>


@endsection
