@extends('admin.layouts.app')

@section('page-title', trans('app.my_profile'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            {{ $user->present()->nameOrEmail }}
            <small>@lang('app.edit_profile_details')</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="javascript:;">@lang('app.home')</a></li>
                    <li class="active">@lang('app.my_profile')</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('admin.partials.messages')

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#details" aria-controls="details" role="tab" data-toggle="tab">
            <i class="glyphicon glyphicon-th"></i>
            @lang('app.details')
        </a>
    </li>
    <li role="presentation">
        <a href="#social-networks" aria-controls="social-networks" role="tab" data-toggle="tab">
            <i class="fa fa-youtube"></i>
            @lang('app.social_networks')
        </a>
    </li>
    <li role="presentation">
        <a href="#auth" aria-controls="auth" role="tab" data-toggle="tab">
            <i class="fa fa-lock"></i>
            @lang('app.authentication')
        </a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="details">
        <div class="row">
            <div class="col-lg-8 col-md-7">
                {!! Form::open(['route' => 'admin.profile.update.details', 'method' => 'PUT', 'id' => 'details-form']) !!}
                    @include('admin.user.partials.details', ['profile' => true])
                {!! Form::close() !!}
            </div>
            <div class="col-lg-4 col-md-5">
                {!! Form::open(['route' => 'admin.profile.update.avatar', 'files' => true, 'id' => 'avatar-form']) !!}
                    @include('admin.user.partials.avatar', ['updateUrl' => route('admin.profile.update.avatar-external')])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="social-networks">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(['route' => 'admin.profile.update.social-networks', 'method' => 'PUT', 'id' => 'socials-form']) !!}
                    @include('admin.user.partials.social-networks')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="auth">
        <div class="row">
            <div class="col-md-8">
                {!! Form::open(['route' => 'admin.profile.update.login-details', 'method' => 'PUT', 'id' => 'login-details-form']) !!}
                    @include('admin.user.partials.auth')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@stop

@section('styles')
    {!! HTML::style('assets/admin/css/bootstrap-datetimepicker.min.css') !!}
    {!! HTML::style('assets/admin/plugins/croppie/croppie.css') !!}
@stop

@section('scripts')
    {!! HTML::script('assets/admin/plugins/croppie/croppie.js') !!}
    {!! HTML::script('assets/admin/js/moment.min.js') !!}
    {!! HTML::script('assets/admin/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('assets/admin/js/as/btn.js') !!}
    {!! HTML::script('assets/admin/js/as/profile.js') !!}
    {!! JsValidator::formRequest('App\Http\Requests\Admin\User\UpdateDetailsRequest', '#details-form') !!}
    {!! JsValidator::formRequest('App\Http\Requests\Admin\User\UpdateProfileLoginDetailsRequest', '#login-details-form') !!}
@stop