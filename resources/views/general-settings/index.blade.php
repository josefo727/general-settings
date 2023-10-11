@extends('general-settings::layouts.gs-app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
@endpush

@section('title', __('general-settings::messages.general_settings_list_title'))

@section('content')
	<div class="container mt-4">
		<h1 class="h2 font-weight-bold mb-4">
			{{ __('general-settings::messages.general_settings_list_title') }}
			<a href="{{ route('admin.general-settings.create') }}" class="ml-4 btn btn-primary">
				{{ __('general-settings::messages.create_button_label') }}
			</a>
		</h1>
		<form class="mb-4 row gx-3 align-items-end" action="{{ route('admin.general-settings.index') }}">
			<div class="col-sm-3">
				<label for="name" class="form-label">{{ __('general-settings::messages.name_label') }}</label>
				<input type="text" class="form-control" id="name" name="name" value="{{ request('name') }}" placeholder="{{ __('general-settings::messages.name_placeholder') }}">
			</div>
			<div class="col-sm-3">
				<label for="value" class="form-label">{{ __('general-settings::messages.value_label') }}</label>
				<input type="text" class="form-control" id="value" name="value" value="{{ request('value') }}" placeholder="{{ __('general-settings::messages.value_placeholder') }}">
			</div>
			<div class="col-sm-3">
				<label for="type" class="form-label">{{ __('general-settings::messages.type_label') }}</label>
				<select name="type" class="form-control" id="type">
					<option value="">{{ __('general-settings::messages.type_option_all') }}</option>
					@foreach ($types as $key => $value)
						<option value="{{ $key }}" @if (request('type') == $key) selected @endif>{{ $value }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-sm-3">
				<button type="submit" class="btn btn-primary mt-3">{{ __('general-settings::messages.search_button_label') }}</button>
			</div>
		</form>
		<table class="table">
			<thead>
				<tr>
					<th>{{ __('general-settings::messages.name_column_title') }}</th>
					<th>{{ __('general-settings::messages.type_column_title') }}</th>
					<th>{{ __('general-settings::messages.value_column_title') }}</th>
					<th>{{ __('general-settings::messages.created_at_column_title') }}</th>
					<th class="text-center" width="220px">{{ __('general-settings::messages.actions_column_title') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($settings as $setting)
					<tr>
						<td>{{ $setting->name }}</td>
						<td>{{ $setting->type }}</td>
						<td>{{ $setting->valueForDisplay }}</td>
						<td>{{ $setting->created_at->format('Y-m-d H:i') }}</td>
						<td class="text-right">
							<a href="{{ route('admin.general-settings.show', $setting) }}" class="btn btn-sm btn-primary mx-1">
								{{ __('general-settings::messages.view_button_label') }}
							</a>
							<a href="{{ route('admin.general-settings.edit', $setting) }}" class="btn btn-sm btn-secondary mx-1">
								{{ __('general-settings::messages.edit_button_label') }}
							</a>
							<form action="{{ route('admin.general-settings.destroy', $setting) }}" method="POST" class="d-inline-block mx-1">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-sm btn-danger"
									onclick="return confirm('{{ __('general-settings::messages.delete_confirm_message') }}');">
									{{ __('general-settings::messages.delete_button_label') }}
								</button>
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="my-4">
			{{ $settings->appends(request()->query())->links() }}
		</div>
	</div>
@endsection
