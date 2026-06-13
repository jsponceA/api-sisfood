<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Category;
use App\Models\License;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $adminRoleId = Role::query()->where('name', 'ADMIN')->value('id')
            ?? Role::query()->firstOrCreate(['name' => 'ADMIN'])->id;

        $branchId = Branch::query()->where('name', 'SEDE PRINCIPAL')->value('id')
            ?? Branch::query()->firstOrCreate(['name' => 'SEDE PRINCIPAL'])->id;

        License::query()->firstOrCreate(
            ['name' => 'LICENCIA DEMO'],
            License::factory()->make([
                'name' => 'LICENCIA DEMO',
                'start_date' => now()->subMonth()->format('Y-m-d'),
                'end_date' => now()->addYear()->format('Y-m-d'),
            ])->toArray()
        );

        User::query()->updateOrCreate(
            ['username' => 'admin'],
            [
                'rol_id' => $adminRoleId,
                'branch_id' => $branchId,
                'email' => 'admin@lucemir.test',
                'password' => '123456',
                'photo' => null,
            ]
        );

        $targetUsers = 10;

        $pendingUsers = max(0, $targetUsers - User::query()->count());

        if ($pendingUsers > 0) {
            User::factory()->count($pendingUsers)->create();
        }

        $this->seedProducts();
    }

    private function seedProducts(): void
    {
        $products = [
            [
                'name' => 'ALMUERZO ESPECIAL',
                'category' => 'EXTRAS',
                'barcode' => '5130626',
                'purchase_price' => 0,
                'sale_price' => 0,
                'worker_price' => 0,
                'igv_price' => 0,
                'company_price' => 11.50,
            ],
            [
                'name' => 'CENA SOBRETIEMPO',
                'category' => 'CENA',
                'barcode' => '4130626',
                'purchase_price' => 0,
                'sale_price' => 0,
                'worker_price' => 0,
                'igv_price' => 0,
                'company_price' => 6.50,
            ],
            [
                'name' => 'ALMUERZO SOBRETIEMPO',
                'category' => 'EXTRAS',
                'barcode' => '3130626',
                'purchase_price' => 0,
                'sale_price' => 0,
                'worker_price' => 0,
                'igv_price' => 0,
                'company_price' => 6.50,
            ],
            [
                'name' => 'VASO DE LECHE',
                'category' => 'DESAYUNO',
                'barcode' => '2130626',
                'purchase_price' => 0,
                'sale_price' => 0,
                'worker_price' => 0,
                'igv_price' => 0,
                'company_price' => 1.50,
            ],
            [
                'name' => 'MENU',
                'category' => 'ALMUERZO',
                'barcode' => '1130626',
                'purchase_price' => 0,
                'sale_price' => 2.92,
                'worker_price' => 2.92,
                'igv_price' => 0,
                'company_price' => 3.58,
            ],
        ];

        foreach ($products as $product) {
            $categoryId = Category::query()->where('name', $product['category'])->value('id');

            Product::query()->updateOrCreate(
                ['barcode' => $product['barcode']],
                [
                    'name' => $product['name'],
                    'category_id' => $categoryId,
                    'purchase_price' => $product['purchase_price'],
                    'sale_price' => $product['sale_price'],
                    'worker_price' => $product['worker_price'],
                    'igv_price' => $product['igv_price'],
                    'company_price' => $product['company_price'],
                    'handle_stock' => 0,
                    'current_stock' => null,
                    'expiration_date' => null,
                ]
            );
        }
    }
}
