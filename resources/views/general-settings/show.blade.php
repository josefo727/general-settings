@extends('general-settings::layouts.gs-app')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css">
@endpush

@section('title', __('general-settings::messages.general_settings_show_title'))

@section('content')

  <div class="bg-gray-100 py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6">
          <h1 class="text-2xl font-bold mb-6">{{ __('general-settings::messages.general_settings_show_title') }}</h1>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <p class="text-sm font-medium text-gray-500">{{ __('general-settings::messages.name_label') }}</p>
                  <p class="text-lg">{{ $generalSetting->name }}</p>
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-500">{{ __('general-settings::messages.type_label') }}</p>
                  <p class="text-lg">{{ $generalSetting->type }}</p>
                </div>
                @if(!!$generalSetting->valueForDisplay)
                  <div class="md:col-span-2">
                    <p class="text-sm font-medium text-gray-500">{{ __('general-settings::messages.value_label') }}</p>
                    <p class="text-lg">{{ $generalSetting->valueForDisplay }}</p>
                  </div>
                @endif
                <div class="md:col-span-2">
                  <p class="text-sm font-medium text-gray-500">{{ __('general-settings::messages.description_label') }}</p>
                  <p class="text-lg">{{ $generalSetting->description }}</p>
                </div>
              </div>

              <div class="mt-6">
                <a href="{{ route('admin.general-settings.index') }}">
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" type="button">
                        {{ __('general-settings::messages.go_back') }}
                    </button>
                </a>
                <a href="{{ route('admin.general-settings.edit', $generalSetting->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                  {{ __('general-settings::messages.edit_link') }}
                </a>
              </div>
            </div>
          </div>
        </div>
  </div>
@endsection
