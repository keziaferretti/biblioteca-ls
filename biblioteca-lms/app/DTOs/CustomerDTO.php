<?php

namespace App\DTOs;

use App\Http\Interfaces\DTOs\CustomerDTOInterface;
use App\Http\Requests\Customer\CustomerRequest;

readonly class CustomerDTO implements CustomerDTOInterface
{
    public function __construct(
        public string  $name,
        public string  $email,
        public string  $document,
        public ?string $phone,
        public ?string $address,
        public ?string $birthDate,
        public ?int    $id = null,
    ) {}

    public static function fromRequest(CustomerRequest $request): self
    {
        return new self(
            name:      $request->input('name'),
            email:     $request->input('email'),
            document:  $request->input('document'),
            phone:     $request->input('phone'),
            address:   $request->input('address'),
            birthDate: $request->input('birthDate'),
            id:        $request->route('id') !== null ? (int) $request->route('id') : null,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name:      $data['name'],
            email:     $data['email'],
            document:  $data['document'],
            phone:     $data['phone']     ?? null,
            address:   $data['address']   ?? null,
            birthDate: $data['birthDate'] ?? null,
            id:        isset($data['id']) ? (int) $data['id'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'name'       => $this->name,
            'email'      => $this->email,
            'document'   => $this->document,
            'phone'      => $this->phone,
            'address'    => $this->address,
            'birth_date' => $this->birthDate,
        ];
    }
}
