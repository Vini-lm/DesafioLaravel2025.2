<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{

  use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'desc',
        'preco',
        'categoria',
        'quantidade',
        'foto',          
        'vendedor_id'
    ];

    
    public function vendedor()
    {
        return $this->belongsTo(User::class, 'vendedor_id');
    }
}
