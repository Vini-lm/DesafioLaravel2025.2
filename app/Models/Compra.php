<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'produto_id'
    ];
}
