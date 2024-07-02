<?php

namespace App\Formatter;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponseFormatter
{
    private $data;
    private $message;
    private $errors;
    private $statusCode;

    public function __construct($data = null, string $message = '', array $errors = [], int $statusCode = 200)
    {
        $this->data = $data;
        $this->message = $message;
        $this->errors = $errors;
        $this->statusCode = $statusCode;
    }

    public function getResponse(): JsonResponse
    {
        $response = [
            'data' => $this->data,
            'message' => $this->message,
            'errors' => $this->errors,
        ];

        return new JsonResponse($response, $this->statusCode);
    }

    public function withData($data): self
    {
        $this->data = $data;
        return $this;
    }

    public function withMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function withErrors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }

    public function withStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}
