<?php

namespace App\Services;

use App\Models\WorkerFingerprint;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Http;

class BiometricTemplateService
{
    public function hydrateWorkerFingerprints(int $workerId, ?string $serviceUrl = null): int
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
            ->where('worker_id', $workerId)
            ->where(function ($query) {
                $query->whereNotNull('image_data')
                    ->orWhereNotNull('sample_data');
            })
            ->get();

        return $this->hydrateTemplates($fingerprints, $serviceUrl);
    }

    public function hydrateTemplates(EloquentCollection $fingerprints, ?string $serviceUrl = null): int
    {
        $pendingFingerprints = $fingerprints
            ->filter(function (WorkerFingerprint $fingerprint) {
                return blank(data_get($fingerprint->capture_metadata, 'biometric_template'))
                    && (filled($fingerprint->image_data) || filled($fingerprint->sample_data));
            })
            ->values();

        if ($pendingFingerprints->isEmpty()) {
            return 0;
        }

        $serviceUrl = rtrim((string) ($serviceUrl ?: config('services.biometric.url')), '/');

        try {
            $response = Http::connectTimeout(5)
                ->timeout((int) config('services.biometric.timeout', 120))
                ->acceptJson()
                ->post("{$serviceUrl}/templates/build", [
                    'items' => $pendingFingerprints->map(function (WorkerFingerprint $fingerprint) {
                        return [
                            'fingerprint_id' => $fingerprint->id,
                            'template_key' => $this->templateKey($fingerprint),
                            'image_data' => $fingerprint->image_data,
                            'sample_data' => $fingerprint->sample_data,
                        ];
                    })->all(),
                ]);
        } catch (\Throwable) {
            return 0;
        }

        if ($response->failed()) {
            return 0;
        }

        $templatesByFingerprintId = collect($response->json('templates', []))
            ->filter(function (array $item) {
                return !empty($item['fingerprint_id']) && !empty($item['template']);
            })
            ->keyBy('fingerprint_id');

        if ($templatesByFingerprintId->isEmpty()) {
            return 0;
        }

        $updated = 0;

        foreach ($pendingFingerprints as $fingerprint) {
            $templateItem = $templatesByFingerprintId->get($fingerprint->id);

            if (!$templateItem) {
                continue;
            }

            $metadata = (array) ($fingerprint->capture_metadata ?? []);
            $metadata['biometric_template'] = $templateItem['template'];

            WorkerFingerprint::query()
                ->whereKey($fingerprint->id)
                ->update([
                    'capture_metadata' => $metadata,
                ]);

            $fingerprint->capture_metadata = $metadata;
            $updated++;
        }

        return $updated;
    }

    public function buildCandidatePayload(WorkerFingerprint $fingerprint): array
    {
        $template = data_get($fingerprint->capture_metadata, 'biometric_template');

        return [
            'worker_id' => $fingerprint->worker_id,
            'fingerprint_id' => $fingerprint->id,
            'finger_label' => $fingerprint->finger_label,
            'template_key' => $this->templateKey($fingerprint),
            'template' => $template,
            'image_data' => blank($template) ? $fingerprint->image_data : null,
            'sample_data' => blank($template) ? $fingerprint->sample_data : null,
        ];
    }

    public function templateKey(WorkerFingerprint $fingerprint): string
    {
        return "worker_fingerprint_{$fingerprint->id}";
    }
}
