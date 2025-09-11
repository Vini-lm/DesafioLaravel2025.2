<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{

    protected $table = 'produtos';

    use HasFactory;

    protected $fillable = [
        'nome', 'desc', 'preco', 
        'categoria', 'quantidade', 
        'vendedor_id'
    ];
}
