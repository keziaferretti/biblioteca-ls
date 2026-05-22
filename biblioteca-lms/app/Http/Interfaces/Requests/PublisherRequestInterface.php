<?php

namespace App\Http\Interfaces\Requests;

use App\Http\Interfaces\DTOs\PublisherDTOInterface;

interface PublisherRequestInterface
{
    public function authorize(): bool;
    public function rules(): array;
    public function attributes(): array;
    public function toDTO(): PublisherDTOInterface;
}
