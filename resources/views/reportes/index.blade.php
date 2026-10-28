@extends('layouts.app')

@section('titulo', 'Informes de seguimiento')

@section('contenido')
    <div class="barra">
        <h1>Informes de seguimiento</h1>
        <a class="boton" href="{{ route('reportes.create') }}">Nuevo informe</a>
    </div>

    @if ($reportes->isEmpty())
        <p>Todavía no hay informes. Crea el primero con el botón "Nuevo informe".</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Periodo</th>
                    <th>Proyecto</th>
                    <th>Fase</th>
                    <th>Avance</th>
                    <th>Estado</th>
                    <th>Problemas abiertos</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reportes as $reporte)
                    <tr>
                        <td>{{ $reporte->periodo_inicio->format('d/m/Y') }} al {{ $reporte->periodo_fin->format('d/m/Y') }}</td>
                        <td>{{ $reporte->proyecto }}</td>
                        <td>{{ $reporte->fase_actual }}</td>
                        <td>{{ $reporte->porcentaje_avance }} %</td>
                        <td><span class="semaforo {{ $reporte->estado_general }}">{{ ucfirst($reporte->estado_general) }}</span></td>
                        <td>{{ $reporte->problemas_abiertos_count }}</td>
                        <td><a href="{{ route('reportes.show', $reporte) }}">Ver</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 12px;">{{ $reportes->links() }}</div>
    @endif
@endsection
