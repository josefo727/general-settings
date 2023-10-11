@extends('general-settings::layouts.gs-app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
@endpush

@section('title', __('general-settings::messages.general_settings_show_title'))

@section('content')
<div class="bg-gray-100 py-6">
  <div class="container-lg">
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
      <div class="p-4">
        <h1 class="text-2xl font-bold mb-6">{{ __('general-settings::messages.general_settings_show_title') }}</h1>
        <div class="row row-cols-1 row-cols-md-2 g-4">
          <div class="col">
            <p class="text-sm font-medium text-gray-500">{{ __('general-settings::messages.name_label') }}</p>
            <p class="text-lg">{{ $generalSetting->name }}</p>
          </div>
          <div class="col">
            <p class="text-sm font-medium text-gray-500">{{ __('general-settings::messages.type_label') }}</p>
            <p class="text-lg">{{ $generalSetting->type }}</p>
          </div>
          @if(!!$generalSetting->valueForDisplay)
            <div class="col-12">
              <p class="text-sm font-medium text-gray-500">{{ __('general-settings::messages.value_label') }}</p>
              <p class="text-lg">{{ $generalSetting->valueForDisplay }}</p>
            </div>
          @endif
          <div class="col-12">
            <p class="text-sm font-medium text-gray-500">{{ __('general-settings::messages.description_label') }}</p>
            <p class="text-lg">{{ $generalSetting->description }}</p>
          </div>
        </div>
        <div class="mt-6">
          <a href="{{ route('admin.general-settings.index') }}" class="btn btn-sm btn-success">{{ __('general-settings::messages.go_back') }}</a>
          <a href="{{ route('admin.general-settings.edit', $generalSetting->id) }}" class="btn btn-sm btn-primary mx-2">{{ __('general-settings::messages.edit_link') }}</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
