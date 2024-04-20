<?php

namespace App\Http\Middleware;

use App\Models\License;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LicenseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $endDate = now()->createFromFormat("Y-m-d","2024-04-30");

        /* $currentDate = now()->format("Y-m-d")
             $queryValidateLicense = License::query()
             ->whereDate("end_date","<=",$currentDate)
             ->first();*/

        if ($endDate->isPast()){
            return response()->json([
                "message" => "Licencia Vencida, por favor contacte con soporte"
            ],Response::HTTP_PAYMENT_REQUIRED);
        }

        return $next($request);
    }
}
