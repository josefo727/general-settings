<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label fw-bold" for="name">{{ __('general-settings::messages.name_label') }}</label>
    <input class="form-control shadow-sm" type="text" name="name" value="{{ $generalSetting->name }}" id="name" required>
  </div>
  <div class="col-md-6">
    <label class="form-label fw-bold" for="value">{{ __('general-settings::messages.value_label') }}</label>
    <input class="form-control shadow-sm" type="text" name="value" id="value" value="{{ request()->route()->getName() == 'admin.general-settings.edit' ? $generalSetting->valueForDisplay : $generalSetting->value }}" required>
  </div>
  <div class="col-md-6">
    <label class="form-label fw-bold" for="type">{{ __('general-settings::messages.type_label') }}</label>
    <select name="type" class="form-select shadow-sm">
      <option value="">{{ __('general-settings::messages.type_option_all') }}</option>
      @foreach ($types as $key => $value)
      <option value="{{ $key }}" @if ($generalSetting->type == $key) selected @endif>{{ $value }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-12">
    <label class="form-label fw-bold" for="description">{{ __('general-settings::messages.description_label') }}</label>
    <textarea class="form-control shadow-sm" name="description" id="description" rows="3">{{ $generalSetting->description }}</textarea>
  </div>
  <div class="col-12">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <a href="{{ route('admin.general-settings.index') }}" class="btn btn-secondary me-md-2">{{ __('general-settings::messages.go_back') }}</a>
      <button type="submit" class="btn btn-primary">{{ __('general-settings::messages.save_button_label') }}</button>
    </div>
  </div>
</div>
