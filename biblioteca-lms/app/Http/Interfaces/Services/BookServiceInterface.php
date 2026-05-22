<?php

namespace App\Http\Interfaces\Services;

use App\Http\Interfaces\DTOs\BookDTOInterface;
use App\Support\DefaultReturnType;

interface BookServiceInterface
{
    public function list(): DefaultReturnType;
    public function find(int $id): DefaultReturnType;
    public function create(BookDTOInterface $dto): DefaultReturnType;
    public function update(BookDTOInterface $dto, int $id): DefaultReturnType;
    public function delete(int $id): DefaultReturnType;
}
