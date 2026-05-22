<?php

namespace App\Http\Requests\Customer;

use App\DTOs\CustomerDTO;
use App\Http\Interfaces\DTOs\CustomerDTOInterface;
use App\Http\Interfaces\Requests\CustomerRequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest implements CustomerRequestInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name'      => 'required|string|max:150',
            'email'     => [
                'required',
                'email',
                'max:150',
                Rule::unique('customers', 'email')->ignore($id),
            ],
            'document'  => [
                'required',
                'string',
                'min:11',
                'max:14',
                Rule::unique('customers', 'document')->ignore($id),
            ],
            'phone'     => 'nullable|string|max:30',
            'address'   => 'nullable|string|max:255',
            'birthDate' => 'nullable|date|before:today',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'name'     => trim((string) $this->input('name')),
            'email'    => strtolower(trim((string) $this->input('email'))),
            'document' => preg_replace('/\D/', '', (string) $this->input('document')),
            'phone'    => $this->input('phone') ? preg_replace('/\s+/', ' ', trim((string) $this->input('phone'))) : null,
        ]);
    }

    public function attributes(): array
    {
        return [
            'name'      => 'Nome',
            'email'     => 'E-mail',
            'document'  => 'CPF',
            'phone'     => 'Telefone',
            'address'   => 'Endereço',
            'birthDate' => 'Data de Nascimento',
        ];
    }

    public function toDTO(): CustomerDTOInterface
    {
        return CustomerDTO::fromRequest($this);
    }
}
