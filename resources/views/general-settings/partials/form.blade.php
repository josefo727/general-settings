<div class="mt-2">
    <label class="block text-gray-700 font-bold mb-2" for="name">{{ __('general-settings::messages.name_label') }}</label>
    <input
        class="form-input rounded-md shadow-lg mt-1 block w-full h-10 border-gray-400"
        type="text"
        name="name"
        value="{{ $generalSetting->name }}"
        id="name"
        required
    />
</div>
<div class="mt-2">
    <label class="block text-gray-700 font-bold mb-2" for="value">{{ __('general-settings::messages.value_label') }}</label>
    <input
        class="form-input rounded-md shadow-lg mt-1 block w-full h-10 border-gray-400"
        type="text"
        name="value"
        id="value"
        value="{{ request()->route()->getName() == 'admin.general-settings.edit' ? $generalSetting->valueForDisplay : $generalSetting->value }}"
        required
    />
</div>
<div class="mt-2">
    <label class="block text-gray-700 font-bold mb-2" for="type">{{ __('general-settings::messages.type_label') }}</label>
    <select name="type" class="form-select rounded-md shadow-lg mt-1 block w-full h-10">
      <option value="">{{ __('general-settings::messages.type_option_all') }}</option>
      @foreach ($types as $key => $value)
        <option value="{{ $key }}" @if ($generalSetting->type == $key) selected @endif>
            {{ $value }}
        </option>
      @endforeach
    </select>
</div>
<div class="mt-2">
    <label class="block text-gray-700 font-bold mb-2" for="description">{{ __('general-settings::messages.description_label') }}</label>
    <textarea
        class="form-input rounded-md shadow-lg mt-1 block w-full border-gray-400"
        name="description"
        id="description"
        rows="3"
    >{{ $generalSetting->description }}</textarea>
</div>
<div class="mt-2">
    <a href="{{ route('admin.general-settings.index') }}">
        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" type="button">
            {{ __('general-settings::messages.go_back') }}
        </button>
    </a>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">{{ __('general-settings::messages.save_button_label') }}</button>
</div>
