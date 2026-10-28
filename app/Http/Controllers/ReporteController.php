<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReporteRequest;
use App\Models\Reporte;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        $reportes = Reporte::query()
            ->withCount([
                'avances',
                'problemas as problemas_abiertos_count' => fn ($consulta) => $consulta->where('estado', '!=', 'resuelto'),
            ])
            ->orderByDesc('periodo_fin')
            ->paginate(10);

        return view('reportes.index', compact('reportes'));
    }

    public function create()
    {
        return view('reportes.create');
    }

    public function store(StoreReporteRequest $request)
    {
        $datos = $request->validated();

        // Se descartan las filas que el usuario dejó vacías en el formulario.
        $avances = collect($datos['avances'] ?? [])
            ->filter(fn ($fila) => filled($fila['actividad'] ?? null))
            ->values()
            ->all();

        $problemas = collect($datos['problemas'] ?? [])
            ->filter(fn ($fila) => filled($fila['descripcion'] ?? null))
            ->values()
            ->all();

        $riesgos = collect($datos['riesgos'] ?? [])
            ->filter(fn ($fila) => filled($fila['descripcion'] ?? null))
            ->values()
            ->all();

        $reporte = DB::transaction(function () use ($datos, $avances, $problemas, $riesgos) {
            $reporte = Reporte::create(Arr::except($datos, ['avances', 'problemas', 'riesgos']));
            $reporte->avances()->createMany($avances);
            $reporte->problemas()->createMany($problemas);
            $reporte->riesgos()->createMany($riesgos);

            return $reporte;
        });

        return redirect()
            ->route('reportes.show', $reporte)
            ->with('ok', 'El informe se guardó correctamente.');
    }

    public function show(Reporte $reporte)
    {
        $reporte->load(['avances', 'problemas', 'riesgos']);

        return view('reportes.show', compact('reporte'));
    }
}
