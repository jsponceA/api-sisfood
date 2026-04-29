<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rol_id' => fn() => Role::query()->inRandomOrder()->value('id')
                ?? Role::query()->create(['name' => 'ADMIN'])->id,
            'branch_id' => fn() => Branch::query()->inRandomOrder()->value('id')
                ?? Branch::query()->create(['name' => 'SEDE PRINCIPAL'])->id,
            'username' => fake()->unique()->userName(),
            'email' => fake()->safeEmail(),
            'password' => '123456',
            'photo' => null,
        ];
    }
}
