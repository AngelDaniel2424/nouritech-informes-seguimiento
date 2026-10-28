<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Problema extends Model
{
    protected $table = 'problemas';

    public const IMPACTOS = [
        'bajo' => 'Bajo',
        'medio' => 'Medio',
        'alto' => 'Alto',
    ];

    public const ESTADOS = [
        'abierto' => 'Abierto',
        'en_proceso' => 'En proceso',
        'resuelto' => 'Resuelto',
    ];

    protected $fillable = [
        'reporte_id',
        'descripcion',
        'impacto',
        'estado',
        'solucion_propuesta',
        'responsable',
        'fecha_compromiso',
    ];

    protected $casts = [
        'fecha_compromiso' => 'date',
    ];

    public function reporte(): BelongsTo
    {
        return $this->belongsTo(Reporte::class);
    }
}
