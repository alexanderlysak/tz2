<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Responses\ReportMessageResponse;
use App\Responses\ReportMessageResponseError;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class ApiController extends Controller
{
    /**
     * @param ReportMessageResponse|ReportMessageResponseError $response
     * @return JsonResponse
     */
    protected function makeResponse(ReportMessageResponse|ReportMessageResponseError $response): JsonResponse
    {
        try {
            $response = response()->json($response, $response->statusCode);
        } catch (Throwable $e) {
            $response = response()->json(new ReportMessageResponseError(false, $e->getMessage(), null,ResponseAlias::HTTP_INTERNAL_SERVER_ERROR));
        }

        return $response;
    }
}
