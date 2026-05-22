<?php

namespace App\Http\Requests\Loan;

use App\DTOs\LoanDTO;
use App\Http\Interfaces\DTOs\LoanDTOInterface;
use App\Http\Interfaces\Requests\LoanRequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoanRequest extends FormRequest implements LoanRequestInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bookId'     => 'required|integer|exists:books,id',
            'customerId' => 'required|integer|exists:customers,id',
            'loanDate'   => 'required|date',
            'dueDate'    => 'required|date|after_or_equal:loanDate',
            'returnedAt' => 'nullable|date|after_or_equal:loanDate',
            'status'     => ['required', Rule::in(['active', 'returned', 'overdue'])],
        ];
    }

    public function prepareForValidation(): void
    {
        if (!$this->has('status') || $this->input('status') === null) {
            $this->merge(['status' => 'active']);
        }

        if (!$this->has('loanDate') || !$this->input('loanDate')) {
            $this->merge(['loanDate' => now()->toDateString()]);
        }

        if (!$this->has('dueDate') || !$this->input('dueDate')) {
            $this->merge(['dueDate' => now()->addDays(14)->toDateString()]);
        }
    }

    public function attributes(): array
    {
        return [
            'bookId'     => 'Livro',
            'customerId' => 'Cliente',
            'loanDate'   => 'Data do Empréstimo',
            'dueDate'    => 'Data de Devolução Prevista',
            'returnedAt' => 'Data de Devolução',
            'status'     => 'Status',
        ];
    }

    public function toDTO(): LoanDTOInterface
    {
        return LoanDTO::fromRequest($this);
    }
}
