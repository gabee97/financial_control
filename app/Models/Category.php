<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    // Definir os campos que podem ser preenchidos em massa
    protected $fillable = [
        'name',
        'type',
        'user_id'
    ];

    /**
     * Relacionamento com o usuário (cada categoria pertence a um usuário).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com transações (uma categoria pode ter várias transações).
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
