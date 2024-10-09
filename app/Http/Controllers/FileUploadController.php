<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\FileUploadRequest;
use App\Interfaces\Services\FileUploadServiceInterface;
use App\Responses\ReportMessageResponseError;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class FileUploadController extends ApiController
{
    /**
     * @var FileUploadServiceInterface
     */
    private FileUploadServiceInterface $fileUploadService;

    /**
     * @param FileUploadServiceInterface $fileUploadService
     */
    public function __construct(FileUploadServiceInterface $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param FileUploadRequest $request
     * @return JsonResponse
     */
    public function uploadChunk(FileUploadRequest $request): JsonResponse
    {
        try {
            return $this->makeResponse($this->fileUploadService->uploadChunk($request));
        } catch (Exception $ex) {
            return $this->makeResponse(new ReportMessageResponseError(
                    false,
                    'Something is wrong',
                    $ex->getMessage(),
                    ResponseAlias::HTTP_INTERNAL_SERVER_ERROR)
            );
        }
    }
}
