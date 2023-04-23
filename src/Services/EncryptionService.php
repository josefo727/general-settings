<?php

namespace Josefo727\GeneralSettings\Services;

use Illuminate\Support\Facades\Config;

class EncryptionService
{
    private $key;

    public function __construct()
    {
        $this->key = Config::get('general_settings.encryption.key');
    }

    public function encrypt($value)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
        $encryptedValue = openssl_encrypt($value, 'AES-256-CBC', $this->key, 0, $iv);

        return base64_encode($iv . $encryptedValue);
    }

    public function decrypt($encryptedValue)
    {
        $data = base64_decode($encryptedValue);
        $iv = substr($data, 0, openssl_cipher_iv_length('AES-256-CBC'));
        if(strlen($iv) !== openssl_cipher_iv_length('AES-256-CBC')) {
            return null;
        }
        $value = openssl_decrypt(substr($data, openssl_cipher_iv_length('AES-256-CBC')), 'AES-256-CBC', $this->key, 0, $iv);

        return $value;
    }
}
