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
        $comensal = !empty($worker?->names)
            ? mb_strtoupper(trim($worker->names . ' ' . $worker->surnames))
            : 'PUBLICO GENERAL';

        return [
            'sale_id' => $sale->id,
            'sale_type' => $saleType,
            'company' => $company !== '' ? $company : 'LUCEMIR',
            'company_phone' => $companyPhone,
            'ticket_number' => $sale->serie . '-' . Str::padLeft($sale->num_document, 7, '0'),
            'sale_date' => now()->parse($sale->sale_date)->toIso8601String(),
            'cashier' => mb_strtoupper(trim($cashierName ?: 'SISTEMA LOCAL')),
            'diner_name' => $comensal,
            'payment_label' => $this->resolvePaymentLabel($sale),
            'total' => (float) $sale->total_sale,
            'items' => $sale->saleDetails->map(function ($detail) use ($sale) {
                return [
                    'quantity' => (float) $detail->quantity,
                    'product_name' => $detail->product_name,
                    'unit_price' => (float) $detail->sale_price,
                    'line_total' => (float) $detail->total,
                    'show_line_total' => $sale->serie !== '001',
                ];
            })->values()->all(),
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
