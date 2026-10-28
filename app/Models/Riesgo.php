<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Riesgo extends Model
{
    protected $table = 'riesgos';

    public const PROBABILIDADES = [
        'baja' => 'Baja',
        'media' => 'Media',
        'alta' => 'Alta',
    ];

    public const IMPACTOS = [
        'bajo' => 'Bajo',
        'medio' => 'Medio',
        'alto' => 'Alto',
    ];

    protected $fillable = [
        'reporte_id',
        'descripcion',
        'probabilidad',
        'impacto',
        'mitigacion',
        'responsable',
    ];

    public function reporte(): BelongsTo
    {
        return $this->belongsTo(Reporte::class);
    }
}
