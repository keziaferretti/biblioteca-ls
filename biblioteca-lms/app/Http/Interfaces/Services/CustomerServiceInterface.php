<?php

namespace App\Http\Interfaces\Services;

use App\Http\Interfaces\DTOs\CustomerDTOInterface;
use App\Support\DefaultReturnType;

interface CustomerServiceInterface
{
    public function list(): DefaultReturnType;
    public function find(int $id): DefaultReturnType;
    public function create(CustomerDTOInterface $dto): DefaultReturnType;
    public function update(CustomerDTOInterface $dto, int $id): DefaultReturnType;
    public function delete(int $id): DefaultReturnType;
}
