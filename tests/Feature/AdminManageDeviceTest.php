<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\TestResponse;

class AdminManageDeviceTest extends TestCase
{

    private $admin;
    private $user;
    private $deviceData;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true
        ]);

        // Sample device data for testing
        $this->deviceData = [
            'name' => 'Test Device',
            'type' => 'Laptop',
            'manufacturer' => 'Test Manufacturer',
            'specifications' => 'Test Specs',
            'count' => 1,
            'status' => Device::STATUS_AVAILABLE
        ];
    }

    public function test_admin_can_access_device_crud()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('devices.create'));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_device()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('devices.store'), $this->deviceData);

        $response->assertRedirect(route('devices.index'));
        $this->assertDatabaseHas('devices', [
            'name' => 'Test Device',
            'type' => 'Laptop',
            'manufacturer' => 'Test Manufacturer'
        ]);
    }

    public function test_admin_can_view_device_list()
    {
        $device = Device::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('devices.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Devices/Index')
            ->has('devices.data')
        );
    }

    public function test_admin_can_edit_device()
    {
        $device = Device::factory()->create([
            'name' => 'ThinkPad',
            'type' => 'laptop', 
            'manufacturer' => 'Lenovo',
            'status' => Device::STATUS_AVAILABLE,
        ]);

        if (!$device) {
            $this->fail('Gagal membuat device untuk testing.');
        }
        $updatedData = array_merge($this->deviceData, [
            'name' => 'Updated Device Name'
        ]);

        $response = $this->actingAs($this->admin)
            ->put(route('devices.update', $device), $updatedData);

        $response->assertRedirect(route('devices.index'));
        $this->assertDatabaseHas('devices', [
            'id' => $device->id,
            'name' => 'Updated Device Name'
        ]);
    }

    public function test_admin_can_delete_device()
    {
        $device = Device::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('devices.destroy', $device));

        $response->assertRedirect(route('devices.index'));
        $this->assertDatabaseMissing('devices', [
            'id' => $device->id
        ]);
    }

    public function test_admin_can_view_single_device()
    {
        $device = Device::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('devices.show', $device));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Devices/Show')
            ->has('device')
        );
    }
}