<?php

use Josefo727\GeneralSettings\Services\EncryptionService;
use Josefo727\GeneralSettings\Tests\TestCase;

class EncryptionServiceTest extends TestCase
{
    /** @test */
    public function should_encrypt_and_decrypt_values()
    {
        $service = new EncryptionService();

        $plainValue = 'hello world';
        $encryptedValue = $service->encrypt($plainValue);
        $decryptedValue = $service->decrypt($encryptedValue);

        $this->assertNotEquals($plainValue, $encryptedValue);
        $this->assertEquals($plainValue, $decryptedValue);
    }

    /** @test */
    public function should_return_null_when_decryption_fails()
    {
        $service = new EncryptionService();

        $encryptedValue = 'invalid_encrypted_value';
        $decryptedValue = $service->decrypt($encryptedValue);

        $this->assertNull($decryptedValue);
    }
}
