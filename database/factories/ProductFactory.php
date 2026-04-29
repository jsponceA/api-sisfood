<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $purchasePrice = fake()->randomFloat(2, 4, 18);
        $salePrice = round($purchasePrice * fake()->randomFloat(2, 1.25, 1.9), 2);
        $workerPrice = round(max($purchasePrice, $salePrice * fake()->randomFloat(2, 0.45, 0.9)), 2);
        $companyPrice = round(max(0, $salePrice - $workerPrice), 2);
        $handlesStock = fake()->boolean(80);
        $name = fake()->randomElement([
            'Desayuno ejecutivo',
            'Almuerzo criollo',
            'Cena ligera',
            'Jugo natural',
            'Gaseosa personal',
            'Snack saludable',
            'Torta de chocolate',
            'Combo del día',
        ]) . ' ' . fake()->randomElement(['A', 'B', 'Especial', 'Premium']);

        return [
            'category_id' => fn() => Category::query()->inRandomOrder()->value('id')
                ?? Category::query()->create([
                    'name' => 'ALMUERZO',
                    'color' => '#2ecc71',
                    'code' => 'ALM',
                ])->id,
            'name' => $name,
            'internal_code' => strtoupper(fake()->unique()->bothify('PRD-#####')),
            'barcode' => fake()->unique()->numerify('#############'),
            'purchase_price' => $purchasePrice,
            'sale_price' => $salePrice,
            'worker_price' => $workerPrice,
            'igv_price' => round($salePrice * 0.18, 2),
            'company_price' => $companyPrice,
            'handle_stock' => $handlesStock,
            'current_stock' => $handlesStock ? fake()->randomFloat(2, 10, 250) : null,
            'expiration_date' => fake()->boolean(35) ? fake()->dateTimeBetween('now', '+8 months')->format('Y-m-d') : null,
            'image' => null,
        ];
    }
}
