<?php

namespace App\Services;

use App\Http\Interfaces\DTOs\CustomerDTOInterface;
use App\Http\Interfaces\Services\CustomerServiceInterface;
use App\Models\Customer;
use App\Support\DefaultReturnType;
use RuntimeException;

class CustomerService implements CustomerServiceInterface
{
    public function __construct(private Customer $model) {}

    public function list(): DefaultReturnType
    {
        $customers = $this->model->newQuery()
            ->withCount(['loans as active_loans_count' => function ($q) {
                $q->where('status', 'active');
            }])
            ->orderBy('name')
            ->paginate(10);

        return DefaultReturnType::create()
            ->setData($customers)
            ->setMessage('Clientes listados com sucesso.');
    }

    public function find(int $id): DefaultReturnType
    {
        $customer = $this->model->newQuery()
            ->with(['loans.book'])
            ->withCount(['loans as active_loans_count' => function ($q) {
                $q->where('status', 'active');
            }])
            ->findOrFail($id);

        return DefaultReturnType::create()
            ->setData($customer)
            ->setMessage('Cliente carregado com sucesso.');
    }

    public function create(CustomerDTOInterface $dto): DefaultReturnType
    {
        $customer = $this->model->newQuery()->create($dto->toArray());

        return DefaultReturnType::create()
            ->setStatus(201)
            ->setMessage('Cliente cadastrado com sucesso!')
            ->setData($customer->toArray());
    }

    public function update(CustomerDTOInterface $dto, int $id): DefaultReturnType
    {
        $customer = $this->model->newQuery()->findOrFail($id);
        $customer->update($dto->toArray());

        return DefaultReturnType::create()
            ->setMessage('Cliente atualizado com sucesso!')
            ->setData($customer->fresh()->toArray());
    }

    public function delete(int $id): DefaultReturnType
    {
        $customer = $this->model->newQuery()->findOrFail($id);

        $activeLoans = $customer->loans()->where('status', 'active')->count();

        if ($activeLoans > 0) {
            throw new RuntimeException(
                'Não é possível excluir um cliente com empréstimos ativos.',
                422,
            );
        }

        $customer->delete();

        return DefaultReturnType::create()
            ->setMessage('Cliente excluído com sucesso!');
    }
}
