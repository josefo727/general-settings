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

    /** @test */
    public function should_return_general_settings_create_view()
    {
        $response = $this->get(route('admin.general-settings.create'));

        $response->assertStatus(200)
            ->assertViewIs('general-settings::create')
            ->assertSee(__('general-settings::messages.general_settings_create_title'))
            ->assertSee(__('general-settings::messages.type_option_all'))
            ->assertSee(__('general-settings::messages.name_label'))
            ->assertSee(__('general-settings::messages.type_label'))
            ->assertSee(__('general-settings::messages.value_label'))
            ->assertSee(__('general-settings::messages.description_label'));
    }

    /** @test */
    public function should_return_general_settings_show_view()
    {
        $this->withoutExceptionHandling();
        $generalSetting = GeneralSetting::create([
                'name' => 'SITE_URL',
                'type' => 'url',
                'value' => 'https://jose-gutierrez.com/',
                'description' => 'Url acces',
            ]);

        $response = $this->get(route('admin.general-settings.show', $generalSetting->id));

        $response->assertSuccessful();
        $response->assertViewIs('general-settings::show');
        $response->assertViewHas('generalSetting', $generalSetting);
        $response->assertSee($generalSetting->name);
        $response->assertSee($generalSetting->type);
        $response->assertSee($generalSetting->value);
        $response->assertSee($generalSetting->description);
    }

    /** @test */
    public function should_return_validation_errors_when_store_method_fails_validation()
    {
        // Act
        $response = $this->post(route('admin.general-settings.store'), []);

        // Assert
        $response->assertStatus(200)
            ->assertViewIs('general-settings::create')
            ->assertSee(__('general-settings::messages.general_settings_create_title'))
            ->assertSee(__('general-settings::messages.type_option_all'))
            ->assertSee(__('general-settings::messages.name_label'))
            ->assertSee(__('general-settings::messages.type_label'))
            ->assertSee(__('general-settings::messages.value_label'))
            ->assertSee(__('general-settings::messages.description_label'));

        $errors = $response->original->getData()['errors'];
        $this->assertTrue(isset($errors['name']));
        $this->assertTrue(isset($errors['value']));
        $this->assertTrue(isset($errors['type']));
    }

    /** @test */
    public function should_create_general_setting_and_redirect_to_show_if_store_is_successful()
    {
        // Arrange
        $data = [
            'name' => 'Test Name',
            'value' => 'Test Value',
            'description' => 'Test Description',
            'type' => 'string'
        ];

        // Act
        $response = $this->post(route('admin.general-settings.store'), $data);

        // Assert
        $this->assertDatabaseHas('general_settings', $data);
        $generalSetting = GeneralSetting::where($data)->firstOrFail();

        $response->assertRedirect(route('admin.general-settings.show', $generalSetting->id));
    }

    /** @test */
    public function should_return_general_settings_edit_view()
    {
        $this->withoutExceptionHandling();
        $generalSetting = GeneralSetting::create([
                'name' => 'SITE_URL',
                'type' => 'url',
                'value' => 'https://jose-gutierrez.com/',
                'description' => 'Url acces',
            ]);

        $response = $this->get(route('admin.general-settings.edit', $generalSetting->id));

        $response->assertSuccessful();
        $response->assertViewIs('general-settings::edit');
        $response->assertViewHas('generalSetting', $generalSetting);
        $response->assertSee($generalSetting->name);
        $response->assertSee($generalSetting->type);
        $response->assertSee($generalSetting->value);
        $response->assertSee($generalSetting->description);
    }

    /** @test */
    public function should_return_validation_errors_when_update_method_fails_validation()
    {
        $generalSetting = GeneralSetting::create([
                'name' => 'SITE_URL',
                'type' => 'url',
                'value' => 'https://jose-gutierrez.com/',
                'description' => 'Url acces',
            ]);

        $response = $this->put(route('admin.general-settings.update', $generalSetting), [
            'name' => '',
            'type' => 'url',
            'value' => 'https://jose-gutierrez.com/',
            'description' => 'Url acces',
        ]);

        // Assert
        $response->assertStatus(200)
            ->assertViewIs('general-settings::edit')
            ->assertSee(__('general-settings::messages.general_settings_edit_title'))
            ->assertSee(__('general-settings::messages.type_option_all'))
            ->assertSee(__('general-settings::messages.name_label'))
            ->assertSee(__('general-settings::messages.type_label'))
            ->assertSee(__('general-settings::messages.value_label'))
            ->assertSee(__('general-settings::messages.description_label'));

        $errors = $response->original->getData()['errors'];
        $this->assertTrue(isset($errors['name']));
    }

    /** @test */
    public function should_update_and_redirect_to_show_if_update_is_successful()
    {
        $generalSetting = GeneralSetting::create([
                'name' => 'SITE_URL',
                'type' => 'url',
                'value' => 'https://jose-gutierrez.com/',
                'description' => 'Url acces',
            ]);

        $response = $this->put(route('admin.general-settings.update', $generalSetting), [
            'name' => 'SITE_URL_UPDATED',
            'type' => 'string',
            'value' => 'https://jose-gutierrez.com/upate',
            'description' => 'Updated description',
        ]);

        $response->assertRedirect(route('admin.general-settings.show', $generalSetting->id));
        $this->assertDatabaseHas('general_settings', [
            'id' => $generalSetting->id,
            'name' => 'SITE_URL_UPDATED',
            'type' => 'string',
            'value' => 'https://jose-gutierrez.com/upate',
            'description' => 'Updated description',
        ]);
    }

    /** @test */
    public function should_delete_general_setting_and_redirect_to_index()
    {
        // Create a test General Setting
        $generalSetting = GeneralSetting::create([
                'name' => 'SITE_URL',
                'type' => 'url',
                'value' => 'https://jose-gutierrez.com/',
                'description' => 'Url acces',
            ]);

        // Send DELETE request to delete the General Setting
        $response = $this->delete(route('admin.general-settings.destroy',  $generalSetting->id));

        // Assert that the response is a redirect to the index page
        $response->assertRedirect(route('admin.general-settings.index'));

        // Assert that the General Setting was deleted
        $this->assertDatabaseMissing('general_settings', [
            'id' => $generalSetting->id,
        ]);
    }

}
