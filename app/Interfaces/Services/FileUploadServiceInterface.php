<?php

namespace App\Interfaces\Services;

use App\Http\Requests\FileUploadRequest;
use App\Responses\ReportMessageResponse;
use Illuminate\Http\JsonResponse;

interface FileUploadServiceInterface
{
    /**
     * @param FileUploadRequest $request
     * @return JsonResponse|ReportMessageResponse
     */
    public function uploadChunk(FileUploadRequest $request): JsonResponse|ReportMessageResponse;
}
