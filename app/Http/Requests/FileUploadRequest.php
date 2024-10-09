<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
{
    /**
     * @return true
     */
    public function authorize(): true
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'fileName' => 'required|string|max:255',
            'chunkIndex' => 'required|integer|min:0',
            'totalChunks' => 'required|integer|min:1',
            '_token' => 'required|string',
            'file' => 'required|file|max:51200',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'fileName.required' => 'fileName is required.',
            'chunkIndex.required' => 'chunkIndex is required.',
            'totalChunks.required' => 'totalChunks is required.',
            'file.required' => 'File is required.',
            'file.max' => 'The maximum file size must not exceed 50 MB.',
        ];
    }
}
