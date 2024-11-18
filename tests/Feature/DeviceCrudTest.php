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
        if($response->status() === 404) {
            $this->fail('Halaman tidak ditemukan.');
        }
        $response->assertStatus(200);
    }

    public function test_user_dapat_menambah_perangkat()
    {
        $deviceData = Device::factory()->create([
            'name' => 'Lenovo Legion',
            'type' => '',
            'manufacturer' => 'Lenovo',
            'status' => Device::STATUS_AVAILABLE,
        ]);

        if (empty($deviceData['name'])) {
            $this->fail("Testing gagal: Nama perangkat tidak boleh kosong.");
            return;
        }elseif (empty($deviceData['type'])) {
            $this->fail("Testing gagal: Tipe perangkat tidak boleh kosong.");
            return;
        }elseif (empty($deviceData['manufacturer'])) {
            $this->fail("Testing gagal: Pembuat perangkat tidak boleh kosong.");
            return;
        }

        /* $response = $this->actingAs($this->user)->post('/devices', $deviceData);
        if ($response->status() !== 302) {
            $this->fail('Gagal menambah perangkat. Status code: ' . $response->status() .
                       '. Response: ' . $response->content());
        } */

        $this->assertDatabaseHas('devices', [
            'name' => 'Lenovo Legion',
            'type' => 'monitor',
            'manufacturer' => 'Lenovo',
            'status' => Device::STATUS_AVAILABLE,
        ]);
    }

    public function test_user_dapat_update_perangkat()
    {
        $device = Device::factory()->create([
            'id' => 1,
            'name' => 'ThinkPad',
            'type' => 'laptop',
            'manufacturer' => 'Lenovo',
            'status' => Device::STATUS_AVAILABLE,
        ]);

        $DataBaru = [
            'id' => 1,
            'name' => 'Updated Device',
            'type' => 'Smartphone',
            'manufacturer' => 'Axioo',
            'status' => Device::STATUS_IN_USE,
        ];

        $updateData = Device::find($DataBaru['id']);

        if (!$updateData) {
            $this->fail("ID {$DataBaru['id']} perangkat tidak ada");
        }else  if (empty($DataBaru['name'])) {
            $this ->fail("Nama harus di isi!");
            return;
        }else if (empty($DataBaru['type'])) {
            $this ->fail("Tipe harus di isi!");
            return;
        }else if (empty($DataBaru['manufacturer'])) {
            $this ->fail("Manufaktur harus di isi");
            return;
        }
        $device->update($DataBaru);
        $this->assertDatabaseHas('devices', $DataBaru);
    }

    public function test_user_dapat_delete_perangkat()
    {
        try {
            $device = Device::factory()->create();
        } catch (\Exception $e) {
            $this->fail('Gagal membuat device untuk testing. Error: ' . $e->getMessage());
        }

        $shouldTestSuccess = true;
        $response = null;

        if ($shouldTestSuccess) {
            $response = $this->actingAs($this->user)
                ->delete("/devices/{$device->id}");

            $this->assertEquals(302, $response->status(), 'Status code bukan 302 setelah menghapus perangkat yang ada');
            $this->assertDatabaseMissing('devices', ['id' => $device->id]);
            $response->assertRedirect('/devices');
        } else {
            $nonExistentDeviceId = 9999;
            $response = $this->actingAs($this->user)
                ->delete("/devices/{$nonExistentDeviceId}");

            $this->assertEquals(404, $response->status(), 'Status code bukan 404 ketika mencoba menghapus perangkat yang tidak ada');

            // Jika menggunakan session flash error
            $response->assertSessionHas('error', 'Device not found');
        }
    }
}
