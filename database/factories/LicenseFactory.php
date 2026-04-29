<?php

namespace Database\Factories;

use App\Models\License;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<License>
 */
class LicenseFactory extends Factory
{
    protected $model = License::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-30 days', 'now');
        $endDate = (clone $startDate)->modify('+' . fake()->numberBetween(180, 720) . ' days');

        return [
            'name' => 'LICENCIA DEMO',
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ];
    }
}
