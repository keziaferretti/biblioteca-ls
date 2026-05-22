<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Controllers\LoanControllerInterface;
use App\Http\Interfaces\Requests\LoanRequestInterface;
use App\Http\Interfaces\Services\LoanServiceInterface;
use App\Models\Book;
use App\Models\Customer;
use App\Support\ExceptionWithData;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class LoanController extends Controller implements LoanControllerInterface
{
    public function __construct(private LoanServiceInterface $service) {}

    public function index(): View
    {
        return $this->service->list()->toView('loans.index');
    }

    public function create(): View
    {
        return view('loans.create', [
            'books'     => Book::query()->where('available_copies', '>', 0)->orderBy('title')->get(),
            'customers' => Customer::query()->orderBy('name')->get(),
        ]);
    }

    public function show(int $id): View
    {
        return $this->service->find($id)->toView('loans.show');
    }

    public function edit(int $id): View
    {
        return $this->service->find($id)->toView('loans.edit', [
            'books'     => Book::query()->orderBy('title')->get(),
            'customers' => Customer::query()->orderBy('name')->get(),
        ]);
    }

    public function store(LoanRequestInterface $request): JsonResponse
    {
        try {
            return $this->service->create($request->toDTO())->toJsonResponse();
        } catch (Exception $e) {
            return ExceptionWithData::create($e)->toJsonResponse();
        }
    }

    public function update(LoanRequestInterface $request, int $id): JsonResponse
    {
        try {
            return $this->service->update($request->toDTO(), $id)->toJsonResponse();
        } catch (Exception $e) {
            return ExceptionWithData::create($e)->toJsonResponse();
        }
    }

    public function returnLoan(int $id): JsonResponse
    {
        try {
            return $this->service->returnLoan($id)->toJsonResponse();
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
