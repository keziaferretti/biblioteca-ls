<?php

namespace App\Http\Interfaces\Controllers;

use App\Http\Interfaces\Requests\BookRequestInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

interface BookControllerInterface
{
    public function index(): View;
    public function create(): View;
    public function show(int $id): View;
    public function edit(int $id): View;
    public function store(BookRequestInterface $request): JsonResponse;
    public function update(BookRequestInterface $request, int $id): JsonResponse;
    public function destroy(int $id): JsonResponse;
}
