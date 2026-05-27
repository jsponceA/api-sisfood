<?php

namespace App\Services;

use App\Models\WorkerFaceProfile;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FaceTemplateService
{
    public function hydrateWorkerFaceProfiles(int $workerId, ?string $serviceUrl = null): int
    {
        $faceProfiles = WorkerFaceProfile::query()
            ->select([
                'id',
                'worker_id',
                'face_label',
                'image_path',
                'capture_metadata',
            ])
            ->where('worker_id', $workerId)
            ->whereNotNull('image_path')
            ->get();

        return $this->hydrateTemplates($faceProfiles, $serviceUrl);
    }

    public function hydrateTemplates(EloquentCollection $faceProfiles, ?string $serviceUrl = null): int
    {
        $pendingProfiles = $faceProfiles
            ->filter(function (WorkerFaceProfile $profile) {
                return blank(data_get($profile->capture_metadata, 'face_template'))
                    && filled($profile->image_path)
                    && Storage::exists($profile->image_path);
            })
            ->values();

        if ($pendingProfiles->isEmpty()) {
            return 0;
        }

        $serviceUrl = rtrim((string) ($serviceUrl ?: config('services.face.url')), '/');

        try {
            $response = Http::connectTimeout(5)
                ->timeout((int) config('services.face.timeout', 20))
                ->acceptJson()
                ->post("{$serviceUrl}/templates/build", [
                    'items' => $pendingProfiles->map(function (WorkerFaceProfile $profile) {
                        return [
                            'face_profile_id' => $profile->id,
                            'template_key' => $this->templateKey($profile),
                            'image_data' => $this->imageDataFromStorage($profile->image_path),
                        ];
                    })->filter(fn(array $item) => filled($item['image_data']))->values()->all(),
                ]);
        } catch (\Throwable) {
            return 0;
        }

        if ($response->failed()) {
            return 0;
        }

        $templatesByFaceId = collect($response->json('templates', []))
            ->filter(function (array $item) {
                return !empty($item['face_profile_id']) && !empty($item['template']);
            })
            ->keyBy('face_profile_id');

        if ($templatesByFaceId->isEmpty()) {
            return 0;
        }

        $updated = 0;

        foreach ($pendingProfiles as $profile) {
            $templateItem = $templatesByFaceId->get($profile->id);

            if (!$templateItem) {
                continue;
            }

            $metadata = (array) ($profile->capture_metadata ?? []);
            $metadata['face_template'] = $templateItem['template'];

            WorkerFaceProfile::query()
                ->whereKey($profile->id)
                ->update([
                    'capture_metadata' => $metadata,
                ]);

            $profile->capture_metadata = $metadata;
            $updated++;
        }

        return $updated;
    }

    public function buildCandidatePayload(WorkerFaceProfile $profile): array
    {
        $template = data_get($profile->capture_metadata, 'face_template');

        return [
            'worker_id' => $profile->worker_id,
            'face_profile_id' => $profile->id,
            'face_label' => $profile->face_label,
            'template_key' => $this->templateKey($profile),
            'template' => $template,
            'image_data' => blank($template) ? $this->imageDataFromStorage($profile->image_path) : null,
        ];
    }

    public function templateKey(WorkerFaceProfile $profile): string
    {
        return "worker_face_profile_{$profile->id}";
    }

    private function imageDataFromStorage(?string $imagePath): ?string
    {
        if (blank($imagePath) || !Storage::exists($imagePath)) {
            return null;
        }

        $mimeType = Storage::mimeType($imagePath) ?: 'image/jpeg';
        $contents = Storage::get($imagePath);

        return sprintf(
            'data:%s;base64,%s',
            $mimeType,
            base64_encode($contents),
        );
    }
}
