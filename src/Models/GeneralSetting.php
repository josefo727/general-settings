<?php

namespace Josefo727\GeneralSettings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Josefo727\GeneralSettings\Services\DataType;

class GeneralSetting extends Model
{
    protected $fillable = [
        'name',
        'value',
        'description',
        'type'
    ];

    public static function getValidationRules($type = 'string'): array
    {
        $dataType = new DataType();
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

    public static function getValue(string $name)
    {
        $setting = static::query()->firstWhere('name', '=', $name);

        if (is_null($setting)) {
            return null;
        }

        $dataType = new DataType();

        return $dataType->castForUse($setting->value, $setting->type);
    }
}
