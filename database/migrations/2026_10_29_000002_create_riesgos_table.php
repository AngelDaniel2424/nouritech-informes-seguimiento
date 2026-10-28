<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riesgos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporte_id')->constrained('reportes')->cascadeOnDelete();
            $table->text('descripcion');
            $table->string('probabilidad')->default('media'); // baja, media o alta
            $table->string('impacto')->default('medio'); // bajo, medio o alto
            $table->text('mitigacion');
            $table->string('responsable')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riesgos');
    }
};
