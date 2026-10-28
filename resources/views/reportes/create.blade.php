@extends('layouts.app')

@section('titulo', 'Nuevo informe')

@section('contenido')
    <h1>Nuevo informe de seguimiento</h1>

    @if ($errors->any())
        <div class="errores">
            <strong>Revisa lo siguiente:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('reportes.store') }}">
        @csrf

        <div class="tarjeta">
            <h2>1. Datos generales</h2>
            <label for="proyecto">Proyecto</label>
            <input id="proyecto" name="proyecto" value="{{ old('proyecto', 'Food Waste Analytics') }}">

            <div class="fila">
                <div>
                    <label for="periodo_inicio">Inicio del periodo</label>
                    <input id="periodo_inicio" type="date" name="periodo_inicio" value="{{ old('periodo_inicio') }}">
                </div>
                <div>
                    <label for="periodo_fin">Fin del periodo</label>
                    <input id="periodo_fin" type="date" name="periodo_fin" value="{{ old('periodo_fin') }}">
                </div>
                <div>
                    <label for="autor">Autor del informe</label>
                    <input id="autor" name="autor" value="{{ old('autor') }}">
                </div>
                <div>
                    <label for="fase_actual">Fase actual</label>
                    <input id="fase_actual" name="fase_actual" placeholder="Ej. Diseño (semana 4)" value="{{ old('fase_actual') }}">
                </div>
                <div>
                    <label for="porcentaje_avance">Avance general (%)</label>
                    <input id="porcentaje_avance" type="number" min="0" max="100" name="porcentaje_avance" value="{{ old('porcentaje_avance', 0) }}">
                </div>
                <div>
                    <label for="estado_general">Estado general</label>
                    <select id="estado_general" name="estado_general">
                        @foreach (\App\Models\Reporte::ESTADOS as $valor => $etiqueta)
                            <option value="{{ $valor }}" @selected(old('estado_general', 'verde') === $valor)>{{ $etiqueta }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <label for="resumen">Resumen del periodo</label>
            <textarea id="resumen" name="resumen" rows="3">{{ old('resumen') }}</textarea>
        </div>

        <div class="tarjeta">
            <h2>2. Progreso</h2>
            <p class="ayuda">Anota lo que se hizo en el periodo. Las filas vacías se ignoran.</p>
            @foreach (range(0, 2) as $i)
                <div class="fila">
                    <div>
                        <label>Actividad</label>
                        <input name="avances[{{ $i }}][actividad]" value="{{ old("avances.$i.actividad") }}">
                    </div>
                    <div>
                        <label>Entregable</label>
                        <input name="avances[{{ $i }}][entregable]" value="{{ old("avances.$i.entregable") }}">
                    </div>
                    <div>
                        <label>Detalle</label>
                        <input name="avances[{{ $i }}][detalle]" value="{{ old("avances.$i.detalle") }}">
                    </div>
                    <div>
                        <label>Estado</label>
                        <select name="avances[{{ $i }}][estado]">
                            @foreach (\App\Models\Avance::ESTADOS as $valor => $etiqueta)
                                <option value="{{ $valor }}" @selected(old("avances.$i.estado", 'completado') === $valor)>{{ $etiqueta }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="tarjeta">
            <h2>3. Problemas y soluciones</h2>
            <p class="ayuda">Cada problema debe llevar una solución propuesta. Las filas vacías se ignoran.</p>
            @foreach (range(0, 2) as $i)
                <div class="fila">
                    <div style="grid-column: 1 / -1;">
                        <label>Problema</label>
                        <textarea name="problemas[{{ $i }}][descripcion]" rows="2">{{ old("problemas.$i.descripcion") }}</textarea>
                    </div>
                    <div>
                        <label>Impacto</label>
                        <select name="problemas[{{ $i }}][impacto]">
                            @foreach (\App\Models\Problema::IMPACTOS as $valor => $etiqueta)
                                <option value="{{ $valor }}" @selected(old("problemas.$i.impacto", 'medio') === $valor)>{{ $etiqueta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Estado del problema</label>
                        <select name="problemas[{{ $i }}][estado]">
                            @foreach (\App\Models\Problema::ESTADOS as $valor => $etiqueta)
                                <option value="{{ $valor }}" @selected(old("problemas.$i.estado", 'abierto') === $valor)>{{ $etiqueta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <label>Solución propuesta</label>
                        <textarea name="problemas[{{ $i }}][solucion_propuesta]" rows="2">{{ old("problemas.$i.solucion_propuesta") }}</textarea>
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <label>Solución implementada o resultado (si ya se aplicó)</label>
                        <textarea name="problemas[{{ $i }}][solucion_implementada]" rows="2">{{ old("problemas.$i.solucion_implementada") }}</textarea>
                    </div>
                    <div>
                        <label>Responsable</label>
                        <input name="problemas[{{ $i }}][responsable]" value="{{ old("problemas.$i.responsable") }}">
                    </div>
                    <div>
                        <label>Fecha compromiso</label>
                        <input type="date" name="problemas[{{ $i }}][fecha_compromiso]" value="{{ old("problemas.$i.fecha_compromiso") }}">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="tarjeta">
            <h2>4. Riesgos (opcional)</h2>
            <p class="ayuda">Lo que podría salir mal más adelante. Cada riesgo debe llevar una medida preventiva. Las filas vacías se ignoran.</p>
            @foreach (range(0, 1) as $i)
                <div class="fila">
                    <div style="grid-column: 1 / -1;">
                        <label>Riesgo</label>
                        <textarea name="riesgos[{{ $i }}][descripcion]" rows="2">{{ old("riesgos.$i.descripcion") }}</textarea>
                    </div>
                    <div>
                        <label>Probabilidad</label>
                        <select name="riesgos[{{ $i }}][probabilidad]">
                            @foreach (\App\Models\Riesgo::PROBABILIDADES as $valor => $etiqueta)
                                <option value="{{ $valor }}" @selected(old("riesgos.$i.probabilidad", 'media') === $valor)>{{ $etiqueta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Impacto</label>
                        <select name="riesgos[{{ $i }}][impacto]">
                            @foreach (\App\Models\Riesgo::IMPACTOS as $valor => $etiqueta)
                                <option value="{{ $valor }}" @selected(old("riesgos.$i.impacto", 'medio') === $valor)>{{ $etiqueta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <label>Medida preventiva</label>
                        <textarea name="riesgos[{{ $i }}][mitigacion]" rows="2">{{ old("riesgos.$i.mitigacion") }}</textarea>
                    </div>
                    <div>
                        <label>Responsable</label>
                        <input name="riesgos[{{ $i }}][responsable]" value="{{ old("riesgos.$i.responsable") }}">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="tarjeta">
            <h2>5. Próximos pasos</h2>
            <textarea name="proximos_pasos" rows="3" placeholder="Acciones concretas para el siguiente periodo, con responsable">{{ old('proximos_pasos') }}</textarea>
        </div>

        <button class="boton" type="submit">Guardar informe</button>
        <a href="{{ route('reportes.index') }}" style="margin-left: 10px;">Cancelar</a>
    </form>
@endsection
