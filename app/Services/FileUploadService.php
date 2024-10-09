<?php

namespace App\Services;

use App\Http\Requests\FileUploadRequest;
use App\Interfaces\Services\FileUploadServiceInterface;
use App\Responses\ReportMessageResponse;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FileUploadService implements FileUploadServiceInterface
{
    /**
     * @param FileUploadRequest $request
     * @return ReportMessageResponse|JsonResponse
     */
    public function uploadChunk(FileUploadRequest $request): JsonResponse|ReportMessageResponse
    {
        $fileName = $request->input('fileName');
        $chunkIndex = $request->input('chunkIndex');
        $totalChunks = $request->input('totalChunks');

        $chunkFileName = "{$fileName}.part{$chunkIndex}";
        $chunkPath = storage_path('app/chunks/');

        if (!file_exists($chunkPath)) {
            mkdir($chunkPath, 0777, true);
        }

        $file = $request->file('file');

        if (!$file || !$file->isValid()) {
            return response()->json(['message' => 'Ошибка загрузки файла'], 400);
        }

        $file->move($chunkPath, $chunkFileName);

        if ($this->allChunksUploaded($fileName, $totalChunks)) {
            $this->combineChunks($fileName, $totalChunks);
        }

        return new ReportMessageResponse(
            true,
            'File Uploaded Successfully',
            [],
            ResponseAlias::HTTP_OK
        );
    }

    /**
     * @param $fileName
     * @param $totalChunks
     * @return bool
     */
    private function allChunksUploaded($fileName, $totalChunks): bool
    {
        for ($i = 0; $i < $totalChunks; $i++) {
            if (!file_exists(storage_path("app/chunks/{$fileName}.part{$i}"))) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $fileName
     * @param $totalChunks
     * @return void
     */
    private function combineChunks($fileName, $totalChunks): void
    {
        $finalPath = storage_path("app/uploads/{$fileName}");
        $chunkPath = storage_path('app/chunks/');

        $outputFile = fopen($finalPath, 'ab');
        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkFile = $chunkPath . "{$fileName}.part{$i}";
            if (file_exists($chunkFile)) {
                $chunk = fopen($chunkFile, 'rb');
                stream_copy_to_stream($chunk, $outputFile);
                fclose($chunk);
                unlink($chunkFile);
            }
        }
        fclose($outputFile);
    }
}
