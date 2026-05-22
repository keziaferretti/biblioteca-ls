<?php

namespace App\Http\Requests\Publisher;

use App\DTOs\PublisherDTO;
use App\Http\Interfaces\DTOs\PublisherDTOInterface;
use App\Http\Interfaces\Requests\PublisherRequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PublisherRequest extends FormRequest implements PublisherRequestInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name'    => 'required|string|max:200',
            'email'   => [
                'required',
                'email',
                'max:150',
                Rule::unique('publishers', 'email')->ignore($id),
            ],
            'phone'   => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:200',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'name'  => trim((string) $this->input('name')),
            'email' => strtolower(trim((string) $this->input('email'))),
            'phone' => $this->input('phone') ? preg_replace('/\s+/', ' ', trim((string) $this->input('phone'))) : null,
        ]);
    }

    public function attributes(): array
    {
        return [
            'name'    => 'Nome',
            'email'   => 'E-mail',
            'phone'   => 'Telefone',
            'address' => 'Endereço',
            'website' => 'Website',
        ];
    }

    public function toDTO(): PublisherDTOInterface
    {
        return PublisherDTO::fromRequest($this);
    }
}
