<?php

namespace App\Http\Requests\Book;

use App\DTOs\BookDTO;
use App\Http\Interfaces\DTOs\BookDTOInterface;
use App\Http\Interfaces\Requests\BookRequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest implements BookRequestInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'title'           => 'required|string|max:200',
            'author'          => 'required|string|max:150',
            'isbn'            => [
                'required',
                'string',
                'max:20',
                Rule::unique('books', 'isbn')->ignore($id),
            ],
            'publicationYear' => 'required|integer|min:1500|max:' . date('Y'),
            'totalCopies'     => 'required|integer|min:1|max:10000',
            'availableCopies' => 'required|integer|min:0|lte:totalCopies',
            'publisherId'     => 'required|integer|exists:publishers,id',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'title'  => trim((string) $this->input('title')),
            'author' => trim((string) $this->input('author')),
            'isbn'   => preg_replace('/[^0-9X]/', '', strtoupper((string) $this->input('isbn'))),
        ]);
    }

    public function attributes(): array
    {
        return [
            'title'           => 'Título',
            'author'          => 'Autor',
            'isbn'            => 'ISBN',
            'publicationYear' => 'Ano de Publicação',
            'totalCopies'     => 'Total de Exemplares',
            'availableCopies' => 'Exemplares Disponíveis',
            'publisherId'     => 'Editora',
        ];
    }

    public function toDTO(): BookDTOInterface
    {
        return BookDTO::fromRequest($this);
    }
}
