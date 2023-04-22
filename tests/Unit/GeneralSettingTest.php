<?php

namespace Josefo727\GeneralSettings\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Josefo727\GeneralSettings\Models\GeneralSetting;
use Josefo727\GeneralSettings\Services\DataType;
use Josefo727\GeneralSettings\Tests\TestCase;

class GeneralSettingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_create_general_setting()
    {
        // Mocking data
        $data = [
            'name' => 'test',
            'value' => 123,
            'description' => 'testing',
            'type' => 'integer',
        ];

        // Creating general setting
        GeneralSetting::create($data);

        // Asserting that the setting was created and saved
        $this->assertDatabaseHas('general_settings', [
            'name' => $data['name'],
            'value' => $data['value'],
            'description' => $data['description'],
            'type' => $data['type'],
        ]);
    }

    /** @test */
    public function should_fail_when_required_fields_are_missing()
    {
        // Validating with missing required fields
        $validator = Validator::make([], GeneralSetting::getValidationRules());

        // Asserting that the validator fails and the required fields are in the errors messages
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
        $this->assertArrayHasKey('value', $validator->errors()->toArray());
        $this->assertArrayHasKey('type', $validator->errors()->toArray());
    }

    /** @test */
    public function should_fail_when_type_is_invalid()
    {
        // Mocking data with invalid type
        $data = [
            'name' => 'test',
            'value' => 'invalid',
            'description' => 'testing',
            'type' => 'invalid_type',
        ];

        // Validating with invalid type
        $validator = Validator::make($data, GeneralSetting::getValidationRules());

        // Asserting that the validator fails and the type field is in the errors messages
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('type', $validator->errors()->toArray());
    }

    /** @test */
    public function should_fail_when_value_is_invalid_for_type()
    {
        // Mocking data with invalid value for type
        $data = [
            'name' => 'test',
            'value' => 'invalid',
            'description' => 'testing',
            'type' => 'integer',
        ];

        // Validating with invalid value for type
        $validator = Validator::make($data, GeneralSetting::getValidationRules($data['type']));

        // Asserting that the validator fails and the value field is in the errors messages
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('value', $validator->errors()->toArray());
    }

    /** @test */
    public function should_return_null_when_setting_does_not_exist()
    {
        $this->assertNull(GeneralSetting::getValue('non_existing_setting'));
    }

    /** @test */
    public function should_return_default_when_setting_does_not_exist()
    {
        $this->assertEquals(null, GeneralSetting::getValue('non_existing_setting'));
    }

    /** @test */
    public function should_return_value_when_setting_exists()
    {
        GeneralSetting::create([
            'name' => 'test_setting',
            'value' => 'test_value',
            'description' => 'Test setting',
            'type' => 'string',
        ]);

        $this->assertEquals('test_value', GeneralSetting::getValue('test_setting'));
    }

    /** @test */
    public function should_return_casted_value_when_setting_exists()
    {
        GeneralSetting::create([
            'name' => 'test_setting',
            'value' => '123',
            'description' => 'Test setting',
            'type' => 'integer',
        ]);

        $this->assertEquals(123, GeneralSetting::getValue('test_setting'));
    }
}
