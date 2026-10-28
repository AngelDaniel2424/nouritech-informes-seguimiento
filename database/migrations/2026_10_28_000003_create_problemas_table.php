<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('problemas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporte_id')->constrained('reportes')->cascadeOnDelete();
            $table->text('descripcion');
            $table->string('impacto')->default('medio'); // bajo, medio o alto
            $table->string('estado')->default('abierto'); // abierto, en_proceso o resuelto
            $table->text('solucion_propuesta');
            $table->string('responsable')->nullable();
            $table->date('fecha_compromiso')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('problemas');
    }
};
