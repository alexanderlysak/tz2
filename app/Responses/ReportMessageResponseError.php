<?php


namespace App\Responses;


class ReportMessageResponseError
{
    public bool $success;
    public string $message;
    public mixed $errors;
    public int $statusCode;

    /**
     * ReportMessageResponse constructor.
     * @param mixed $errors
     * @param bool $success
     * @param string $message
     * @param int $statusCode
     */
    public function __construct(bool $success, string $message, mixed $errors, int $statusCode)
    {
        $this->success = $success;
        $this->message = $message;
        $this->errors = $errors ?? [];
        $this->statusCode = $statusCode;
    }
}
