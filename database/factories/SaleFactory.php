<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sale>
 */
class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        $payType = fake()->randomElement(['CREDITO', 'EFECTIVO']);

        return [
            'worker_id' => fn() => Worker::query()->inRandomOrder()->value('id')
                ?? Worker::factory()->create()->id,
            'sale_date' => fake()->dateTimeBetween('-60 days', 'now')->format('Y-m-d H:i:s'),
            'serie' => fake()->randomElement(['B001', 'B002', 'F001']),
            'num_document' => fake()->unique()->numerify('######'),
            'total_sale' => 0,
            'total_igv' => 0,
            'total_dsct_form' => 0,
            'total_pay_company' => 0,
            'deal_in_form' => 'SIN SUBVENCION',
            'pay_type' => $payType,
            'is_cash_payment_form' => $payType === 'EFECTIVO',
        ];
    }
}
