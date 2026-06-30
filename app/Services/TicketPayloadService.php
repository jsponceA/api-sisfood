<?php

namespace App\Services;

use App\Models\Sale;
use Illuminate\Support\Str;

class TicketPayloadService
{
    public function buildSaleTicketPayload(Sale $sale, string $saleType = 'sale', ?string $cashierName = null): array
    {
        $company = trim((string) config('printerticket.company'));
        $companyPhone = trim((string) config('printerticket.company_phone'));
        $worker = $sale->worker;
        $workerArea = !empty($worker?->area?->name)
            ? mb_strtoupper(trim((string) $worker->area->name))
            : null;
        $workerCostCenter = !empty($worker?->costCenter?->name)
            ? mb_strtoupper(trim((string) $worker->costCenter->name))
            : null;
        $workerNumdoc = !empty($worker?->numdoc)
            ? trim((string) $worker->numdoc)
            : '-';
        $comensal = !empty($worker?->names)
            ? mb_strtoupper(trim($worker->names . ' ' . $worker->surnames))
            : 'PUBLICO GENERAL';

        // Asegura el producto para poder leer su worker_price (costo del menú subvencionado)
        $sale->loadMissing('saleDetails.product');

        $items = $sale->saleDetails->map(function ($detail) use ($sale) {
            // En ventas subvencionadas (serie 001) el detalle tiene precio 0;
            // se muestra el costo del menú que asume el trabajador (worker_price del producto).
            $unitPrice = (float) $detail->sale_price > 0
                ? (float) $detail->sale_price
                : (float) ($detail->product?->worker_price ?? 0);

            return [
                'quantity' => (float) $detail->quantity,
                'product_name' => $detail->product_name,
                'unit_price' => $unitPrice,
                'line_total' => $unitPrice * (float) $detail->quantity,
                'show_line_total' => $sale->serie !== '001',
            ];
        })->values()->all();

        // Total: si la venta no carga monto (subvención), se usa la suma del costo del menú.
        $total = (float) $sale->total_sale > 0
            ? (float) $sale->total_sale
            : array_sum(array_column($items, 'line_total'));

        return [
            'sale_id' => $sale->id,
            'sale_type' => $saleType,
            'company' => $company !== '' ? $company : 'LUCEMIR',
            'company_phone' => $companyPhone,
            'ticket_number' => $sale->serie . '-' . Str::padLeft($sale->num_document, 7, '0'),
            'sale_date' => now()->parse($sale->sale_date)->toIso8601String(),
            'cashier' => mb_strtoupper(trim($cashierName ?: 'SISTEMA LOCAL')),
            'worker_area' => $workerArea,
            'worker_cost_center' => $workerCostCenter,
            'worker_numdoc' => $workerNumdoc,
            'diner_name' => $comensal,
            'payment_label' => $this->resolvePaymentLabel($sale),
            'total' => $total,
            'items' => $items,
        ];
    }

    private function resolvePaymentLabel(Sale $sale): string
    {
        if (!empty($sale->is_cash_payment_form)) {
            return 'EFECTIVO / YAPE';
        }

        return $sale->pay_type === 'EFECTIVO'
            ? 'EFECTIVO'
            : 'Descuento por planilla';
    }
}
