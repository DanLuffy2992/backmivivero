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
        Schema::create('plantas', function (Blueprint $table) {
            $table->id();
            $table->string('SKU')->unique();
            $table->string('nombre')->nullable();
            $table->string('tipo_planta')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('foto_path')->nullable(); // Ruta del archivo de imagen
            $table->unsignedBigInteger('id_categoria')->nullable();
            $table->text('cuidados')->nullable();
            $table->timestamps();

            $table->foreign('id_categoria')->references('id')->on('categorias')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantas');
    }
};
