@extends('general-settings::layouts.gs-app')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css">
@endpush

@section('title', __('general-settings::messages.general_settings_list_title'))

@section('content')
  <div class="bg-gray-100 mt-4">
    <h1 class="text-2xl font-bold mb-4">
        {{ __('general-settings::messages.general_settings_list_title') }}
        <a href="{{ route('admin.general-settings.create') }}" class="ml-4">
          <button class="px-4 py-1 my-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-base">
              {{ __('general-settings::messages.create_button_label') }}
          </button>
        </a>
    </h1>
    <form class="mb-4 flex flex-wrap gap-4" action="{{ route('admin.general-settings.index') }}">
      <div>
        <label class="block mb-1 font-bold">{{ __('general-settings::messages.name_label') }}</label>
        <input type="text" class="w-full px-4 py-2 rounded-md shadow-inner border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" name="name" value="{{ request('name') }}" placeholder="{{ __('general-settings::messages.name_placeholder') }}">
      </div>
      <div>
        <label class="block mb-1 font-bold">{{ __('general-settings::messages.value_label') }}</label>
        <input type="text" class="w-full px-4 py-2 rounded-md shadow-inner border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" name="value" value="{{ request('value') }}" placeholder="{{ __('general-settings::messages.value_placeholder') }}">
      </div>
      <div>
        <label class="block mb-1 font-bold">{{ __('general-settings::messages.type_label') }}</label>
        <select name="type" class="w-full px-4 py-2 rounded-md shadow-inner border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
          <option value="">{{ __('general-settings::messages.type_option_all') }}</option>
          @foreach ($types as $key => $value)
            <option value="{{ $key }}" @if (request('type') == $key) selected @endif>{{ $value }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="px-4 mt-7 mb-1 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">{{ __('general-settings::messages.search_button_label') }}</button>
    </form>
    <table class="w-full table-auto">
      <thead>
        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
          <th class="py-3 px-6 text-left">{{ __('general-settings::messages.name_column_title') }}</th>
          <th class="py-3 px-6 text-left">{{ __('general-settings::messages.type_column_title') }}</th>
          <th class="py-3 px-6 text-left">{{ __('general-settings::messages.value_column_title') }}</th>
          <th class="py-3 px-6 text-left">{{ __('general-settings::messages.created_at_column_title') }}</th>
          <th class="py-3 px-6 text-center">{{ __('general-settings::messages.actions_column_title') }}</th>
        </tr>
      </thead>
      <tbody class="text-gray-600 text-sm font-light">
        @foreach ($settings as $setting)
          <tr class="bg-white border-b border-gray-200 hover:bg-gray-100">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
              {{ $setting->name }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ $setting->type }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ $setting->valueForDisplay }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ $setting->created_at->format('Y-m-d H:i') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <a href="{{ route('admin.general-settings.show', $setting) }}" class="text-indigo-600 hover:text-indigo-900">
                {{ __('general-settings::messages.view_button_label') }}
              </a>
              <a href="{{ route('admin.general-settings.edit', $setting) }}" class="ml-4 text-indigo-600 hover:text-indigo-900">
                {{ __('general-settings::messages.edit_button_label') }}
              </a>
              <form action="{{ route('admin.general-settings.destroy', $setting) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="ml-4 text-red-600 hover:text-red-900" onclick="return confirm('{{ __('general-settings::messages.delete_confirm_message') }}');">
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
