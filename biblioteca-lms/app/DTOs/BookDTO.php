<?php

namespace App\DTOs;

use App\Http\Interfaces\DTOs\BookDTOInterface;
use App\Http\Requests\Book\BookRequest;

readonly class BookDTO implements BookDTOInterface
{
    public function __construct(
        public string  $title,
        public string  $author,
        public string  $isbn,
        public int     $publicationYear,
        public int     $totalCopies,
        public int     $availableCopies,
        public int     $publisherId,
        public ?int    $id = null,
    ) {}

    public static function fromRequest(BookRequest $request): self
    {
        return new self(
            title:           $request->input('title'),
            author:          $request->input('author'),
            isbn:            $request->input('isbn'),
            publicationYear: (int) $request->input('publicationYear'),
            totalCopies:     (int) $request->input('totalCopies'),
            availableCopies: (int) $request->input('availableCopies'),
            publisherId:     (int) $request->input('publisherId'),
            id:              $request->route('id') !== null ? (int) $request->route('id') : null,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title:           $data['title'],
            author:          $data['author'],
            isbn:            $data['isbn'],
            publicationYear: (int) $data['publicationYear'],
            totalCopies:     (int) $data['totalCopies'],
            availableCopies: (int) $data['availableCopies'],
            publisherId:     (int) $data['publisherId'],
            id:              isset($data['id']) ? (int) $data['id'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'title'            => $this->title,
            'author'           => $this->author,
            'isbn'             => $this->isbn,
            'publication_year' => $this->publicationYear,
            'total_copies'     => $this->totalCopies,
            'available_copies' => $this->availableCopies,
            'publisher_id'     => $this->publisherId,
        ];
    }
}
