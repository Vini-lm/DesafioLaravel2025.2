<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    protected $table = 'administradores';

    use HasFactory;
    
    protected $fillable = [
        'name', 'email', 'password', 'dNasc', 
        'cidade', 'cep', 'logradouro', 'estado',
        'bairro', 'complemento', 'cpf'
    ];
}
