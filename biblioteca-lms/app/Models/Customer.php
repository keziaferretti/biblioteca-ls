<?php

namespace App\Models;

use App\Concerns\CamelCasing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes, CamelCasing;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'document',
        'phone',
        'address',
        'birth_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
