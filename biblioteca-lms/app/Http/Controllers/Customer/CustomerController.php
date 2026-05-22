<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Controllers\CustomerControllerInterface;
use App\Http\Interfaces\Requests\CustomerRequestInterface;
use App\Http\Interfaces\Services\CustomerServiceInterface;
use App\Support\ExceptionWithData;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller implements CustomerControllerInterface
{
    public function __construct(private CustomerServiceInterface $service) {}

    public function index(): View
    {
        return $this->service->list()->toView('customers.index');
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function show(int $id): View
    {
        return $this->service->find($id)->toView('customers.show');
    }

    public function edit(int $id): View
    {
        return $this->service->find($id)->toView('customers.edit');
    }

    public function store(CustomerRequestInterface $request): JsonResponse
    {
        try {
            return $this->service->create($request->toDTO())->toJsonResponse();
        } catch (Exception $e) {
            return ExceptionWithData::create($e)->toJsonResponse();
        }
    }

    public function update(CustomerRequestInterface $request, int $id): JsonResponse
    {
        try {
            return $this->service->update($request->toDTO(), $id)->toJsonResponse();
        } catch (Exception $e) {
            return ExceptionWithData::create($e)->toJsonResponse();
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            return $this->service->delete($id)->toJsonResponse();
        } catch (Exception $e) {
            return ExceptionWithData::create($e)->toJsonResponse();
        }
    }
}
