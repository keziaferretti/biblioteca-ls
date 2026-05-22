<?php

namespace App\Providers;

use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Loan\LoanController;
use App\Http\Controllers\Publisher\PublisherController;
use App\Http\Interfaces\Controllers\BookControllerInterface;
use App\Http\Interfaces\Controllers\CustomerControllerInterface;
use App\Http\Interfaces\Controllers\LoanControllerInterface;
use App\Http\Interfaces\Controllers\PublisherControllerInterface;
use App\Http\Interfaces\Requests\BookRequestInterface;
use App\Http\Interfaces\Requests\CustomerRequestInterface;
use App\Http\Interfaces\Requests\LoanRequestInterface;
use App\Http\Interfaces\Requests\PublisherRequestInterface;
use App\Http\Interfaces\Services\BookServiceInterface;
use App\Http\Interfaces\Services\CustomerServiceInterface;
use App\Http\Interfaces\Services\LoanServiceInterface;
use App\Http\Interfaces\Services\PublisherServiceInterface;
use App\Http\Requests\Book\BookRequest;
use App\Http\Requests\Customer\CustomerRequest;
use App\Http\Requests\Loan\LoanRequest;
use App\Http\Requests\Publisher\PublisherRequest;
use App\Services\BookService;
use App\Services\CustomerService;
use App\Services\LoanService;
use App\Services\PublisherService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Service bindings
        $this->app->bind(PublisherServiceInterface::class, PublisherService::class);
        $this->app->bind(BookServiceInterface::class,      BookService::class);
        $this->app->bind(CustomerServiceInterface::class,  CustomerService::class);
        $this->app->bind(LoanServiceInterface::class,      LoanService::class);

        // FormRequest bindings — let the container resolve the concrete FormRequest when an interface is type-hinted
        $this->app->bind(PublisherRequestInterface::class, PublisherRequest::class);
        $this->app->bind(BookRequestInterface::class,      BookRequest::class);
        $this->app->bind(CustomerRequestInterface::class,  CustomerRequest::class);
        $this->app->bind(LoanRequestInterface::class,      LoanRequest::class);

        // Controller bindings (optional but completes the contract)
        $this->app->bind(PublisherControllerInterface::class, PublisherController::class);
        $this->app->bind(BookControllerInterface::class,      BookController::class);
        $this->app->bind(CustomerControllerInterface::class,  CustomerController::class);
        $this->app->bind(LoanControllerInterface::class,      LoanController::class);
    }

    public function boot(): void
    {
        //
    }
}
