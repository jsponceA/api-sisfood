<?php

namespace App\Console\Commands;

use App\Models\WorkerFingerprint;
use App\Services\BiometricTemplateService;
use Illuminate\Console\Command;

class WarmBiometricTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'biometric:warm-templates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Precalcula y guarda plantillas biométricas para acelerar la identificación por huella';

    /**
     * Execute the console command.
     */
    public function handle(BiometricTemplateService $biometricTemplateService): int
    {
        $fingerprints = WorkerFingerprint::query()
            ->select([
                'id',
                'worker_id',
                'finger_label',
                'image_data',
                'sample_data',
                'capture_metadata',
            ])
            ->where(function ($query) {
                $query->whereNotNull('image_data')
                    ->orWhereNotNull('sample_data');
            })
            ->get();

        if ($fingerprints->isEmpty()) {
            $this->info('No hay huellas registradas para precalcular.');
            return self::SUCCESS;
        }

        $pending = $fingerprints->filter(function (WorkerFingerprint $fingerprint) {
            return blank(data_get($fingerprint->capture_metadata, 'biometric_template'));
        })->count();

        if ($pending === 0) {
            $this->info('Todas las huellas ya tienen plantilla biométrica guardada.');
            return self::SUCCESS;
        }

        $startedAt = microtime(true);
        $updated = $biometricTemplateService->hydrateTemplates($fingerprints);
        $elapsedMs = round((microtime(true) - $startedAt) * 1000, 2);

        if ($updated === 0) {
            $this->error('No se pudieron precalcular las plantillas. Verifica que el servicio biométrico esté levantado.');
            return self::FAILURE;
        }

        $this->info("Plantillas biométricas generadas: {$updated}");
        $this->line("Tiempo total: {$elapsedMs} ms");

        return self::SUCCESS;
    }
}
