<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_comercial');
            $table->string('rut')->unique();
            $table->string('direccion');
            $table->enum('categoria', ['regular', 'preferencial']);
            $table->string('contacto_nombre');
            $table->string('contacto_email');
            $table->decimal('porcentaje_oferta', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};