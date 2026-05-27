<?php

namespace App\Console\Commands;

use App\Models\WorkerFaceProfile;
use App\Services\FaceTemplateService;
use Illuminate\Console\Command;

class WarmFaceTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'face:warm-templates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Precalcula y guarda plantillas faciales para acelerar la identificación por rostro';

    /**
     * Execute the console command.
     */
    public function handle(FaceTemplateService $faceTemplateService): int
    {
        $faces = WorkerFaceProfile::query()
            ->select([
                'id',
                'worker_id',
                'face_label',
                'image_path',
                'capture_metadata',
            ])
            ->whereNotNull('image_path')
            ->get();

        if ($faces->isEmpty()) {
            $this->info('No hay rostros registrados para precalcular.');
            return self::SUCCESS;
        }

        $pending = $faces->filter(function (WorkerFaceProfile $profile) {
            return blank(data_get($profile->capture_metadata, 'face_template'));
        })->count();

        if ($pending === 0) {
            $this->info('Todos los rostros ya tienen plantilla facial guardada.');
            return self::SUCCESS;
        }

        $startedAt = microtime(true);
        $updated = $faceTemplateService->hydrateTemplates($faces);
        $elapsedMs = round((microtime(true) - $startedAt) * 1000, 2);

        if ($updated === 0) {
            $this->error('No se pudieron precalcular las plantillas faciales. Verifica que el servicio facial esté levantado.');
            return self::FAILURE;
        }

        $this->info("Plantillas faciales generadas: {$updated}");
        $this->line("Tiempo total: {$elapsedMs} ms");

        return self::SUCCESS;
    }
}
