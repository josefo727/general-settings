@extends('general-settings::layouts.gs-app')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css">
@endpush

@section('title', __('general-settings::messages.general_settings_edit_title'))

@section('content')
  <div class="bg-white rounded-lg shadow-lg p-6 mt-4">
    <h1 class="text-2xl font-semibold">{{ __('general-settings::messages.general_settings_edit_title') }}</h1>
    @include('general-settings::partials.errors')
    <form class="mt-6" action="{{ route('admin.general-settings.update', $generalSetting->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('general-settings::partials.form')
    </form>
  </div>
@endsection
