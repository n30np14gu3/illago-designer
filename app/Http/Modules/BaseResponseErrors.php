<?php

namespace App\Http\Modules;

use Illuminate\Http\JsonResponse;

trait BaseResponseErrors
{
    /**
     * Return HTTP 403 ERROR
     *
     * Access Denied.
     * @return JsonResponse
     */
    protected function e403(): JsonResponse
    {
        return response()->json([
            'message' => 'Access Denied.'
        ], 403);
    }

    /**
     * Return HTTP 401 ERROR
     *
     * Unauthenticated.
     * @return JsonResponse
     */
    protected function e401(): JsonResponse
    {
        return response()->json([
            'message' => 'Unauthenticated.'
        ], 401);
    }

    /**
     * Return HTTP 404 ERROR
     *
     * Not Found.
     * @return JsonResponse
     */
    protected function e404(): JsonResponse
    {
        return response()->json([
            'message' => 'Not Found.'
        ], 404);
    }

    /**
     * Return HTTP 405 ERROR
     *
     * Method Not Allowed.
     * @return JsonResponse
     */
    protected function e405(): JsonResponse{
        return response()->json([
            'message' => 'Method Not Allowed.'
        ], 405);
    }
}
