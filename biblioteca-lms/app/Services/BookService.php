<?php

namespace App\Services;

use App\Http\Interfaces\DTOs\BookDTOInterface;
use App\Http\Interfaces\Services\BookServiceInterface;
use App\Models\Book;
use App\Support\DefaultReturnType;
use RuntimeException;

class BookService implements BookServiceInterface
{
    public function __construct(private Book $model) {}

    public function list(): DefaultReturnType
    {
        $books = $this->model->newQuery()
            ->with('publisher')
            ->orderBy('title')
            ->paginate(10);

        return DefaultReturnType::create()
            ->setData($books)
            ->setMessage('Livros listados com sucesso.');
    }

    public function find(int $id): DefaultReturnType
    {
        $book = $this->model->newQuery()
            ->with('publisher')
            ->withCount(['loans as active_loans_count' => function ($q) {
                $q->where('status', 'active');
            }])
            ->findOrFail($id);

        return DefaultReturnType::create()
            ->setData($book)
            ->setMessage('Livro carregado com sucesso.');
    }

    public function create(BookDTOInterface $dto): DefaultReturnType
    {
        $book = $this->model->newQuery()->create($dto->toArray());

        return DefaultReturnType::create()
            ->setStatus(201)
            ->setMessage('Livro cadastrado com sucesso!')
            ->setData($book->load('publisher')->toArray());
    }

    public function update(BookDTOInterface $dto, int $id): DefaultReturnType
    {
        $book = $this->model->newQuery()->findOrFail($id);
        $book->update($dto->toArray());

        return DefaultReturnType::create()
            ->setMessage('Livro atualizado com sucesso!')
            ->setData($book->fresh('publisher')->toArray());
    }

    public function delete(int $id): DefaultReturnType
    {
        $book = $this->model->newQuery()->findOrFail($id);

        $activeLoans = $book->loans()->where('status', 'active')->count();

        if ($activeLoans > 0) {
            throw new RuntimeException(
                'Não é possível excluir um livro com exemplares emprestados.',
                422,
            );
        }

        $book->delete();

        return DefaultReturnType::create()
            ->setMessage('Livro excluído com sucesso!');
    }
}
