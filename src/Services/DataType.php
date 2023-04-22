<?php

namespace Josefo727\GeneralSettings\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;

class DataType
{

    protected array $types = [];

    public function __construct()
    {
        $this->setTypes();
    }

    public function castForUse($value, $type)
    {
        return in_array($type, array_keys($this->types))
            ? $this->types[$type]['prepareForUse']($value)
            : $value;
    }

    public function getValidationRule($type)
    {
        return in_array($type, array_keys($this->types))
            ? $this->types[$type]['rules']
            : '';
    }

    public function getTypeInfo($type)
    {
        return $this->types[$type];
    }

    public function getListTypes()
    {
        return implode(',', array_keys($this->types));
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function setTypes()
    {
        $formatDate = Config::get('general_settings.out_format.date');
        $formatTime = Config::get('general_settings.out_format.time');
        $formatDateTime = Config::get('general_settings.out_format.date_time');
        $this->types = [
            'string' => [
                'name' => 'Texto',
                'rules' => 'unique|string',
                'prepareForUse' => fn($value) => (string) $value,
            ],
            'integer' => [
                'name' => 'Entero',
                'rules' => 'unique|integer',
                'prepareForUse' => fn($value) => (int) $value
            ],
            'float' => [
                'name' => 'Flotante',
                'rules' => 'unique|numeric',
                'prepareForUse' => fn($value) => (float) $value
            ],
            'boolean' => [
                'name' => 'Booleano',
                'rules' => 'unique|boolean',
                'prepareForUse' => fn($value) => boolval($value)
            ],
            'array' => [
                'name' => 'Arreglo',
                'rules' => 'unique|string|regex:/^[^,]+(,[^,]+)*$/',
                'prepareForUse' => function($value) {
                        $valye = preg_replace('/\s*,\s*/', ',', $value);
                        return explode(',', $valye);
                    }
            ],
            'json' => [
                'name' => 'JSON',
                'rules' => 'unique|json',
                'prepareForUse' => fn($value) => json_decode($value, true)
            ],
            'date' => [
                'name' => 'Fecha',
                'rules' => 'unique|date',
                'prepareForUse' => fn($value) => Carbon::parse($value)
            ],
            'time' => [
                'name' => 'Hora',
                'rules' => 'unique|date_format:H:i:s',
                'prepareForUse' => fn($value) => Carbon::parse($value)
            ],
            'datetime' => [
                'name' => 'Fecha y hora',
                'rules' => 'unique|date_format:Y-m-d H:i:s',
                'prepareForUse' => fn($value) => Carbon::parse($value)
            ],
            'url' => [
                'name' => 'URL',
                'rules' => 'unique|url',
                'prepareForUse' => fn($value) => $value
            ],
            'email' => [
                'name' => 'Correo electrónico',
                'rules' => 'unique|email',
                'prepareForUse' => fn($value) => $value
            ],
            'emails' => [
                'name' => 'Correos electrónicos',
                'rules' => 'unique|string|regex:/^([\w+-.%]+@[\w.-]+\.[A-Za-z]{2,4})(,[\w+-.%]+@[\w.-]+\.[A-Za-z]{2,4})*$/',
                'prepareForUse' => fn($value) => explode(',', $value)
            ],
            'password' => [
                'name' => 'Contraseña',
                'rules' => 'unique|string|min:4',
                'prepareForUse' => function ($value) {
                        $isEncrypted = Config::get('general_settings.encryption.enabled');
                        return $isEncrypted
                            ? Crypt::decrypt($value)
                            : $value;
                    }
            ]
        ];
    }
}
