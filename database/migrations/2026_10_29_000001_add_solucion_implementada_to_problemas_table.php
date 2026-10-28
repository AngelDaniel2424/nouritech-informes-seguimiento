<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('problemas', function (Blueprint $table) {
            $table->text('solucion_implementada')->nullable()->after('solucion_propuesta');
        });
    }

    public function down(): void
    {
        Schema::table('problemas', function (Blueprint $table) {
            $table->dropColumn('solucion_implementada');
        });
    }
};
