<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporte_id')->constrained('reportes')->cascadeOnDelete();
            $table->string('actividad');
            $table->text('detalle')->nullable();
            $table->string('entregable')->nullable();
            $table->string('estado')->default('completado'); // completado o en_progreso
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avances');
    }
};
