<?php

namespace App\Http\Interfaces\Services;

use App\Http\Interfaces\DTOs\PublisherDTOInterface;
use App\Support\DefaultReturnType;

interface PublisherServiceInterface
{
    public function list(): DefaultReturnType;
    public function find(int $id): DefaultReturnType;
    public function create(PublisherDTOInterface $dto): DefaultReturnType;
    public function update(PublisherDTOInterface $dto, int $id): DefaultReturnType;
    public function delete(int $id): DefaultReturnType;
}
