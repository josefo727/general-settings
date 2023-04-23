@extends('general-settings::layouts.gs-app')

@section('title', __('general-settings::messages.general_settings_list_title'))

@section('content')
  <div class="gs-content">
    <h1 class="gs-heading">{{ __('general-settings::messages.general_settings_list_title') }}</h1>
    <div class="gs-search mb-4">
      <div class="gs-search-field">
        <label class="gs-label">{{ __('general-settings::messages.name_label') }}</label>
        <input type="text" class="gs-input" name="name" value="{{ request('name') }}" placeholder="{{ __('general-settings::messages.name_placeholder') }}">
      </div>
      <div class="gs-search-field">
        <label class="gs-label">{{ __('general-settings::messages.type_label') }}</label>
        <select name="type" class="gs-select">
          <option value="">{{ __('general-settings::messages.type_option_all') }}</option>
          @foreach ($types as $type)
            <option value="{{ $type }}" @if (request('type') == $type) selected @endif>{{ $type }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="gs-btn">{{ __('general-settings::messages.search_button_label') }}</button>
    </div>
    <table class="gs-table">
      <thead>
        <tr>
          <th class="gs-table-header">{{ __('general-settings::messages.name_column_title') }}</th>
          <th class="gs-table-header">{{ __('general-settings::messages.type_column_title') }}</th>
          <th class="gs-table-header">{{ __('general-settings::messages.created_at_column_title') }}</th>
          <th class="gs-table-header">{{ __('general-settings::messages.actions_column_title') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($settings as $setting)
          <tr class="gs-table-row">
            <td class="gs-table-cell">{{ $setting->name }}</td>
            <td class="gs-table-cell">{{ $setting->type }}</td>
            <td class="gs-table-cell">{{ $setting->created_at->format(Config::get('general_settings.out_format.date_time')) }}</td>
            <td class="gs-table-cell">
              <a href="{{ route('admin.general-settings.show', $setting) }}" class="gs-link">{{ __('general-settings::messages.view_button_label') }}</a>
              <a href="{{ route('admin.general-settings.edit', $setting) }}" class="gs-link">{{ __('general-settings::messages.edit_button_label') }}</a>
                <form action="{{ route('admin.general-settings.destroy', $setting) }}" method="POST" class="gs-inline-form">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="gs-link"
                        onclick="return confirm('{{ __('general-settings::messages.delete_confirm_message') }}');">
                        {{ __('general-settings::messages.delete_button_label') }}
                    </button>
                </form>

            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
