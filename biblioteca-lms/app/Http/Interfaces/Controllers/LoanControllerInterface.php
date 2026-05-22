<?php

namespace App\Http\Interfaces\Controllers;

use App\Http\Interfaces\Requests\LoanRequestInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

interface LoanControllerInterface
{
    public function index(): View;
    public function create(): View;
    public function show(int $id): View;
    public function edit(int $id): View;
    public function store(LoanRequestInterface $request): JsonResponse;
    public function update(LoanRequestInterface $request, int $id): JsonResponse;
    public function destroy(int $id): JsonResponse;
    public function returnLoan(int $id): JsonResponse;
}
