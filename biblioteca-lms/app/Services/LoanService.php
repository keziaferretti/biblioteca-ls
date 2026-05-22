<?php

namespace App\Services;

use App\Http\Interfaces\DTOs\LoanDTOInterface;
use App\Http\Interfaces\Services\LoanServiceInterface;
use App\Models\Book;
use App\Models\Loan;
use App\Support\DefaultReturnType;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class LoanService implements LoanServiceInterface
{
    public function __construct(
        private Loan $model,
        private Book $bookModel,
    ) {}

    public function list(): DefaultReturnType
    {
        $loans = $this->model->newQuery()
            ->with(['book', 'customer'])
            ->orderByDesc('loan_date')
            ->paginate(10);

        return DefaultReturnType::create()
            ->setData($loans)
            ->setMessage('Empréstimos listados com sucesso.');
    }

    public function find(int $id): DefaultReturnType
    {
        $loan = $this->model->newQuery()
            ->with(['book.publisher', 'customer'])
            ->findOrFail($id);

        return DefaultReturnType::create()
            ->setData($loan)
            ->setMessage('Empréstimo carregado com sucesso.');
    }

    public function create(LoanDTOInterface $dto): DefaultReturnType
    {
        $data = $dto->toArray();

        return DB::transaction(function () use ($data) {
            $book = $this->bookModel->newQuery()->lockForUpdate()->findOrFail($data['book_id']);

            if ((int) $book->available_copies <= 0) {
                throw new RuntimeException(
                    'Não há exemplares disponíveis deste livro para empréstimo.',
                    422,
                );
            }

            $data['status'] = $data['status'] === 'returned' ? 'active' : $data['status'];

            $loan = $this->model->newQuery()->create($data);
            $book->decrement('available_copies');

            return DefaultReturnType::create()
                ->setStatus(201)
                ->setMessage('Empréstimo registrado com sucesso!')
                ->setData($loan->load(['book', 'customer'])->toArray());
        });
    }

    public function update(LoanDTOInterface $dto, int $id): DefaultReturnType
    {
        return DB::transaction(function () use ($dto, $id) {
            $loan        = $this->model->newQuery()->lockForUpdate()->findOrFail($id);
            $payload     = $dto->toArray();
            $oldStatus   = $loan->status;
            $newStatus   = $payload['status'];
            $book        = $this->bookModel->newQuery()->lockForUpdate()->findOrFail($payload['book_id']);
            $bookChanged = (int) $loan->book_id !== (int) $payload['book_id'];

            if ($bookChanged) {
                $previousBook = $this->bookModel->newQuery()->lockForUpdate()->findOrFail($loan->book_id);

                if ($oldStatus === 'active') {
                    $previousBook->increment('available_copies');
                }

                if ($newStatus === 'active') {
                    if ((int) $book->available_copies <= 0) {
                        throw new RuntimeException(
                            'Não há exemplares disponíveis do novo livro selecionado.',
                            422,
                        );
                    }
                    $book->decrement('available_copies');
                }
            } else {
                if ($oldStatus !== 'active' && $newStatus === 'active') {
                    if ((int) $book->available_copies <= 0) {
                        throw new RuntimeException(
                            'Não há exemplares disponíveis para reativar este empréstimo.',
                            422,
                        );
                    }
                    $book->decrement('available_copies');
                } elseif ($oldStatus === 'active' && $newStatus !== 'active') {
                    $book->increment('available_copies');
                }
            }

            if ($newStatus === 'returned' && empty($payload['returned_at'])) {
                $payload['returned_at'] = now();
            }

            if ($newStatus !== 'returned') {
                $payload['returned_at'] = null;
            }

            $loan->update($payload);

            return DefaultReturnType::create()
                ->setMessage('Empréstimo atualizado com sucesso!')
                ->setData($loan->fresh(['book', 'customer'])->toArray());
        });
    }

    public function returnLoan(int $id): DefaultReturnType
    {
        return DB::transaction(function () use ($id) {
            $loan = $this->model->newQuery()->lockForUpdate()->findOrFail($id);

            if ($loan->status === 'returned') {
                throw new RuntimeException('Este empréstimo já foi devolvido.', 422);
            }

            $book = $this->bookModel->newQuery()->lockForUpdate()->findOrFail($loan->book_id);

            $loan->update([
                'status'      => 'returned',
                'returned_at' => now(),
            ]);

            $book->increment('available_copies');

            return DefaultReturnType::create()
                ->setMessage('Devolução registrada com sucesso!')
                ->setData($loan->fresh(['book', 'customer'])->toArray());
        });
    }

    public function delete(int $id): DefaultReturnType
    {
        return DB::transaction(function () use ($id) {
            $loan = $this->model->newQuery()->lockForUpdate()->findOrFail($id);

            if ($loan->status === 'active') {
                $book = $this->bookModel->newQuery()->lockForUpdate()->findOrFail($loan->book_id);
                $book->increment('available_copies');
            }

            $loan->delete();

            return DefaultReturnType::create()
                ->setMessage('Empréstimo excluído com sucesso!');
        });
    }
}
