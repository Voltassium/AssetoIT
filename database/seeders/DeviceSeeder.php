<?php
namespace Database\Seeders;
use App\Models\Device;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(int $count = 20)
    {
        // Create devices with specific types to ensure good distribution
        $deviceTypes = ['Keyboard', 'Monitor', 'Mouse'];
        $perType = ceil($count / 3);

        foreach ($deviceTypes as $type) {
            Device::factory()
                ->count($perType)
                ->state(function (array $attributes) use ($type) {
                    return [
                        'type' => $type,
                        // Ensure more devices are available than other statuses
                        'status' => fake()->randomElement([
                            Device::STATUS_AVAILABLE,
                            Device::STATUS_AVAILABLE,
                            Device::STATUS_IN_USE,
                            Device::STATUS_DAMAGED,
                        ])
                    ];
                })
                ->create();
        }
    }
}
