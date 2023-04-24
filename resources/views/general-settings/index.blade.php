@extends('general-settings::layouts.gs-app')

@section('title', __('general-settings::messages.general_settings_list_title'))

@section('content')
  <div class="gs-content">
    <h1 class="gs-heading">
        {{ __('general-settings::messages.general_settings_list_title') }}
        <a href="{{ route('admin.general-settings.create') }}" class="gs-link">
          <button class="gs-btn gs-btn-create">
              {{ __('general-settings::messages.create_button_label') }}
          </button>
        </a>
    </h1>
    <form class="gs-search mb-4" action="{{ route('admin.general-settings.index') }}">
      <div class="gs-search-field">
        <label class="gs-label">{{ __('general-settings::messages.name_label') }}</label>
        <input type="text" class="gs-input" name="name" value="{{ request('name') }}" placeholder="{{ __('general-settings::messages.name_placeholder') }}">
      </div>
      <div class="gs-search-field">
        <label class="gs-label">{{ __('general-settings::messages.value_label') }}</label>
        <input type="text" class="gs-input" name="value" value="{{ request('value') }}" placeholder="{{ __('general-settings::messages.value_placeholder') }}">
      </div>
      <div class="gs-search-field">
        <label class="gs-label">{{ __('general-settings::messages.type_label') }}</label>
        <select name="type" class="gs-select">
          <option value="">{{ __('general-settings::messages.type_option_all') }}</option>
          @foreach ($types as $key => $value)
            <option value="{{ $key }}" @if (request('type') == $key) selected @endif>{{ $value }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="gs-btn gs-btn-search">{{ __('general-settings::messages.search_button_label') }}</button>
    </form>
    <table class="gs-table">
      <thead>
        <tr>
          <th class="gs-table-header">{{ __('general-settings::messages.name_column_title') }}</th>
          <th class="gs-table-header">{{ __('general-settings::messages.type_column_title') }}</th>
          <th class="gs-table-header">{{ __('general-settings::messages.value_column_title') }}</th>
          <th class="gs-table-header">{{ __('general-settings::messages.created_at_column_title') }}</th>
          <th class="gs-table-header">{{ __('general-settings::messages.actions_column_title') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($settings as $setting)
          <tr class="gs-table-row">
            <td class="gs-table-cell">{{ $setting->name }}</td>
            <td class="gs-table-cell">{{ $setting->type }}</td>
            <td class="gs-table-cell">{{ $setting->value }}</td>
            <td class="gs-table-cell">{{ $setting->created_at->format(Config::get('general_settings.out_format.date_time')) }}</td>
            <td class="gs-table-cell gs-actions">
              <a href="{{ route('admin.general-settings.show', $setting) }}" class="gs-link">
                <button class="gs-btn gs-btn-view">
                    {{ __('general-settings::messages.view_button_label') }}
                </button>
              </a>
              <a href="{{ route('admin.general-settings.edit', $setting) }}" class="gs-link">
                <button class="gs-btn gs-btn-edit">
                    {{ __('general-settings::messages.edit_button_label') }}
                </button>
              </a>
                <form action="{{ route('admin.general-settings.destroy', $setting) }}" method="POST" class="gs-inline-form">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="gs-link gs-btn gs-btn-delete"
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
