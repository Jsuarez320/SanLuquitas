<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 150);
            $table->string('slug')->unique();
            $table->string('tipo', 20)->default('noticia')->index();      // noticia | comunicado
            $table->string('categoria', 60);
            $table->string('extracto', 220);
            $table->text('cuerpo');                                        // párrafos separados por línea en blanco
            $table->string('imagen_path')->nullable();
            $table->string('estado', 20)->default('borrador')->index();   // borrador | publicado
            $table->date('publicada_en');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
