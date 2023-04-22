<?php

namespace Josefo727\GeneralSettings\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Josefo727\GeneralSettings\Tests\TestCase;

class MigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_general_settings_table_has_expected_columns()
    {
        // $this->withoutExceptionHandling();

        // Execute the migration
        $this->artisan('migrate', ['--database' => 'testing']);

        // Check that the table exists
        $this->assertTrue(Schema::hasTable('general_settings'));

        // Check that the table has the expected columns
        $this->assertTrue(Schema::hasColumn('general_settings', 'id'));
        $this->assertTrue(Schema::hasColumn('general_settings', 'name'));
        $this->assertTrue(Schema::hasColumn('general_settings', 'value'));
        $this->assertTrue(Schema::hasColumn('general_settings', 'description'));
        $this->assertTrue(Schema::hasColumn('general_settings', 'type'));
    }
}
