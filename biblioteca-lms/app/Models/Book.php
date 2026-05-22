<?php

namespace App\Models;

use App\Concerns\CamelCasing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes, CamelCasing;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'publication_year',
        'total_copies',
        'available_copies',
        'publisher_id',
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'total_copies'     => 'integer',
        'available_copies' => 'integer',
        'publisher_id'     => 'integer',
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
        'deleted_at'       => 'datetime',
    ];

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
