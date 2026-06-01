<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\WorkerFingerprint;
use App\Services\BiometricBridgeService;
use App\Services\TicketPayloadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BiometricBridgeController extends Controller
{
    public function saleTicket(Request $request, int $saleId, BiometricBridgeService $bridgeService, TicketPayloadService $ticketPayloadService): JsonResponse
    {
        $bridgeService->authorizeRequest($request);

        $sale = Sale::query()
            ->with(['worker', 'saleDetails'])
            ->findOrFail($saleId);

        return response()->json(
            $ticketPayloadService->buildSaleTicketPayload(
                $sale,
                'sale',
                $request->query('cashierName'),
            ),
            Response::HTTP_OK,
        );
    }

    public function pastSaleTicket(Request $request, int $saleId, BiometricBridgeService $bridgeService, TicketPayloadService $ticketPayloadService): JsonResponse
    {
        $bridgeService->authorizeRequest($request);

        $sale = Sale::query()
            ->with(['worker', 'saleDetails'])
            ->findOrFail($saleId);

        return response()->json(
            $ticketPayloadService->buildSaleTicketPayload(
                $sale,
                'pastSale',
                $request->query('cashierName'),
            ),
            Response::HTTP_OK,
        );
    }

    public function fingerprints(Request $request, BiometricBridgeService $bridgeService): JsonResponse
    {
        $bridgeService->authorizeRequest($request);

        $fingerprints = WorkerFingerprint::query()
            ->with(['worker:id,numdoc,names,surnames,grant,grant_complete,deleted_at'])
            ->select([
                'id',
                'worker_id',
                'finger_label',
                'sample_format',
                'sample_data',
                'image_data',
                'device_uid',
                'quality',
                'capture_metadata',
                'template_data',
                'template_engine',
                'template_version',
                'template_hash',
                'template_created_at',
                'is_active',
                'updated_at',
            ])
            ->whereNull('deleted_at')
            ->where(function ($query) {
                $query->whereNull('is_active')
                    ->orWhere('is_active', true);
            })
            ->whereHas('worker', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->orderBy('id')
            ->get();

        return response()->json([
            'fingerprints' => $fingerprints->map(function (WorkerFingerprint $fingerprint) {
                return [
                    'fingerprint_id' => $fingerprint->id,
                    'worker_id' => $fingerprint->worker_id,
                    'worker_numdoc' => $fingerprint->worker?->numdoc,
                    'worker_names' => $fingerprint->worker?->names,
                    'worker_surnames' => $fingerprint->worker?->surnames,
                    'worker_grant' => (bool) ($fingerprint->worker?->grant ?? false),
                    'worker_grant_complete' => (bool) ($fingerprint->worker?->grant_complete ?? false),
                    'finger_label' => $fingerprint->finger_label,
                    'sample_format' => $fingerprint->sample_format,
                    'sample_data' => $fingerprint->sample_data,
                    'image_data' => $fingerprint->image_data,
                    'device_uid' => $fingerprint->device_uid,
                    'quality' => $fingerprint->quality,
                    'capture_metadata' => $fingerprint->capture_metadata,
                    'template_data' => $fingerprint->template_data,
                    'template_engine' => $fingerprint->template_engine,
                    'template_version' => $fingerprint->template_version,
                    'template_hash' => $fingerprint->template_hash,
                    'template_created_at' => optional($fingerprint->template_created_at)?->toIso8601String(),
                    'updated_at' => optional($fingerprint->updated_at)?->toIso8601String(),
                ];
            })->values(),
        ], Response::HTTP_OK);
    }

    public function templates(Request $request, BiometricBridgeService $bridgeService): JsonResponse
    {
        $bridgeService->authorizeRequest($request);

        $payload = $request->validate([
            'templates' => ['required', 'array', 'min:1'],
            'templates.*.fingerprint_id' => ['required', 'integer'],
            'templates.*.template_data' => ['required', 'string'],
            'templates.*.template_engine' => ['nullable', 'string', 'max:100'],
            'templates.*.template_version' => ['nullable', 'string', 'max:100'],
            'templates.*.template_hash' => ['nullable', 'string', 'max:191'],
            'templates.*.template_created_at' => ['nullable', 'date'],
        ]);

        $templateMap = collect($payload['templates'])->keyBy('fingerprint_id');
        $fingerprints = WorkerFingerprint::query()
            ->whereIn('id', $templateMap->keys()->all())
            ->get();

        $updated = 0;

        foreach ($fingerprints as $fingerprint) {
            $template = $templateMap->get($fingerprint->id);

            if (!$template) {
                continue;
            }

            $fingerprint->forceFill([
                'template_data' => $template['template_data'],
                'template_engine' => $template['template_engine'] ?? null,
                'template_version' => $template['template_version'] ?? null,
                'template_hash' => $template['template_hash'] ?? null,
                'template_created_at' => $template['template_created_at'] ?? now(),
                'is_active' => true,
            ])->save();

            $updated++;
        }

        return response()->json([
            'updated' => $updated,
        ], Response::HTTP_OK);
    }
}
