<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //User::factory(1000)->create();
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //crear categorias

        $categories = [
            [
                "name" => "DESAYUNO",
                "code" => "DES"
            ],
            [
                "name" => "ALMUERZO",
                 "code" => "ALM"
            ],
            [
                "name" => "CENA",
                "code" => "CEN"
            ],
            [
                "name" => "EXTRAS",
                "code" => "EXT"
            ],
            [
                "name" => "SNACKS",
                "code" => "SNK"
            ],
            [
                "name" => "BEBIDAS",
                "code" => "BEB"
            ]
        ];

        foreach ($categories as $category) {
            Category::query()->create($category);
        }

    }
}
