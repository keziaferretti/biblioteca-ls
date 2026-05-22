<?php

namespace App\Http\Interfaces\Requests;

use App\Http\Interfaces\DTOs\LoanDTOInterface;

interface LoanRequestInterface
{
    public function authorize(): bool;
    public function rules(): array;
    public function attributes(): array;
    public function toDTO(): LoanDTOInterface;
}
