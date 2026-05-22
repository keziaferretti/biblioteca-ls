<?php

namespace App\Http\Interfaces\Controllers;

use App\Http\Interfaces\Requests\PublisherRequestInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

interface PublisherControllerInterface
{
    public function index(): View;
    public function create(): View;
    public function show(int $id): View;
    public function edit(int $id): View;
    public function store(PublisherRequestInterface $request): JsonResponse;
    public function update(PublisherRequestInterface $request, int $id): JsonResponse;
    public function destroy(int $id): JsonResponse;
}
