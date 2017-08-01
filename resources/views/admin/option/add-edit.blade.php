@extends('admin.layouts.app')

@section('page-title', trans('app.option'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            {{ $edit ? $role->name : trans('app.create_new_option') }}
            <small>{{ $edit ? trans('app.edit_role_details') : trans('app.option_details') }}</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li><a href="{{ route('admin.option') }}">@lang('app.option')</a></li>
                    <li class="active">{{ $edit ? trans('app.edit') : trans('app.create') }}</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('admin.partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['admin.option.update', $option->id], 'method' => 'PUT', 'id' => 'option-form']) !!}
@else
    {!! Form::open(['route' => 'admin.option.store', 'id' => 'option-form']) !!}
@endif

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.option_details_big')</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.option_name')" value="{{ $edit ? $role->name : old('name') }}">
                </div>
                <div class="form-group">
                    <label for="display_name">@lang('app.type')</label>
                    <select name="type" id="input-type" class="form-control">
						<optgroup label="Choose">
						<option value="select" selected="selected">Select</option>
						<option value="radio">Radio</option>
						<option value="checkbox">Checkbox</option>
						</optgroup>
						<optgroup label="Input">
						<option value="text">Text</option>
						<option value="textarea">Textarea</option>
						</optgroup>
						<optgroup label="File">
						<option value="file">File</option>
						</optgroup>
						<optgroup label="Date">
						<option value="date">Date</option>
						<option value="time">Time</option>
						<option value="datetime">Date &amp; Time</option>
					</optgroup>
					</select>
                </div>
                <div class="form-group">
                    <label for="description">@lang('app.sort_order')</label>
                    <input type="number" class="form-control" id="sort_order"
                           name="sort_order" placeholder="@lang('app.sort_order')" value="{{ $edit ? $role->sort_order : old('sort_order') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.option_values_big')</div>
            <div class="panel-body">
            	<table id="option-value" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<td class="text-left required">Option Value Name</td>
							<td class="text-right">Sort Order</td>
							<td></td>
						</tr>
					</thead>
					<tbody></tbody>
					<tfoot>
						<tr>
							<td colspan="2"></td>
							<td class="text-right"><button type="button" onclick="addOptionValue();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Option Value"><i class="fa fa-plus-circle"></i></button></td>
						</tr>
					</tfoot>
				</table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary btn-block">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.update_option') : trans('app.create_option') }}
        </button>
    </div>
</div>

@stop

@section('scripts')
      <!-- @if ($edit)
        {!! JsValidator::formRequest('App\Http\Requests\Admin\Role\UpdateRoleRequest', '#option-form') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Admin\Option\CreateOptionRequest', '#option-form') !!}
    @endif -->
    <script>
    	var option_value_row = 0;

		function addOptionValue() {
			html  = '<tr id="option-value-row' + option_value_row + '">';
		    html += '  <td class="text-right"><input type="hidden" name="option_value[' + option_value_row + '][id]" value="" />';
			html += '      <input type="text" name="option_value[' + option_value_row + '][name]" value="" placeholder="Option Value Name" class="form-control"/>';
				html += '  </td>';
			html += '  <td class="text-right"><input type="text" name="option_value[' + option_value_row + '][sort_order]" value="" placeholder="Sort Order" class="form-control" /></td>';
			html += '  <td class="text-right"><button type="button" onclick="$(\'#option-value-row' + option_value_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
			html += '</tr>';

			$('#option-value tbody').append(html);

			option_value_row++;
		}
    </script>
@stop