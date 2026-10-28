@extends('layouts.app')

@section('titulo', 'Informe de seguimiento')

@section('contenido')
    <div class="barra">
        <h1>{{ $reporte->proyecto }}: informe del {{ $reporte->periodo_inicio->format('d/m/Y') }} al {{ $reporte->periodo_fin->format('d/m/Y') }}</h1>
        <a href="{{ route('reportes.index') }}">Volver al listado</a>
    </div>

    <div class="tarjeta">
        <h2>Datos generales</h2>
        <p><strong>Autor:</strong> {{ $reporte->autor }}</p>
        <p><strong>Fase actual:</strong> {{ $reporte->fase_actual }}</p>
        <p><strong>Avance general:</strong> {{ $reporte->porcentaje_avance }} %</p>
        <p><strong>Estado general:</strong> <span class="semaforo {{ $reporte->estado_general }}">{{ ucfirst($reporte->estado_general) }}</span></p>
        <p><strong>Resumen:</strong> {{ $reporte->resumen }}</p>
    </div>

    <div class="tarjeta">
        <h2>Progreso</h2>
        @forelse ($reporte->avances as $avance)
            @if ($loop->first)
                <table>
                    <thead>
                        <tr><th>Actividad</th><th>Detalle</th><th>Entregable</th><th>Estado</th></tr>
                    </thead>
                    <tbody>
            @endif
                        <tr>
                            <td>{{ $avance->actividad }}</td>
                            <td>{{ $avance->detalle }}</td>
                            <td>{{ $avance->entregable }}</td>
                            <td>{{ \App\Models\Avance::ESTADOS[$avance->estado] ?? $avance->estado }}</td>
                        </tr>
            @if ($loop->last)
                    </tbody>
                </table>
            @endif
        @empty
            <p>No se registraron actividades en este informe.</p>
        @endforelse
    </div>

    <div class="tarjeta">
        <h2>Problemas y soluciones</h2>
        @forelse ($reporte->problemas as $problema)
            @if ($loop->first)
                <table>
                    <thead>
                        <tr><th>Problema</th><th>Impacto</th><th>Estado</th><th>Solución propuesta</th><th>Solución implementada</th><th>Responsable</th><th>Fecha compromiso</th></tr>
                    </thead>
                    <tbody>
            @endif
                        <tr>
                            <td>{{ $problema->descripcion }}</td>
                            <td>{{ \App\Models\Problema::IMPACTOS[$problema->impacto] ?? $problema->impacto }}</td>
                            <td>{{ \App\Models\Problema::ESTADOS[$problema->estado] ?? $problema->estado }}</td>
                            <td>{{ $problema->solucion_propuesta }}</td>
                            <td>{{ $problema->solucion_implementada }}</td>
                            <td>{{ $problema->responsable }}</td>
                            <td>{{ optional($problema->fecha_compromiso)->format('d/m/Y') }}</td>
                        </tr>
            @if ($loop->last)
                    </tbody>
                </table>
            @endif
        @empty
            <p>No se reportaron problemas en este periodo.</p>
        @endforelse
    </div>

    <div class="tarjeta">
        <h2>Riesgos</h2>
        @forelse ($reporte->riesgos as $riesgo)
            @if ($loop->first)
                <table>
                    <thead>
                        <tr><th>Riesgo</th><th>Probabilidad</th><th>Impacto</th><th>Medida preventiva</th><th>Responsable</th></tr>
                    </thead>
                    <tbody>
            @endif
                        <tr>
                            <td>{{ $riesgo->descripcion }}</td>
                            <td>{{ \App\Models\Riesgo::PROBABILIDADES[$riesgo->probabilidad] ?? $riesgo->probabilidad }}</td>
                            <td>{{ \App\Models\Riesgo::IMPACTOS[$riesgo->impacto] ?? $riesgo->impacto }}</td>
                            <td>{{ $riesgo->mitigacion }}</td>
                            <td>{{ $riesgo->responsable }}</td>
                        </tr>
            @if ($loop->last)
                    </tbody>
                </table>
            @endif
        @empty
            <p>No se registraron riesgos en este informe.</p>
        @endforelse
    </div>

    <div class="tarjeta">
        <h2>Próximos pasos</h2>
        <p>{{ $reporte->proximos_pasos ?: 'Sin próximos pasos registrados.' }}</p>
    </div>
@endsection
