<?php

use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Loan\LoanController;
use App\Http\Controllers\Publisher\PublisherController;
use App\Models\Book;
use App\Models\Customer;
use App\Models\Loan;
use App\Models\Publisher;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard.index', [
        'totalBooks'        => Book::query()->count(),
        'totalPublishers'   => Publisher::query()->count(),
        'totalCustomers'    => Customer::query()->count(),
        'activeLoansCount'  => Loan::query()->where('status', 'active')->count(),
        'overdueLoansCount' => Loan::query()->where('status', 'overdue')->count(),
        'recentLoans'       => Loan::query()
            ->with(['book', 'customer'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get(),
    ]);
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Publishers
|--------------------------------------------------------------------------
*/
Route::prefix('publishers')->name('publishers.')->group(function () {
    Route::get('/',           [PublisherController::class, 'index'])->name('index');
    Route::get('/create',     [PublisherController::class, 'create'])->name('create');
    Route::post('/',          [PublisherController::class, 'store'])->name('store');
    Route::get('/{id}',       [PublisherController::class, 'show'])->whereNumber('id')->name('show');
    Route::get('/{id}/edit',  [PublisherController::class, 'edit'])->whereNumber('id')->name('edit');
    Route::put('/{id}',       [PublisherController::class, 'update'])->whereNumber('id')->name('update');
    Route::delete('/{id}',    [PublisherController::class, 'destroy'])->whereNumber('id')->name('destroy');
});

/*
|--------------------------------------------------------------------------
| Books
|--------------------------------------------------------------------------
*/
Route::prefix('books')->name('books.')->group(function () {
    Route::get('/',           [BookController::class, 'index'])->name('index');
    Route::get('/create',     [BookController::class, 'create'])->name('create');
    Route::post('/',          [BookController::class, 'store'])->name('store');
    Route::get('/{id}',       [BookController::class, 'show'])->whereNumber('id')->name('show');
    Route::get('/{id}/edit',  [BookController::class, 'edit'])->whereNumber('id')->name('edit');
    Route::put('/{id}',       [BookController::class, 'update'])->whereNumber('id')->name('update');
    Route::delete('/{id}',    [BookController::class, 'destroy'])->whereNumber('id')->name('destroy');
});

/*
|--------------------------------------------------------------------------
| Customers
|--------------------------------------------------------------------------
*/
Route::prefix('customers')->name('customers.')->group(function () {
    Route::get('/',           [CustomerController::class, 'index'])->name('index');
    Route::get('/create',     [CustomerController::class, 'create'])->name('create');
    Route::post('/',          [CustomerController::class, 'store'])->name('store');
    Route::get('/{id}',       [CustomerController::class, 'show'])->whereNumber('id')->name('show');
    Route::get('/{id}/edit',  [CustomerController::class, 'edit'])->whereNumber('id')->name('edit');
    Route::put('/{id}',       [CustomerController::class, 'update'])->whereNumber('id')->name('update');
    Route::delete('/{id}',    [CustomerController::class, 'destroy'])->whereNumber('id')->name('destroy');
});

/*
|--------------------------------------------------------------------------
| Loans
|--------------------------------------------------------------------------
*/
Route::prefix('loans')->name('loans.')->group(function () {
    Route::get('/',                  [LoanController::class, 'index'])->name('index');
    Route::get('/create',            [LoanController::class, 'create'])->name('create');
    Route::post('/',                 [LoanController::class, 'store'])->name('store');
    Route::get('/{id}',              [LoanController::class, 'show'])->whereNumber('id')->name('show');
    Route::get('/{id}/edit',         [LoanController::class, 'edit'])->whereNumber('id')->name('edit');
    Route::put('/{id}',              [LoanController::class, 'update'])->whereNumber('id')->name('update');
    Route::patch('/{id}/return',     [LoanController::class, 'returnLoan'])->whereNumber('id')->name('return');
    Route::delete('/{id}',           [LoanController::class, 'destroy'])->whereNumber('id')->name('destroy');
});
