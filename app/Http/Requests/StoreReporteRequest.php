<?php

namespace App\Http\Requests;

use App\Models\Avance;
use App\Models\Problema;
use App\Models\Reporte;
use App\Models\Riesgo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReporteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proyecto' => ['required', 'string', 'max:120'],
            'periodo_inicio' => ['required', 'date'],
            'periodo_fin' => ['required', 'date', 'after_or_equal:periodo_inicio'],
            'autor' => ['required', 'string', 'max:120'],
            'fase_actual' => ['required', 'string', 'max:120'],
            'porcentaje_avance' => ['required', 'integer', 'between:0,100'],
            'estado_general' => ['required', Rule::in(array_keys(Reporte::ESTADOS))],
            'resumen' => ['required', 'string', 'max:2000'],
            'proximos_pasos' => ['nullable', 'string', 'max:2000'],

            // Progreso: las filas vacías se ignoran en el controlador.
            'avances' => ['nullable', 'array', 'max:10'],
            'avances.*.actividad' => ['nullable', 'string', 'max:200'],
            'avances.*.detalle' => ['nullable', 'string', 'max:1000'],
            'avances.*.entregable' => ['nullable', 'string', 'max:200'],
            'avances.*.estado' => ['nullable', Rule::in(array_keys(Avance::ESTADOS))],

            // Problemas y soluciones: cada problema debe llevar su solución.
            'problemas' => ['nullable', 'array', 'max:10'],
            'problemas.*.descripcion' => ['nullable', 'string', 'max:1000'],
            'problemas.*.impacto' => ['required_with:problemas.*.descripcion', 'nullable', Rule::in(array_keys(Problema::IMPACTOS))],
            'problemas.*.estado' => ['required_with:problemas.*.descripcion', 'nullable', Rule::in(array_keys(Problema::ESTADOS))],
            'problemas.*.solucion_propuesta' => ['required_with:problemas.*.descripcion', 'nullable', 'string', 'max:1000'],
            'problemas.*.solucion_implementada' => ['required_if:problemas.*.estado,resuelto', 'nullable', 'string', 'max:1000'],
            'problemas.*.responsable' => ['nullable', 'string', 'max:120'],
            'problemas.*.fecha_compromiso' => ['nullable', 'date'],

            // Riesgos (opcional): cada riesgo debe llevar su medida preventiva.
            'riesgos' => ['nullable', 'array', 'max:10'],
            'riesgos.*.descripcion' => ['nullable', 'string', 'max:1000'],
            'riesgos.*.probabilidad' => ['required_with:riesgos.*.descripcion', 'nullable', Rule::in(array_keys(Riesgo::PROBABILIDADES))],
            'riesgos.*.impacto' => ['required_with:riesgos.*.descripcion', 'nullable', Rule::in(array_keys(Riesgo::IMPACTOS))],
            'riesgos.*.mitigacion' => ['required_with:riesgos.*.descripcion', 'nullable', 'string', 'max:1000'],
            'riesgos.*.responsable' => ['nullable', 'string', 'max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'periodo_fin.after_or_equal' => 'La fecha final del periodo no puede ser anterior a la inicial.',
            'problemas.*.solucion_propuesta.required_with' => 'Cada problema debe incluir una solución propuesta.',
            'problemas.*.impacto.required_with' => 'Indica el impacto de cada problema.',
            'problemas.*.solucion_implementada.required_if' => 'Un problema resuelto debe indicar la solución implementada.',
            'riesgos.*.mitigacion.required_with' => 'Cada riesgo debe incluir una medida preventiva.',
        ];
    }
}
