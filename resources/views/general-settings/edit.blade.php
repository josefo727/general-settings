@extends('general-settings::layouts.gs-app')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css">
@endpush

@section('title', __('general-settings::messages.general_settings_edit_title'))

@section('content')
  <div class="bg-white rounded-lg shadow-lg p-6 mt-4">
    <h1 class="text-2xl font-semibold">{{ __('general-settings::messages.general_settings_edit_title') }}</h1>
    <form class="mt-6" action="{{ route('admin.general-settings.update', $generalSetting->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block font-medium text-gray-700" for="name">{{ __('general-settings::messages.name_label') }}</label>
            <input class="form-input rounded-md shadow-lg mt-1 block w-full h-10 border-gray-400" type="text" name="name" id="name" value="{{ $generalSetting->name }}" required>
            @error('name')
                <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block font-medium text-gray-700" for="value">{{ __('general-settings::messages.value_label') }}</label>
            <input class="form-input rounded-md shadow-lg mt-1 block w-full h-10 border-gray-400" type="text" name="value" id="value" value="{{ $generalSetting->value }}" required>
            @error('value')
                <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block font-medium text-gray-700" for="type">{{ __('general-settings::messages.type_label') }}</label>
            <select name="type" class="form-select rounded-md shadow-lg mt-1 block w-full h-10">
              <option value="">{{ __('general-settings::messages.type_option_all') }}</option>
              @foreach ($types as $key => $value)
                <option value="{{ $key }}" @if ($generalSetting->type == $key) selected @endif>
                    {{ $value }}
                </option>
              @endforeach
            </select>
            @error('type')
                <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block font-medium text-gray-700" for="description">{{ __('general-settings::messages.description_label') }}</label>
            <textarea class="form-input rounded-md shadow-lg mt-1 block w-full border-gray-400" name="description" id="description" rows="3">{{ $generalSetting->description }}</textarea>
            @error('description')
                <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <a href="{{ route('admin.general-settings.index') }}">
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" type="button">
                        {{ __('general-settings::messages.go_back') }}
                    </button>
            </a>
            <button class="px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue active:bg-blue-800" type="submit">{{ __('general-settings::messages.edit_button_label') }}</button>
        </div>
    </form>
  </div>
@endsection
