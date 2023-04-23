<?php

namespace Josefo727\GeneralSettings\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Josefo727\GeneralSettings\Models\GeneralSetting;
use Josefo727\GeneralSettings\Tests\TestCase;
use Illuminate\Http\Request;

class GeneralSettingControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_return_general_settings_list_view()
    {
        $this->withoutExceptionHandling();
        // Create some test data
        $now = now();
        $settings = [
            [
                'name' => 'SITE_NAME',
                'type' => 'string',
                'value' => 'My Site',
                'description' => 'My web site',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'SITE_URL',
                'type' => 'url',
                'value' => 'https://jose-gutierrez.com/',
                'description' => 'Url acces',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'MY_EMAIL',
                'type' => 'email',
                'value' => 'josefo727@gmail.com',
                'description' => 'My email',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        GeneralSetting::insert($settings);

        // Validate that the facade route generates the correct url
        $url = route('admin.general-settings.index');
        $this->assertEquals('http://localhost/admin/general-settings', $url);

        $response = $this->get($url);

        // Generate the expected response
        $request = new Request();
        $generalSettings = GeneralSetting::query()
            ->applyFilters($request)
            ->paginate(5);

        // Verify that the view is loaded and has test data
        $response->assertStatus(200);
        $response->assertViewIs('general-settings::index');
        $response->assertViewHas('settings', $generalSettings);
    }

}
