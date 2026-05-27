<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'biometric' => [
        'url' => env('BIOMETRIC_SERVICE_URL', 'http://127.0.0.1:8765'),
        'timeout' => (int) env('BIOMETRIC_SERVICE_TIMEOUT', 120),
        'score_threshold' => (float) env('BIOMETRIC_MATCH_SCORE_THRESHOLD', 30),
    ],

    'face' => [
        'url' => env('FACE_SERVICE_URL', 'http://127.0.0.1:8876'),
        'timeout' => (int) env('FACE_SERVICE_TIMEOUT', 20),
        'score_threshold' => (float) env('FACE_MATCH_SCORE_THRESHOLD', 76),
        'score_gap_threshold' => (float) env('FACE_MATCH_SCORE_GAP_THRESHOLD', 4),
        'support_score_threshold' => (float) env('FACE_MATCH_SUPPORT_SCORE_THRESHOLD', 68),
    ],

];
