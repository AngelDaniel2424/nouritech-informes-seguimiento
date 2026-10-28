<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->string('proyecto')->default('Food Waste Analytics');
            $table->date('periodo_inicio');
            $table->date('periodo_fin');
            $table->string('autor');
            $table->string('fase_actual');
            $table->unsignedTinyInteger('porcentaje_avance')->default(0);
            $table->string('estado_general')->default('verde'); // verde, amarillo o rojo
            $table->text('resumen');
            $table->text('proximos_pasos')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
