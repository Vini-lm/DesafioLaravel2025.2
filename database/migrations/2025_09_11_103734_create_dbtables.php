<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {


         Schema::create('produtos', function (Blueprint $table){
            $table->id();

            $table->unsignedBigInteger('vendedor_id');
            $table->foreign('vendedor_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('desc');
            $table->string('nome');
            $table->float('preco',8,2);
            $table->string('categoria');
            $table->integer('quantidade');
            $table->string('foto')->nullable();
            $table->timestamps();
        });



        Schema::create('compras', function (Blueprint $table) {
            $table->id(); // Primary key

            $table->unsignedBigInteger('cliente_id'); //fk para o cliente que fez a compra (comprador).
            $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('produto_id'); //fk para o produto comprado
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
            $table->timestamps();
        });

       
        Schema::create('administradores', function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('dNasc');

            $table->string('cidade');
            $table->string('cep');
            $table->string('logradouro');
            $table->string('estado');
            $table->string('bairro');
            $table->string('complemento');

            $table->string('cpf');
            $table->string('foto')->nullable();
           
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
        Schema::dropIfExists('produtos');
        Schema::dropIfExists('administradores');
    }
};
