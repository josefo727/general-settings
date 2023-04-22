<?php

namespace Josefo727\GeneralSettings\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Config;
use Josefo727\GeneralSettings\Tests\TestCase;
use Josefo727\GeneralSettings\Services\DataType;

class DataTypeTest extends TestCase
{
    public $dataType;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dataType = new DataType();
    }

    /** @test */
    public function should_cast_for_use_returns_correct_value_for_string()
    {
        $result = $this->dataType->castForUse('hello', 'string');
        $this->assertSame('hello', $result);
    }

    /** @test */
    public function should_cast_for_use_returns_correct_value_for_integer()
    {
        $result = $this->dataType->castForUse('123', 'integer');
        $this->assertSame(123, $result);
    }

    /** @test */
    public function should_cast_for_use_returns_correct_value_for_float()
    {
        $result = $this->dataType->castForUse('123.55', 'float');
        $this->assertSame(123.55, $result);
    }

    /** @test */
    public function should_cast_for_use_returns_correct_value_for_boolean_from_string()
    {
        $result = $this->dataType->castForUse('true', 'boolean');
        $this->assertTrue($result);
    }

    /** @test */
    public function should_cast_for_use_returns_correct_value_for_boolean_from_numeric()
    {
        $result = $this->dataType->castForUse('0', 'boolean');
        $this->assertFalse($result);
    }

    /** @test */
    public function should_cast_for_use_returns_correct_value_for_array()
    {
        $result = $this->dataType->castForUse('element 1 ,element2, element_3', 'array');
        $this->assertSame(['element 1', 'element2', 'element_3'], $result);
    }

    /** @test */
    public function should_cast_for_use_returns_correct_value_for_json()
    {
        $data = [
            'name' => 'John',
            'age' => 30,
            'city' => 'New York'
        ];
        $json = json_encode($data);
        $result = $this->dataType->castForUse($json, 'json');
        $this->assertSame($data, $result);
    }

    /** @test */
    public function should_cast_for_use_returns_correct_value_for_date()
    {
        // Arrange
        $inputDate = '2022-01-31';
        $expectedOutputDate = Carbon::parse($inputDate); // or any other expected format
        $type = 'date';

        // Act
        $preparedDate = $this->dataType->castForUse($inputDate, $type);

        // Assert
        $this->assertTrue($expectedOutputDate->gte($preparedDate));
    }

    /** @test */
    public function should_cast_for_use_returns_correct_value_for_time()
    {
        // Arrange
        $inputDate = '10:25';
        $expectedOutputDate = Carbon::parse($inputDate); // or any other expected format
        $type = 'time';

        // Act
        $preparedDate = $this->dataType->castForUse($inputDate, $type);

        // Assert
        $this->assertTrue($expectedOutputDate->gte($preparedDate));
    }

    /** @test */
    public function should_cast_for_use_returns_correct_value_for_date_time()
    {
        // Arrange
        $inputDate = '2023-04-18 10:25';
        $expectedOutputDate = Carbon::parse($inputDate); // or any other expected format
        $type = 'date_time';

        // Act
        $preparedDate = $this->dataType->castForUse($inputDate, $type);

        // Assert
        $this->assertTrue($expectedOutputDate->gte($preparedDate));
    }

    /** @test */
    public function should_cast_for_use_returns_correct_value_for_unencrypted_password()
    {
        Config::set('general_settings.encryption.enabled', false);
        $value = Str::random();
        $type = 'password';

        $result = $this->dataType->castForUse($value, $type);

        $this->assertSame($value, $result);
    }

    /** @test */
    public function should_cast_for_use_returns_correct_value_for_encrypted_password()
    {
        Config::set('general_settings.encryption.enabled', true);
        $encryptionKey = Config::get('general_settings.encryption.key');
        $encrypter = new Encrypter($encryptionKey);

        Crypt::setFacadeApplication([
            'encrypter' => $encrypter,
        ]);

        $value = Str::random();
        $valueEncrypted = Crypt::encrypt($value);
        $type = 'password';

        $result = $this->dataType->castForUse($valueEncrypted, $type);

        $this->assertSame($value, $result);
    }

    /** @test */
    public function should_return_array_of_emails_for_emails_type()
    {
        $value = 'johndoe@example.com,jane.doe@example.com';
        $type = 'emails';

        $result = $this->dataType->castForUse($value, $type);
        $expectedResult = ['johndoe@example.com', 'jane.doe@example.com'];

        $this->assertEquals($expectedResult, $result);
    }

    /** @test */
    public function should_get_validation_rule_returns_correct_rule()
    {
        $result = $this->dataType->getValidationRule('string');
        $this->assertSame('required|string', $result);
    }

    /** @test */
    public function should_return_correct_type_info_for_getType()
    {
        $result = $this->dataType->getTypeInfo('string');
        $expectedResult = [
            'name' => 'Texto',
            'rules' => 'required|string',
        ];
        unset($result['prepareForUse']);
        $this->assertSame($expectedResult, $result);
    }

    /** @test */
    public function should_get_list_types_returns_comma_separated_list()
    {
        $result = $this->dataType->getListTypes();
        $this->assertSame(
            'string,integer,float,boolean,array,json,date,time,datetime,url,email,emails,password',
            $result
        );
    }
}
