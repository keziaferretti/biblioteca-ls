<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;
use Throwable;

class ExceptionWithData
{
    private function __construct(private readonly Throwable $exception) {}

    public static function create(Throwable $e): self
    {
        return new self($e);
    }

    public function toJsonResponse(): JsonResponse
    {
        $code   = $this->exception->getCode();
        $status = (is_int($code) && $code >= 400 && $code < 600) ? $code : 500;

        return response()->json([
            'message' => $this->exception->getMessage(),
            'data'    => null,
        ], $status);
    }
}
