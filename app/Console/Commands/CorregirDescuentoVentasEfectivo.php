<?php

namespace App\Console\Commands;

use App\Models\Sale;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CorregirDescuentoVentasEfectivo extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = "sales:corregir-descuento-efectivo {--dry-run : Solo muestra las ventas afectadas, sin modificar nada}";

    /**
     * The console command description.
     */
    protected $description = "Pone en cero el descuento por planilla de las ventas pagadas en efectivo (is_cash_payment_form = 1)";

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $dryRun = (bool) $this->option("dry-run");

        $sales = Sale::query()
            ->where("is_cash_payment_form", 1)
            ->where("total_dsct_form", ">", 0)
            ->orderBy("id")
            ->get();

        if ($sales->isEmpty()) {
            $this->info("No hay ventas en efectivo con descuento por planilla. Nada que corregir.");

            return self::SUCCESS;
        }

        $this->table(
            ["ID", "Fecha", "Documento", "Cobrado en caja", "Dscto. planilla", "Subvencion empresa"],
            $sales->map(fn (Sale $sale) => [
                $sale->id,
                $sale->sale_date,
                "{$sale->serie}-{$sale->num_document}",
                number_format((float) $sale->total_sale, 2),
                number_format((float) $sale->total_dsct_form, 2),
                number_format((float) $sale->total_pay_company, 2),
            ])->all()
        );

        $totalDscto = (float) $sales->sum("total_dsct_form");

        $this->newLine();
        $this->warn("Ventas afectadas: {$sales->count()}");
        $this->warn("Descuento por planilla a anular: S/ " . number_format($totalDscto, 2));
        $this->newLine();

        if ($dryRun) {
            $this->info("Modo --dry-run: no se modifico ningun registro.");

            return self::SUCCESS;
        }

        if (!$this->confirm("Se pondra total_dsct_form = 0 y pay_type = EFECTIVO en esas ventas. ¿Confirma? (Asegurese de tener respaldo de la tabla sales)")) {
            $this->info("Operacion cancelada.");

            return self::SUCCESS;
        }

        DB::beginTransaction();
        try {
            $actualizadas = Sale::query()
                ->whereIn("id", $sales->pluck("id"))
                ->update([
                    "total_dsct_form" => 0,
                    "pay_type" => "EFECTIVO",
                ]);

            DB::commit();

            $this->info("Listo. Se corrigieron {$actualizadas} ventas (S/ " . number_format($totalDscto, 2) . " de descuento anulado).");

            return self::SUCCESS;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error("Ocurrio un error, no se modifico nada: {$e->getMessage()}");

            return self::FAILURE;
        }
    }
}
