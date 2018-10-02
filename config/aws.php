<?php

use Aws\Laravel\AwsServiceProvider;

return [
    'credentials' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
    ],
    'region' => env('AWS_DEFAULT_REGION'),
    'version' => 'latest',
    'bucket_name' => env('AWS_BUCKET'),
    'aws_url' => env('AWS_URL'),

    // You can override settings for specific services
    'Ses' => [
        'region' => env('AWS_DEFAULT_REGION'),
    ],
];
