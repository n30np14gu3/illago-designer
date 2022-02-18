<?php

namespace App\Http\Modules;

trait RestApiResponse
{
    protected array $response = [
        'status' => 'ERROR',
        'message' => '',
        'errors' => [],
        'data' => null
    ];
}
