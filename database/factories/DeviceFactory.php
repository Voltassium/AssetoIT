<?php

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['Laptop', 'Smartphone', 'Tablet', 'Desktop']),
            'manufacturer' => $this->faker->company,
            'status' => $this->faker->randomElement([
                Device::STATUS_AVAILABLE,
                Device::STATUS_IN_USE,
                Device::STATUS_DAMAGED
            ]),
        ];
    }
}
