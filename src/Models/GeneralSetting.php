<?php

namespace Josefo727\GeneralSettings\Models;

use Illuminate\Database\Eloquent\Model;
use Josefo727\GeneralSettings\Services\DataType;

class GeneralSetting extends Model
{
    protected $fillable = [
        'name',
        'value',
        'description',
        'type'
    ];

    public static function create(array $attributes = [])
    {
        // Gets validation rules for the data type
        $dataType = new DataType();
        $rules = $dataType->getValidationRule($attributes['type']);

        // Validate data
        Validator::make($attributes, [
            'key' => 'required|string',
            'value' => $rules,
            'type' => 'required|string|in:' . DataType::getListTypes(),
        ])->validate();

        // Creates the object and saves the data
        $setting = new static($attributes);
        $setting->save();

        return $setting;
    }
}
