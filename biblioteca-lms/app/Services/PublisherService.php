<?php

namespace App\Services;

use App\Http\Interfaces\DTOs\PublisherDTOInterface;
use App\Http\Interfaces\Services\PublisherServiceInterface;
use App\Models\Publisher;
use App\Support\DefaultReturnType;
use RuntimeException;

class PublisherService implements PublisherServiceInterface
{
    public function __construct(private Publisher $model) {}

    public function list(): DefaultReturnType
    {
        $publishers = $this->model->newQuery()
            ->withCount('books')
            ->orderBy('name')
            ->paginate(10);

        return DefaultReturnType::create()
            ->setData($publishers)
            ->setMessage('Editoras listadas com sucesso.');
    }

    public function find(int $id): DefaultReturnType
    {
        $publisher = $this->model->newQuery()
            ->withCount('books')
            ->findOrFail($id);

        return DefaultReturnType::create()
            ->setData($publisher)
            ->setMessage('Editora carregada com sucesso.');
    }

    public function create(PublisherDTOInterface $dto): DefaultReturnType
    {
        $publisher = $this->model->newQuery()->create($dto->toArray());

        return DefaultReturnType::create()
            ->setStatus(201)
            ->setMessage('Editora cadastrada com sucesso!')
            ->setData($publisher->toArray());
    }

    public function update(PublisherDTOInterface $dto, int $id): DefaultReturnType
    {
        $publisher = $this->model->newQuery()->findOrFail($id);
        $publisher->update($dto->toArray());

        return DefaultReturnType::create()
            ->setMessage('Editora atualizada com sucesso!')
            ->setData($publisher->fresh()->toArray());
    }

    public function delete(int $id): DefaultReturnType
    {
        $publisher = $this->model->newQuery()->withCount('books')->findOrFail($id);

        if ($publisher->books_count > 0) {
            throw new RuntimeException(
                'Não é possível excluir uma editora que possui livros cadastrados.',
                422,
            );
        }

        $publisher->delete();

        return DefaultReturnType::create()
            ->setMessage('Editora excluída com sucesso!');
    }
}
