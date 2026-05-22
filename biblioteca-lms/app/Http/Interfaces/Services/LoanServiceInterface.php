<?php

namespace App\Http\Interfaces\Services;

use App\Http\Interfaces\DTOs\LoanDTOInterface;
use App\Support\DefaultReturnType;

interface LoanServiceInterface
{
    public function list(): DefaultReturnType;
    public function find(int $id): DefaultReturnType;
    public function create(LoanDTOInterface $dto): DefaultReturnType;
    public function update(LoanDTOInterface $dto, int $id): DefaultReturnType;
    public function delete(int $id): DefaultReturnType;
    public function returnLoan(int $id): DefaultReturnType;
}
