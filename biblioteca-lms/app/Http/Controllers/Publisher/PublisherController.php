<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Controllers\PublisherControllerInterface;
use App\Http\Interfaces\Requests\PublisherRequestInterface;
use App\Http\Interfaces\Services\PublisherServiceInterface;
use App\Support\ExceptionWithData;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class PublisherController extends Controller implements PublisherControllerInterface
{
    public function __construct(private PublisherServiceInterface $service) {}

    public function index(): View
    {
        return $this->service->list()->toView('publishers.index');
    }

    public function create(): View
    {
        return view('publishers.create');
    }

    public function show(int $id): View
    {
        return $this->service->find($id)->toView('publishers.show');
    }

    public function edit(int $id): View
    {
        return $this->service->find($id)->toView('publishers.edit');
    }

    public function store(PublisherRequestInterface $request): JsonResponse
    {
        try {
            return $this->service->create($request->toDTO())->toJsonResponse();
        } catch (Exception $e) {
            return ExceptionWithData::create($e)->toJsonResponse();
        }
    }

    public function update(PublisherRequestInterface $request, int $id): JsonResponse
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
