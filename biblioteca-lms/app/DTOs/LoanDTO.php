<?php

namespace App\DTOs;

use App\Http\Interfaces\DTOs\LoanDTOInterface;
use App\Http\Requests\Loan\LoanRequest;

readonly class LoanDTO implements LoanDTOInterface
{
    public function __construct(
        public int     $bookId,
        public int     $customerId,
        public string  $loanDate,
        public string  $dueDate,
        public ?string $returnedAt,
        public string  $status,
        public ?int    $id = null,
    ) {}

    public static function fromRequest(LoanRequest $request): self
    {
        return new self(
            bookId:     (int) $request->input('bookId'),
            customerId: (int) $request->input('customerId'),
            loanDate:   $request->input('loanDate'),
            dueDate:    $request->input('dueDate'),
            returnedAt: $request->input('returnedAt'),
            status:     $request->input('status', 'active'),
            id:         $request->route('id') !== null ? (int) $request->route('id') : null,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            bookId:     (int) $data['bookId'],
            customerId: (int) $data['customerId'],
            loanDate:   $data['loanDate'],
            dueDate:    $data['dueDate'],
            returnedAt: $data['returnedAt'] ?? null,
            status:     $data['status']     ?? 'active',
            id:         isset($data['id']) ? (int) $data['id'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'book_id'     => $this->bookId,
            'customer_id' => $this->customerId,
            'loan_date'   => $this->loanDate,
            'due_date'    => $this->dueDate,
            'returned_at' => $this->returnedAt,
            'status'      => $this->status,
        ];
    }
}
