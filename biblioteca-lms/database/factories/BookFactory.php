<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $books = [
            ['The Pragmatic Programmer',          'David Thomas, Andrew Hunt'],
            ['Clean Code',                        'Robert C. Martin'],
            ['Design Patterns',                   'Erich Gamma et al.'],
            ['Refactoring',                       'Martin Fowler'],
            ['Domain-Driven Design',              'Eric Evans'],
            ['The Mythical Man-Month',            'Frederick P. Brooks Jr.'],
            ['Structure and Interpretation of Computer Programs', 'Harold Abelson, Gerald Jay Sussman'],
            ['Code Complete',                     'Steve McConnell'],
            ['Working Effectively with Legacy Code', 'Michael Feathers'],
            ['Introduction to Algorithms',        'Thomas H. Cormen et al.'],
            ['The Art of Computer Programming',   'Donald E. Knuth'],
            ['Cracking the Coding Interview',     'Gayle Laakmann McDowell'],
            ['You Don\'t Know JS',                'Kyle Simpson'],
            ['Eloquent JavaScript',               'Marijn Haverbeke'],
            ['Fluent Python',                     'Luciano Ramalho'],
            ['Effective Java',                    'Joshua Bloch'],
            ['The Go Programming Language',       'Alan A. A. Donovan, Brian W. Kernighan'],
            ['Programming Rust',                  'Jim Blandy, Jason Orendorff'],
            ['Database Internals',                'Alex Petrov'],
            ['Designing Data-Intensive Applications', 'Martin Kleppmann'],
        ];

        [$title, $author] = $this->faker->unique()->randomElement($books);
        $total            = $this->faker->numberBetween(3, 12);
        $available        = $this->faker->numberBetween(0, $total);

        return [
            'title'            => $title,
            'author'           => $author,
            'isbn'             => $this->faker->unique()->numerify('978##########'),
            'publication_year' => $this->faker->numberBetween(1990, (int) date('Y')),
            'total_copies'     => $total,
            'available_copies' => $available,
            'publisher_id'     => Publisher::query()->inRandomOrder()->value('id') ?? Publisher::factory(),
        ];
    }
}
