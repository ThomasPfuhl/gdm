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
                    <a href="{{URL::to('admin/update-ui')}}">
                        <div class="col-xs-3">
                            <i class="glyphicon glyphicon-cog fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="large">update UI</div>
                            <div>all tables</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">re-generate User Interface for all tables</span>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <a href="{{URL::to('admin/users')}}">
                        <div class="col-xs-3">
                            <i class="glyphicon glyphicon-user fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="large">{{$nb_users}} {{ trans("admin/admin.users") }}</div>
                            <div>registered users</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">{{ trans("admin/admin.view_detail") }}</span>
                <div class="clearfix"></div>
            </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-globe fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="large">{{$nb_languages}} {{ trans("admin/admin.languages") }}</div>
                        <div>system languages</div>
                    </div>
                </div>
            </div>
            <a href="{{URL::to('admin/languages')}}">
                <div class="panel-footer">
                    <span class="pull-left">{{ trans("admin/admin.view_detail") }}</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

</div>

<div class="row">
</div>
@endsection
