<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Controllers\BookControllerInterface;
use App\Http\Interfaces\Requests\BookRequestInterface;
use App\Http\Interfaces\Services\BookServiceInterface;
use App\Models\Publisher;
use App\Support\ExceptionWithData;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class BookController extends Controller implements BookControllerInterface
{
    public function __construct(private BookServiceInterface $service) {}

    public function index(): View
    {
        return $this->service->list()->toView('books.index');
    }

    public function create(): View
    {
        return view('books.create', [
            'publishers' => Publisher::query()->orderBy('name')->get(),
        ]);
    }

    public function show(int $id): View
    {
        return $this->service->find($id)->toView('books.show');
    }

    public function edit(int $id): View
    {
        return $this->service->find($id)->toView('books.edit', [
            'publishers' => Publisher::query()->orderBy('name')->get(),
        ]);
    }

    public function store(BookRequestInterface $request): JsonResponse
    {
        try {
            return $this->service->create($request->toDTO())->toJsonResponse();
        } catch (Exception $e) {
            return ExceptionWithData::create($e)->toJsonResponse();
        }
    }

    public function update(BookRequestInterface $request, int $id): JsonResponse
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
