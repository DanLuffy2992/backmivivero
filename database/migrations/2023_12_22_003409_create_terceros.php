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
        Schema::create('terceros', function (Blueprint $table) {
            $table->id();
            $table->string('Tipo_Doc')->nullable(); // CC, TI, PA
            $table->string('Doc_Identificacion')->nullable();
            $table->string('Nombre')->nullable();
            $table->string('Apellido')->nullable();
            $table->string('Email')->nullable();
            $table->string('tipo_usuario')->nullable(); // Administrador, Usuario
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terceros');
    }
};

