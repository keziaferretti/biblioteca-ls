<?php

namespace App\Models;

use App\Concerns\CamelCasing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use HasFactory, SoftDeletes, CamelCasing;

    public const STATUS_ACTIVE   = 'active';
    public const STATUS_RETURNED = 'returned';
    public const STATUS_OVERDUE  = 'overdue';

    protected $table = 'loans';

    protected $fillable = [
        'book_id',
        'customer_id',
        'loan_date',
        'due_date',
        'returned_at',
        'status',
    ];

    protected $casts = [
        'loan_date'   => 'date',
        'due_date'    => 'date',
        'returned_at' => 'datetime',
        'book_id'     => 'integer',
        'customer_id' => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => 'datetime',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
