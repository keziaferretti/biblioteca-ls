<?php

namespace App\Support;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class DefaultReturnType
{
    private string $message = '';
    private mixed  $data    = null;
    private int    $status  = 200;

    public static function create(): self
    {
        return new self();
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function setData(mixed $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function toJsonResponse(): JsonResponse
    {
        return response()->json([
            'message' => $this->message,
            'data'    => $this->data,
        ], $this->status);
    }

    public function toView(string $view, array $extra = []): View
    {
        return view($view, array_merge([
            'data'    => $this->data,
            'message' => $this->message,
        ], $extra));
    }
}
