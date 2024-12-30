<?php

namespace Database\Factories;

use App\Models\Borrowing;
use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BorrowingFactory extends Factory
{
    protected $model = Borrowing::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'device_id' => Device::factory(),
            'borrow_date' => now(),
            'return_date' => now()->addDays(7),
            'status' => 'pending',
            'reason' => $this->faker->sentence(),
        ];
    }
}