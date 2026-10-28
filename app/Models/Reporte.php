<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reporte extends Model
{
    protected $table = 'reportes';

    /** Estado general del proyecto (semáforo). */
    public const ESTADOS = [
        'verde' => 'Verde: avanza según lo planeado',
        'amarillo' => 'Amarillo: hay riesgos o retrasos menores',
        'rojo' => 'Rojo: hay un problema que afecta un hito',
    ];

    protected $fillable = [
        'proyecto',
        'periodo_inicio',
        'periodo_fin',
        'autor',
        'fase_actual',
        'porcentaje_avance',
        'estado_general',
        'resumen',
        'proximos_pasos',
    ];

    protected $casts = [
        'periodo_inicio' => 'date',
        'periodo_fin' => 'date',
    ];

    public function avances(): HasMany
    {
        return $this->hasMany(Avance::class);
    }

    public function problemas(): HasMany
    {
        return $this->hasMany(Problema::class);
    }
}
