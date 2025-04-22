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

        \App\Models\User::factory()->create([
            'rol_id' => 1,
            'branch_id' => 1,
            'username' => 'admin',
            'password' => bcrypt(123456),
            'email' => 'admin@gmail.com',
            'photo' => null
         ]);

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
            ],
            [
                "name" => "GASEOSAS",
                "code" => "GAS"
            ],
            [
                "name" => "TORTAS",
                "code" => "TOR"
            ]
        ];

        foreach ($categories as $category) {
            Category::query()->create($category);
        }

    }
}
