<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Device;
use App\Models\Borrowing;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserBorrowingTest extends TestCase
{

    protected $user;
    protected $device;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a regular user
        $this->user = User::factory()->create([
            'role' => 'user',
            'is_active' => true
        ]);

        // Create an available device
        $this->device = Device::factory()->create([
            'status' => Device::STATUS_AVAILABLE
        ]);
    }

    public function test_user_can_view_borrowing_form()
    {
        $response = $this->actingAs($this->user)
            ->get(route('borrowings.create'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Borrowings/Create')
            ->has('devices')
        );
    }

    public function test_user_can_create_borrowing()
    {
        // Test with available device
        $Device = Device::factory()->create([
            'name' => 'Available Device',
            'type' => 'laptop',
            'status' => Device::STATUS_AVAILABLE
        ]);

        $borrowingData = [
            'device_id' => $Device->id,
            'borrow_date' => now()->format('Y-m-d'),
            'return_date' => now()->addDays(7)->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->user)
            ->post(route('borrowings.store'), $borrowingData);

        if ($Device->status === Device::STATUS_AVAILABLE) {
            $response->assertRedirect(route('borrowings.index'));
            $response->assertSessionHasNoErrors();
        } else {
            $response->assertSessionHasErrors('device_id');
            $response->assertSessionDoesntHaveErrors(['borrow_date', 'return_date']);
        }


    }
    

}