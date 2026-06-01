<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class BiometricBridgeService
{
    public const TOKEN_HEADER = 'X-Biometric-Bridge-Token';

    public function authorizeRequest(Request $request): void
    {
        $expectedToken = (string) config('services.biometric_bridge.token');
        $receivedToken = (string) $request->header(self::TOKEN_HEADER, '');

        abort_if(
            blank($expectedToken) || !hash_equals($expectedToken, $receivedToken),
            Response::HTTP_FORBIDDEN,
            'No autorizado para sincronizar el bridge biométrico.'
        );
    }

    public function notifyReload(): void
    {
        $url = trim((string) config('services.biometric_bridge.url'));

        if ($url === '') {
            return;
        }

        Http::acceptJson()
            ->withHeaders([
                self::TOKEN_HEADER => (string) config('services.biometric_bridge.token'),
            ])
            ->timeout((int) config('services.biometric_bridge.timeout', 5))
            ->post(rtrim($url, '/') . '/reload');
    }
}
