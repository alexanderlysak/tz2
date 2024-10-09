<?php


namespace App\Responses;


class ReportMessageResponse
{
    public bool $success;
    public string $message;
    public mixed $data;
    public int $statusCode;

    /**
     * ReportMessageResponse constructor.
     * @param mixed $data
     * @param bool $success
     * @param string $message
     * @param int $statusCode
     */
    public function __construct(bool $success, string $message, mixed $data, int $statusCode)
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data ?? [];
        $this->statusCode = $statusCode;
    }
}
