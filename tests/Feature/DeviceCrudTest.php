<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_dapat_melihat_list_perangkat()
    {
        $this->actingAs($this->user)
             ->get('/devices')
             ->assertStatus(200);
    }

    public function test_user_dapat_menambah_perangkat()
    {
        $deviceData = [
            'name' => 'Test Device',
            'type' => 'Laptop',
            'manufacturer' => 'Test Manufacturer',
            'status' => Device::STATUS_AVAILABLE,
        ];

        $this->actingAs($this->user)
             ->post('/devices', $deviceData)
             ->assertRedirect('/devices');

        $this->assertDatabaseHas('devices', $deviceData);
    }

    public function test_user_dapat_update_perangkat()
    {
        $device = Device::factory()->create();
        $updatedData = [
            'name' => 'Updated Device',
            'type' => 'Smartphone',
            'manufacturer' => 'Updated Manufacturer',
            'status' => Device::STATUS_IN_USE,
        ];

        $this->actingAs($this->user)
             ->put("/devices/{$device->id}", $updatedData)
             ->assertRedirect('/devices');

        $this->assertDatabaseHas('devices', $updatedData);
    }

    public function test_user_dapat_delete_perangkat()
    {
        $device = Device::factory()->create();

        $this->actingAs($this->user)
             ->delete("/devices/{$device->id}")
             ->assertRedirect('/devices');

        $this->assertDatabaseMissing('devices', ['id' => $device->id]);
    }

    public function test_user_dapat_melihat_single_perangkat()
    {
        $device = Device::factory()->create();

        $this->actingAs($this->user)
             ->get("/devices/{$device->id}")
             ->assertStatus(200);
    }
}
