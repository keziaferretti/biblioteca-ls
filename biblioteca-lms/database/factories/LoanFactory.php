<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Customer;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    protected $model = Loan::class;

    public function definition(): array
    {
        $loanDate = Carbon::instance($this->faker->dateTimeBetween('-60 days', 'now'));
        $dueDate  = (clone $loanDate)->addDays(14);
        $status   = $this->faker->randomElement([
            Loan::STATUS_ACTIVE,
            Loan::STATUS_ACTIVE,
            Loan::STATUS_ACTIVE,
            Loan::STATUS_RETURNED,
            Loan::STATUS_OVERDUE,
        ]);

        $returnedAt = null;
        if ($status === Loan::STATUS_RETURNED) {
            $returnedAt = (clone $loanDate)->addDays($this->faker->numberBetween(1, 13));
        }

        if ($status === Loan::STATUS_OVERDUE) {
            $dueDate = Carbon::now()->subDays($this->faker->numberBetween(1, 20));
        }

        return [
            'book_id'     => Book::query()->inRandomOrder()->value('id') ?? Book::factory(),
            'customer_id' => Customer::query()->inRandomOrder()->value('id') ?? Customer::factory(),
            'loan_date'   => $loanDate->toDateString(),
            'due_date'    => $dueDate->toDateString(),
            'returned_at' => $returnedAt,
            'status'      => $status,
        ];
    }

    public function active(): self
    {
        return $this->state(fn () => [
            'status'      => Loan::STATUS_ACTIVE,
            'returned_at' => null,
        ]);
    }
}
