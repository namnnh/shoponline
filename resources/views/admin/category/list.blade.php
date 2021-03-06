@extends('admin.layouts.app')

@section('page-title', trans('app.categories'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                @lang('app.categories')
                <small>@lang('app.available_categories')</small>
                <div class="pull-right">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                        <li class="active">@lang('app.categories')</li>
                    </ol>
                </div>

            </h1>
        </div>
    </div>

    @include('admin.partials.messages')

    <div class="row tab-search">
        <div class="col-md-2">
            <a href="{{ route('admin.category.create') }}" class="btn btn-success">
                <i class="glyphicon glyphicon-plus"></i>
                @lang('app.add_category')
            </a>
        </div>
    </div>


    <div class="table-responsive" id="users-table-wrapper">
        <table class="table">
            <thead>
                <th>@lang('app.name')</th>
                <th>@lang('app.image')</th>
                <th>@lang('app.sort_order')</th>
                <th class="text-center">@lang('app.action')</th>
                </thead>
            <tbody>
            @if (count($categories))
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->image }}</td>
                        <td>{{ $category->sort_order }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-primary btn-circle"
                               title="@lang('app.edit_role')" data-toggle="tooltip" data-placement="top">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                            {{--  @if ($role->removable)
                                <a href="{{ route('admin.role.delete', $role->id) }}" class="btn btn-danger btn-circle"
                                   title="@lang('app.delete_role')"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   data-method="DELETE"
                                   data-confirm-title="@lang('app.please_confirm')"
                                   data-confirm-text="@lang('app.are_you_sure_delete_role')"
                                   data-confirm-delete="@lang('app.yes_delete_it')">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            @endif  --}}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4"><em>@lang('app.no_records_found')</em></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

@stop
