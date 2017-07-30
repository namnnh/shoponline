@extends('admin.layouts.app')

@section('page-title', trans('app.categories'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            {{ $edit ? $category->name : trans('app.create_new_category') }}
            <small>{{ $edit ? trans('app.edit_category_details') : trans('app.category_details') }}</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li><a href="{{ route('admin.category') }}">@lang('app.categories')</a></li>
                    <li class="active">{{ $edit ? trans('app.edit') : trans('app.create') }}</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('admin.partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['admin.category.update', $role->id], 'method' => 'PUT', 'id' => 'role-form']) !!}
@else
    {!! Form::open(['route' => 'admin.category.store', 'id' => 'role-form']) !!}
@endif

<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.category_details_big')</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.category_name')" value="{{ $edit ? $category->name : old('name') }}">
                </div>
                <div class="form-group">
                    <label for="parent_id">@lang('app.parent_id')</label>
                    {!! Form::select('parent_id', $categories, $edit ? $category->parent_id : '', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label for="name">@lang('app.sort_order')</label>
                    <input type="number" class="form-control" id="sort_order"
                           name="sort_order" placeholder="@lang('app.sort_order')" value="{{ $edit ? $category->sort_order : old('sort_order') }}">
                </div>
                <div class="form-group">
                    <label for="image">@lang('app.image')</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> @lang('app.choose')
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="image"  value="{{ $edit ? $category->image : old('image') }}">
                    </div>
                    <img id="holder" style="margin-top:15px;max-height:100px;">
                </div>
                </div>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary btn-block">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.update_category') : trans('app.create_category') }}
        </button>
    </div>
</div>
@include('admin.partials.modal_Upload');

@stop
@section('styles')
    <style>
    </style>
    
@stop
 @section('scripts')
     {!! HTML::script('vendor/laravel-filemanager/js/lfm.js') !!} 
       @if ($edit)
        {!! JsValidator::formRequest('App\Http\Requests\Admin\Role\UpdateRoleRequest', '#role-form') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Admin\Category\CreateCategoryRequest', '#role-form') !!}
    @endif   
    <script>
        var route_prefix = "{{ url(config('lfm.prefix')) }}";
        $('#lfm').filemanager('image', {prefix: route_prefix});
    </script>
@stop 