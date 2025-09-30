<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Administrador  extends Authenticatable
{
    protected $table = 'administradores';
    use Notifiable;
    use HasFactory;
    
    protected $fillable = [
        'name', 'email', 'password', 'dNasc', 
        'cidade', 'cep', 'logradouro', 'estado',
        'bairro', 'complemento', 'cpf'
    ];
    
    protected $hidden = [
        'password', 'remember_token',
    ];
}
