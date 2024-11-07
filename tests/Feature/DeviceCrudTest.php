<?php
namespace Tests\Feature;

use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\TestResponse;

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
        $response = $this->actingAs($this->user)->get('/devices');

        if ($response->status() !== 200) {
            $this->fail('Gagal mengakses halaman list perangkat. Status code: ' . $response->status() .
                       '. Response: ' . $response->content());
        }

        $response->assertStatus(200);
    }

    public function test_user_dapat_menambah_perangkat()
    {
        $deviceData = [
            'name' => 'Test Device',
            'type' => 'Laptop',
            'manufacturer' => 'Test Manufacturer',
            'status' => Device::STATUS_AVAILABLE,
        ];

        $response = $this->actingAs($this->user)->post('/devices', $deviceData);

        if ($response->status() !== 302) {
            $this->fail('Gagal menambah perangkat. Status code: ' . $response->status() .
                       '. Response: ' . $response->content());
        }

        if (!$deviceData) {

        try {
            $this->assertDatabaseHas('devices', $deviceData);
        } catch (\Exception $e) {
            $this->fail('Data perangkat tidak ditemukan di database. Error: ' . $e->getMessage());
        }

        $response->assertRedirect('/devices');
    }}

    public function test_user_dapat_update_perangkat()
    {
        try {
            $device = Device::factory()->create();
        } catch (\Exception $e) {
            $this->fail('Gagal membuat device untuk testing. Error: ' . $e->getMessage());
        }

        $updatedData = [
            'name' => 'Updated Device',
            'type' => 'Smartphone',
            'manufacturer' => 'Updated Manufacturer',
            'status' => Device::STATUS_IN_USE,
        ];

        $response = $this->actingAs($this->user)
            ->put("/devices/{$device->id}", $updatedData);

        if ($response->status() !== 302) {
            $this->fail('Gagal mengupdate perangkat. Status code: ' . $response->status() .
                       '. Response: ' . $response->content());
        }

        try {
            $this->assertDatabaseHas('devices', $updatedData);
        } catch (\Exception $e) {
            $this->fail('Data update perangkat tidak ditemukan di database. Error: ' . $e->getMessage());
        }

        $response->assertRedirect('/devices');
    }

    public function test_user_dapat_delete_perangkat()
    {
        try {
            $device = Device::factory()->create();
        } catch (\Exception $e) {
            $this->fail('Gagal membuat device untuk testing. Error: ' . $e->getMessage());
        }

        $response = $this->actingAs($this->user)
            ->delete("/devices/{$device->id}");

        if ($response->status() !== 302) {
            $this->fail('Gagal menghapus perangkat. Status code: ' . $response->status() .
                       '. Response: ' . $response->content());
        }

        try {
            $this->assertDatabaseMissing('devices', ['id' => $device->id]);
        } catch (\Exception $e) {
            $this->fail('Data perangkat masih ada di database setelah dihapus. Error: ' . $e->getMessage());
        }

        $response->assertRedirect('/devices');
    }

    public function test_user_dapat_melihat_single_perangkat()
    {
        try {
            $device = Device::factory()->create();
        } catch (\Exception $e) {
            $this->fail('Gagal membuat device untuk testing. Error: ' . $e->getMessage());
        }

        $response = $this->actingAs($this->user)
            ->get("/devices/{$device->id}");

        if ($response->status() !== 200) {
            $this->fail('Gagal mengakses detail perangkat. Status code: ' . $response->status() .
                       '. Response: ' . $response->content());
        }

        $response->assertStatus(200);
    }
}
