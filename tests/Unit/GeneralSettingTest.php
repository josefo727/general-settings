<?php

namespace Josefo727\GeneralSettings\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Josefo727\GeneralSettings\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Josefo727\GeneralSettings\Models\GeneralSetting;

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

    /** @test */
    public function should_encrypt_value_when_encryption_is_enabled()
    {
        // Enable encryption
        Config::set('general_settings.encryption.enabled', true);

        // Create a new setting with password type and a value
        $setting = GeneralSetting::create([
            'name' => 'test_setting',
            'value' => 'password',
            'description' => 'Test setting',
            'type' => 'password',
        ]);

        // Assert that the value in the database is different from the original value
        $this->assertNotEquals('password', $setting->value);

        // Retrieve the setting value
        $value = GeneralSetting::getValue('test_setting');

        // Assert that the retrieved value is equal to the original value
        $this->assertEquals('password', $value);
    }

    /** @test */
    public function should_update_by_overwriting_the_update_method()
    {
        // Arrange
        $setting = GeneralSetting::create([
            'name' => 'test_setting',
            'value' => 'test_value',
            'description' => 'test_description',
            'type' => 'string'
        ]);

        $newAttributes = [
            'name' => 'test_setting_updated',
            'value' => '50',
            'description' => 'test_description_updated',
            'type' => 'integer'
        ];

        // Act
        $updatedSetting = GeneralSetting::updateSetting($setting, $newAttributes);

        // Assert
        $this->assertEquals($newAttributes['name'], $updatedSetting->name);
        $this->assertEquals($newAttributes['value'], $updatedSetting->value);
        $this->assertEquals($newAttributes['description'], $updatedSetting->description);
        $this->assertEquals($newAttributes['type'], $updatedSetting->type);
   }

    /** @test */
    public function should_filter_using_the_apply_filters_scope()
    {
        $setting1 = GeneralSetting::create([
            'name' => 'Setting 1',
            'type' => 'string',
            'value' => 'Value 1',
        ]);

        $setting2 = GeneralSetting::create([
            'name' => 'Setting 2',
            'type' => 'integer',
            'value' => '2',
        ]);

        $request = new Request([
            'name' => 'Setting 1',
            'type' => 'string',
            'value' => 'Value 1',
        ]);

        $results = GeneralSetting::applyFilters($request)->get();

        $this->assertCount(1, $results);
        $this->assertTrue($results->contains($setting1));
        $this->assertFalse($results->contains($setting2));
    }
}
