@extends('general-settings::layouts.gs-app')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css">
@endpush

@section('title', __('general-settings::messages.general_settings_create_title'))

@section('content')
  <div class="bg-white rounded-lg shadow-lg p-6 mt-4">
    <h1 class="text-2xl font-bold mb-6">{{ __('general-settings::messages.general_settings_create_title') }}</h1>
    <form class="space-y-6" action="{{ route('admin.general-settings.store') }}" method="POST">
        @csrf
        <div>
            <label class="block text-gray-700 font-bold mb-2" for="name">{{ __('general-settings::messages.name_label') }}</label>
            <input class="form-input rounded-md shadow-lg mt-1 block w-full h-10 border-gray-400" type="text" name="name" id="name" required>
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2" for="value">{{ __('general-settings::messages.value_label') }}</label>
            <input class="form-input rounded-md shadow-lg mt-1 block w-full h-10 border-gray-400" type="text" name="value" id="value" required>
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2" for="type">{{ __('general-settings::messages.type_label') }}</label>
            <select name="type" class="form-select rounded-md shadow-lg mt-1 block w-full h-10">
              <option value="">{{ __('general-settings::messages.type_option_all') }}</option>
              @foreach ($types as $key => $value)
                <option value="{{ $key }}" @if (request('type') == $key) selected @endif>
                    {{ $value }}
                </option>
              @endforeach
            </select>
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2" for="description">{{ __('general-settings::messages.description_label') }}</label>
            <textarea class="form-input rounded-md shadow-lg mt-1 block w-full border-gray-400" name="description" id="description" rows="3"></textarea>
        </div>
        <div>
            <a href="{{ route('admin.general-settings.index') }}">
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" type="button">
                    {{ __('general-settings::messages.go_back') }}
                </button>
            </a>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">{{ __('general-settings::messages.create_button_label') }}</button>
        </div>
    </form>
  </div>
@endsection
