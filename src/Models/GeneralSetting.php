<?php

namespace Josefo727\GeneralSettings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Josefo727\GeneralSettings\Services\DataTypeService;
use Josefo727\GeneralSettings\Services\EncryptionService;
use Illuminate\Support\Facades\Config;

class GeneralSetting extends Model
{
    protected $fillable = [
        'name',
        'value',
        'description',
        'type'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($setting) {
            $setting->setValue();
        });
    }

    public static function getValidationRules($type = 'string'): array
    {
        $dataType = new DataTypeService();
        $rules = $dataType->getValidationRule($type);

        return [
            'name' => 'required|string|unique:general_settings,name',
            'value' => $rules,
            'description' => 'nullable|string',
            'type' => 'required|string|in:' . $dataType->getListTypes(),
        ];
    }

    public static function create(array $attributes = [])
    {
        // Validate data
        Validator::make(
            $attributes,
            self::getValidationRules($attributes['type'])
        )->validate();

        // Creates the object and saves the data
        $setting = new static($attributes);
        $setting->save();

        return $setting;
    }

    public static function updateSetting(GeneralSetting $setting, array $attributes = [], array $options = [])
    {
        Validator::make(
            $attributes,
            self::getValidationRules($attributes['type'])
        )->validate();

        $setting->fill($attributes)->save($options);

        return $setting;
    }

    public function setValue()
    {
        // Validate if the encryption configuration is enabled and if the type of value is password.
        if (Config::get('general_settings.encryption.enabled') && $this->type === 'password') {
            // If so, we encrypt the value before saving it
            $encryption = new EncryptionService();
            $this->value = $encryption->encrypt($this->value);
        }
    }

    public function getValueForDisplay()
    {
        if ($this->type !== 'password') {
            return $this->value;
        }

        if (!Config::get('general_settings.show_passwords')) {
            return '';
        }

        if (Config::get('general_settings.encryption.enabled')) {
            $dataType = new DataTypeService();
            return $dataType->castForUse($this->value, 'password');
        }

        return $this->value;
    }

    public static function getValue(string $name)
    {
        $setting = static::query()->firstWhere('name', '=', $name);

        if (is_null($setting)) {
            return null;
        }

        $dataType = new DataTypeService();

        return $dataType->castForUse($setting->value, $setting->type);
    }
}
