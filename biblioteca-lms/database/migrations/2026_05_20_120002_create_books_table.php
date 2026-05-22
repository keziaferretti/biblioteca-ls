<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('author', 150);
            $table->string('isbn', 20)->unique();
            $table->unsignedSmallInteger('publication_year');
            $table->unsignedInteger('total_copies')->default(0);
            $table->unsignedInteger('available_copies')->default(0);
            $table->foreignId('publisher_id')->constrained('publishers')->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('title');
            $table->index('author');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
