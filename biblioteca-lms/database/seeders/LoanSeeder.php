<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Customer;
use App\Models\Loan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        if (Book::query()->count() === 0 || Customer::query()->count() === 0) {
            return;
        }

        Loan::factory()->count(25)->create();

        DB::transaction(function () {
            $activeLoansPerBook = Loan::query()
                ->where('status', 'active')
                ->selectRaw('book_id, COUNT(*) as cnt')
                ->groupBy('book_id')
                ->pluck('cnt', 'book_id');

            foreach ($activeLoansPerBook as $bookId => $count) {
                $book = Book::query()->find($bookId);
                if (!$book) {
                    continue;
                }

                $newAvailable = max(0, $book->total_copies - (int) $count);
                $book->update(['available_copies' => $newAvailable]);
            }
        });
    }
}
