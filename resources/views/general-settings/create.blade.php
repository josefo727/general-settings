@extends('general-settings::layouts.gs-app')

@section('title', __('general-settings::messages.general_settings_create_title'))

@section('content')
  <div class="gs-content">
    <h1 class="gs-heading">{{ __('general-settings::messages.general_settings_create_title') }}</h1>
    <form class="gs-form" action="{{ route('admin.general-settings.store') }}" method="POST">
        @csrf
        <div class="gs-form__group">
            <label class="gs-form__label" for="name">{{ __('general-settings::messages.name_label') }}</label>
            <input class="gs-form__input" type="text" name="name" id="name" required>
        </div>
        <div class="gs-form__group">
            <label class="gs-form__label" for="value">{{ __('general-settings::messages.value_label') }}</label>
            <input class="gs-form__input" type="text" name="value" id="value" required>
        </div>
        <div class="gs-form__group">
            <label class="gs-label">{{ __('general-settings::messages.type_label') }}</label>
            <select name="type" class="gs-select">
              <option value="">{{ __('general-settings::messages.type_option_all') }}</option>
              @foreach ($types as $key => $value)
                <option value="{{ $key }}" @if (request('type') == $key) selected @endif>
                    {{ $value }}
                </option>
              @endforeach
            </select>
        </div>
        <div class="gs-form__group">
            <label class="gs-form__label" for="description">{{ __('general-settings::messages.description_label') }}</label>
            <textarea class="gs-form__input" name="description" id="description" rows="3"></textarea>
        </div>
        <div class="gs-form__group">
            <button class="gs-form__button" type="submit">Create Setting</button>
        </div>
    </form>
  </div>
@endsection