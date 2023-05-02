<?php

namespace Josefo727\GeneralSettings\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Josefo727\GeneralSettings\Services\DataTypeService;
use Josefo727\GeneralSettings\Services\EncryptionService;
use Illuminate\Support\Facades\Config;

/**
 * @method static \Illuminate\Database\Eloquent\Builder applyFilters(Request $request)
 */
class GeneralSetting extends Model
{
    protected $fillable = [
        'name',
        'value',
        'description',
        'type'
    ];

    protected $appends = [
        'valueForDisplay'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($setting) {
            $setting->setValue();
        });

        static::updating(function ($setting) {
            $setting->setValue();
        });
    }

    /**
     * @param mixed $type
     * @param mixed $id
     * @return array<string,mixed>
     */
    public static function getValidationRules($type = null, $id = null): array
    {
        $dataType = new DataTypeService();
        $rules = $dataType->getValidationRule($type) ?: 'required';

        return [
            'name' => 'required|string|unique:general_settings,name,'.$id,
            'value' => $rules,
            'description' => 'nullable|string',
            'type' => 'required|string|in:' . $dataType->getListTypes(),
        ];
    }

    /**
     * @return GeneralSetting
     * @param array<int,mixed> $attributes
     */
    public static function create(array $attributes = []): GeneralSetting
    {
        if (isset($attributes['type']) && in_array($attributes['type'], ['emails', 'array']) && isset($attributes['value'])) {
            $value = preg_replace('/\s+/', ' ', $attributes['value']);
            $attributes['value'] = preg_replace('/\s*,\s*/', ',', $value);
        }
        // Validate data
        Validator::make(
            $attributes,
            self::getValidationRules($attributes['type'] ?? null)
        )->validate();

        // Creates the object and saves the data
        $setting = new static($attributes);
        $setting->save();

        return $setting;
    }

    /**
     * @return GeneralSetting
     * @param array<int,mixed> $attributes
     * @param array<int,mixed> $options
     */
    public static function updateSetting(GeneralSetting $setting, array $attributes = [], array $options = []): GeneralSetting
    {
        if (isset($attributes['type']) && in_array($attributes['type'], ['emails', 'array']) && isset($attributes['value'])) {
            $value = preg_replace('/\s+/', ' ', $attributes['value']);
            $attributes['value'] = preg_replace('/\s*,\s*/', ',', $value);
        }
        // Validate data
        Validator::make(
            $attributes,
            self::getValidationRules($attributes['type'] ?? null, $setting->id)
        )->validate();

        $setting->fill($attributes)->save($options);

        return $setting;
    }

    /**
     * @return void
     */
    public function setValue(): void
    {
        // Validate if the encryption configuration is enabled and if the type of value is password.
        if (Config::get('general_settings.encryption.enabled') && $this->type === 'password') {
            // If so, we encrypt the value before saving it
            $encryption = new EncryptionService();
            $this->value = $encryption->encrypt($this->value);
        }
    }

    /**
     * @return <missing>|string
     */
    public function getValueForDisplayAttribute()
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

    /**
     * @return null|<missing>
     */
    public static function getValue(string $name)
    {
        $setting = static::query()->firstWhere('name', '=', $name);

        if (is_null($setting)) {
            return null;
        }

        $dataType = new DataTypeService();

        return $dataType->castForUse($setting->value, $setting->type);
    }

    /**
     * @return Builder
     */
    public function scopeApplyFilters(Builder $query, Request $request): Builder
    {
        return $query->when(!!$request->name, function ($query) use ($request) {
                $query->where('name', 'LIKE', "%$request->name%");
            })
            ->when(!!$request->type, function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->when(!!$request->value, function ($query) use ($request) {
                $query->where('value', 'LIKE', "%$request->value%");
            });
    }

}
