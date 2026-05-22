<?php

namespace App\DTOs;

use App\Http\Interfaces\DTOs\PublisherDTOInterface;
use App\Http\Requests\Publisher\PublisherRequest;

readonly class PublisherDTO implements PublisherDTOInterface
{
    public function __construct(
        public string  $name,
        public string  $email,
        public ?string $phone,
        public ?string $address,
        public ?string $website,
        public ?int    $id = null,
    ) {}

    public static function fromRequest(PublisherRequest $request): self
    {
        return new self(
            name:    $request->input('name'),
            email:   $request->input('email'),
            phone:   $request->input('phone'),
            address: $request->input('address'),
            website: $request->input('website'),
            id:      $request->route('id') !== null ? (int) $request->route('id') : null,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name:    $data['name'],
            email:   $data['email'],
            phone:   $data['phone']   ?? null,
            address: $data['address'] ?? null,
            website: $data['website'] ?? null,
            id:      isset($data['id']) ? (int) $data['id'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'address' => $this->address,
            'website' => $this->website,
        ];
    }
}
