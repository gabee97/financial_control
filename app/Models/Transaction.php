<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    // Definir os campos que podem ser preenchidos em massa
    protected $fillable = [
        'amount',
        'transaction_date',
        'description',
        'payment_method',
        'category_id',
        'user_id'
    ];

    /**
     * Relacionamento com o usuário (cada transação pertence a um usuário).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com a categoria (cada transação pertence a uma categoria).
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
