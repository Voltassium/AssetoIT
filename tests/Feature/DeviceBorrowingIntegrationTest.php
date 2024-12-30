<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceBorrowingIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin with verified email
        $this->admin = User::factory()->create([
            'email' => 'admin@test.com',
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now()
        ]);
        
        // Create user with verified email
        $this->user = User::factory()->create([
            'email' => 'user@test.com',
            'role' => 'user',
            'is_active' => true,
            'email_verified_at' => now()
        ]);
    }

    public function test_admin_can_create_device()
    {
        $deviceData = [
            'name' => 'Test Device',
            'type' => 'ESP-32',
            'manufacturer' => 'Test Brand',
            'status' => Device::STATUS_AVAILABLE,
            'count' => 1,
            'specifications' => 'newest version' 
        ];

        $response = $this->actingAs($this->admin)
            ->from('/devices/create')
            ->post('/devices', $deviceData);

        // Check if validation passed
        if ($response->status() === 302) {
            $response->assertRedirect('/devices');
        } else {
            $this->fail('Device creation failed: ' . json_encode($response->json()));
        }

        $this->assertDatabaseHas('devices', [
            'name' => 'Test Device',
            'type' => 'ESP-32',
            'manufacturer' => 'Test Brand'
        ]);
    }

    public function test_user_can_see_device_list()
    {
        $device = Device::factory()->create([
            'name' => 'Device 1',
            'status' => Device::STATUS_IN_USE
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('devices.index'));

        $response->assertStatus(200);
    }

    public function test_user_can_borrow_device()
    {
        $device = Device::factory()->create([
            'status' => Device::STATUS_AVAILABLE
        ]);
    
        $borrowData = [
            'device_id' => $device->id,
            'borrow_date' => now()->format('Y-m-d'),
            'return_date' => now()->addDays(7)->format('Y-m-d'),
            'reason' => 'Testing purpose'
        ];
    
        $response = $this->actingAs($this->user)
            ->post(route('borrowings.store'), $borrowData);
    
        if ($device->status === Device::STATUS_AVAILABLE) {
            // If device is available, borrowing should succeed
            $response->assertSessionHasNoErrors();
            $this->assertDatabaseHas('borrowings', [
                'device_id' => $device->id,
                'user_id' => $this->user->id,
                'status' => 'pending'
            ]);
        } else {
            // If device is not available, borrowing should fail
            $response->assertSessionHasErrors(['device_id']);
            $this->assertDatabaseMissing('borrowings', [
                'device_id' => $device->id,
                'user_id' => $this->user->id
            ]);
        }
    }

    public function test_admin_can_validate_borrowing_request()
    {
        $device = Device::factory()->create([
            'status' => Device::STATUS_AVAILABLE
        ]);

        $borrowing = Borrowing::create([
            'device_id' => $device->id,
            'user_id' => $this->user->id,
            'borrow_date' => now(),
            'return_date' => now()->addDays(7),
            'status' => 'pending',
            'reason' => 'Test reason'
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('borrowings.approve', $borrowing));
        
        $borrowing->refresh();
        
        $this->assertEquals('approved', $borrowing->status);
        
        $device->refresh();
        $this->assertEquals(Device::STATUS_IN_USE, $device->status);
    }
}