<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avance extends Model
{
    protected $table = 'avances';

    public const ESTADOS = [
        'completado' => 'Completado',
        'en_progreso' => 'En progreso',
    ];

    protected $fillable = ['reporte_id', 'actividad', 'detalle', 'entregable', 'estado'];

    public function reporte(): BelongsTo
    {
        return $this->belongsTo(Reporte::class);
    }
}
