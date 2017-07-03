@extends('admin.layouts.app')

@section('page-title', trans('app.add_user'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            @lang('app.create_new_user')
            <small>@lang('app.user_details')</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li><a href="{{ route('admin.user.list') }}">@lang('app.users')</a></li>
                    <li class="active">@lang('app.create')</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('admin.partials.messages')

{!! Form::open(['route' => 'admin.user.store', 'files' => true, 'id' => 'user-form']) !!}
    <div class="row">
        <div class="col-md-8">
            @include('admin.user.partials.details', ['edit' => false, 'profile' => false])
        </div>
        <div class="col-md-4">
            @include('admin.user.partials.auth', ['edit' => false])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i>
                @lang('app.create_user')
            </button>
        </div>
    </div>
{!! Form::close() !!}

@stop

@section('styles')
    {!! HTML::style('assets/admin/css/bootstrap-datetimepicker.min.css') !!}
@stop

@section('scripts')
    {!! HTML::script('assets/admin/js/moment.min.js') !!}
    {!! HTML::script('assets/admin/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
    {!! JsValidator::formRequest('App\Http\Requests\Admin\User\CreateUserRequest', '#user-form') !!}
@stop