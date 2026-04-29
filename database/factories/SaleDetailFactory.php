<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SaleDetail>
 */
class SaleDetailFactory extends Factory
{
    protected $model = SaleDetail::class;

    public function definition(): array
    {
        $product = Product::query()->inRandomOrder()->first() ?? Product::factory()->create();
        $quantity = fake()->randomFloat(2, 1, 4);
        $salePrice = (float) ($product->worker_price ?: $product->sale_price ?: fake()->randomFloat(2, 5, 20));

        return [
            'sale_id' => fn() => Sale::query()->inRandomOrder()->value('id')
                ?? Sale::factory()->create()->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'sale_price' => $salePrice,
            'total' => round($quantity * $salePrice, 2),
        ];
    }
}
