<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\License;
use App\Models\Product;
use App\Models\Role;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use App\Models\Worker;
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
        $targetWorkers = 80;
        $targetProducts = 36;
        $targetSales = 60;

        $pendingUsers = max(0, $targetUsers - User::query()->count());
        $pendingWorkers = max(0, $targetWorkers - Worker::query()->count());
        $pendingProducts = max(0, $targetProducts - Product::query()->count());
        $pendingSales = max(0, $targetSales - Sale::query()->count());

        if ($pendingUsers > 0) {
            User::factory()->count($pendingUsers)->create();
        }

        if ($pendingWorkers > 0) {
            Worker::factory()->count($pendingWorkers)->create();
        }

        if ($pendingProducts > 0) {
            Product::factory()->count($pendingProducts)->create();
        }

        if ($pendingSales > 0) {
            Sale::factory()->count($pendingSales)->create()->each(function (Sale $sale) {
                $worker = $sale->worker;
                $products = Product::query()->inRandomOrder()->limit(fake()->numberBetween(1, 4))->get();
                $subtotal = 0;

                foreach ($products as $product) {
                    $quantity = fake()->randomFloat(2, 1, 3);
                    $salePrice = (float) ($product->worker_price ?: $product->sale_price ?: 0);
                    $lineTotal = round($quantity * $salePrice, 2);

                    SaleDetail::factory()->create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $quantity,
                        'sale_price' => $salePrice,
                        'total' => $lineTotal,
                    ]);

                    $subtotal += $lineTotal;
                }

                $discount = 0;
                $dealInForm = 'SIN SUBVENCION';

                if ($worker?->grant_complete) {
                    $discount = round($subtotal * 0.7, 2);
                    $dealInForm = 'SUBVENCION COMPLETA';
                } elseif ($worker?->grant) {
                    $discount = round($subtotal * 0.35, 2);
                    $dealInForm = 'SUBVENCION PARCIAL';
                }

                $sale->update([
                    'deal_in_form' => $dealInForm,
                    'total_dsct_form' => $discount,
                    'total_pay_company' => $discount,
                    'total_igv' => round($subtotal * 0.18, 2),
                    'total_sale' => round(max($subtotal - $discount, 0), 2),
                ]);
            });
        }
    }
}
