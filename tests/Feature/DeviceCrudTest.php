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
            'type' => 'monitor',
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
