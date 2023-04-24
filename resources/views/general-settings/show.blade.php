@extends('general-settings::layouts.gs-app')

@section('title', __('general-settings::messages.general_settings_show_title'))

@section('content')
  <div class="gs-content">
    <h1 class="gs-heading">{{ __('general-settings::messages.general_settings_show_title') }}</h1>

    <div class="gs-card">
      <div class="gs-card__body">
        <div class="gs-card__row">
          <div class="gs-card__col">
            <p class="gs-card__label">{{ __('general-settings::messages.name_label') }}</p>
            <p class="gs-card__text">{{ $generalSetting->name }}</p>
          </div>
          <div class="gs-card__col">
            <p class="gs-card__label">{{ __('general-settings::messages.type_label') }}</p>
            <p class="gs-card__text">{{ $generalSetting->type }}</p>
          </div>
        </div>
        <div class="gs-card__row">
          <div class="gs-card__col">
            <p class="gs-card__label">{{ __('general-settings::messages.value_label') }}</p>
            <p class="gs-card__text">{{ $generalSetting->value }}</p>
          </div>
        </div>
        <div class="gs-card__row">
          <div class="gs-card__col">
            <p class="gs-card__label">{{ __('general-settings::messages.description_label') }}</p>
            <p class="gs-card__text">{{ $generalSetting->description }}</p>
          </div>
        </div>
      </div>
      <div class="gs-card__footer">
        <a class="gs-link" href="{{ route('admin.general-settings.edit', $generalSetting->id) }}">{{ __('general-settings::messages.edit_link') }}</a>
      </div>
    </div>

  </div>
@endsection
