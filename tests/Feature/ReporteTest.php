<?php

namespace Tests\Feature;

use App\Models\Reporte;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReporteTest extends TestCase
{
    use RefreshDatabase;

    private function datosValidos(array $extra = []): array
    {
        return array_merge([
            'proyecto' => 'Food Waste Analytics',
            'periodo_inicio' => '2026-11-23',
            'periodo_fin' => '2026-11-27',
            'autor' => 'Líder de proyecto',
            'fase_actual' => 'Diseño (semana 4)',
            'porcentaje_avance' => 28,
            'estado_general' => 'amarillo',
            'resumen' => 'El diseño avanza según lo planeado.',
            'proximos_pasos' => 'Cerrar el modelo de datos.',
        ], $extra);
    }

    public function test_el_listado_se_muestra_vacio(): void
    {
        $this->get('/reportes')
            ->assertOk()
            ->assertSee('Todavía no hay informes');
    }

    public function test_el_formulario_tiene_todas_las_secciones(): void
    {
        $this->get('/reportes/create')
            ->assertOk()
            ->assertSee('Progreso')
            ->assertSee('Problemas y soluciones')
            ->assertSee('Riesgos')
            ->assertSee('Próximos pasos');
    }

    public function test_guarda_un_informe_e_ignora_las_filas_vacias(): void
    {
        $respuesta = $this->post('/reportes', $this->datosValidos([
            'avances' => [
                ['actividad' => 'Modelo de datos de mermas', 'detalle' => 'Primera versión', 'entregable' => 'Diagrama', 'estado' => 'completado'],
                ['actividad' => '', 'detalle' => '', 'entregable' => '', 'estado' => 'completado'],
            ],
            'problemas' => [
                [
                    'descripcion' => 'Faltan definir los datos de pedidos',
                    'impacto' => 'alto',
                    'estado' => 'abierto',
                    'solucion_propuesta' => 'Reunión con el restaurante piloto',
                    'solucion_implementada' => '',
                    'responsable' => 'Líder de proyecto',
                    'fecha_compromiso' => '2026-12-02',
                ],
                ['descripcion' => '', 'impacto' => 'medio', 'estado' => 'abierto', 'solucion_propuesta' => '', 'solucion_implementada' => '', 'responsable' => '', 'fecha_compromiso' => ''],
            ],
        ]));

        $reporte = Reporte::first();

        $respuesta->assertRedirect(route('reportes.show', $reporte));
        $this->assertDatabaseCount('reportes', 1);
        $this->assertDatabaseCount('avances', 1);
        $this->assertDatabaseCount('problemas', 1);
    }

    public function test_un_problema_sin_solucion_no_se_guarda(): void
    {
        $this->post('/reportes', $this->datosValidos([
            'problemas' => [
                ['descripcion' => 'Un problema sin solución', 'impacto' => 'medio', 'estado' => 'abierto', 'solucion_propuesta' => ''],
            ],
        ]))->assertSessionHasErrors('problemas.0.solucion_propuesta');

        $this->assertDatabaseCount('reportes', 0);
    }

    public function test_un_problema_resuelto_debe_indicar_la_solucion_implementada(): void
    {
        $this->post('/reportes', $this->datosValidos([
            'problemas' => [
                [
                    'descripcion' => 'Las pruebas fallaban por la versión de PHP',
                    'impacto' => 'medio',
                    'estado' => 'resuelto',
                    'solucion_propuesta' => 'Fijar la versión de PHP en Docker',
                    'solucion_implementada' => '',
                ],
            ],
        ]))->assertSessionHasErrors('problemas.0.solucion_implementada');

        $this->assertDatabaseCount('reportes', 0);
    }

    public function test_guarda_un_riesgo_con_su_medida_preventiva(): void
    {
        $this->post('/reportes', $this->datosValidos([
            'riesgos' => [
                [
                    'descripcion' => 'El restaurante podría no tener tiempo para validar',
                    'probabilidad' => 'media',
                    'impacto' => 'medio',
                    'mitigacion' => 'Revisiones cortas de 15 minutos',
                    'responsable' => 'Líder de proyecto',
                ],
                ['descripcion' => '', 'probabilidad' => 'media', 'impacto' => 'medio', 'mitigacion' => '', 'responsable' => ''],
            ],
        ]))->assertRedirect();

        $this->assertDatabaseCount('riesgos', 1);
    }

    public function test_un_riesgo_sin_medida_preventiva_no_se_guarda(): void
    {
        $this->post('/reportes', $this->datosValidos([
            'riesgos' => [
                ['descripcion' => 'Un riesgo sin medida', 'probabilidad' => 'alta', 'impacto' => 'alto', 'mitigacion' => ''],
            ],
        ]))->assertSessionHasErrors('riesgos.0.mitigacion');

        $this->assertDatabaseCount('reportes', 0);
    }

    public function test_el_fin_del_periodo_no_puede_ser_anterior_al_inicio(): void
    {
        $this->post('/reportes', $this->datosValidos([
            'periodo_inicio' => '2026-11-27',
            'periodo_fin' => '2026-11-23',
        ]))->assertSessionHasErrors('periodo_fin');
    }

    public function test_el_informe_muestra_el_progreso_las_soluciones_y_los_riesgos(): void
    {
        $reporte = Reporte::create($this->datosValidos());
        $reporte->avances()->create(['actividad' => 'Prototipos de pantallas', 'estado' => 'en_progreso']);
        $reporte->problemas()->create([
            'descripcion' => 'Los prototipos tardan en validarse',
            'impacto' => 'medio',
            'estado' => 'resuelto',
            'solucion_propuesta' => 'Enviar tres preguntas concretas',
            'solucion_implementada' => 'Se enviaron las preguntas y se recibió respuesta',
        ]);
        $reporte->riesgos()->create([
            'descripcion' => 'Cambios en la operación del restaurante',
            'probabilidad' => 'baja',
            'impacto' => 'alto',
            'mitigacion' => 'Revisar los indicadores en cada ciclo',
        ]);

        $this->get(route('reportes.show', $reporte))
            ->assertOk()
            ->assertSee('Prototipos de pantallas')
            ->assertSee('Enviar tres preguntas concretas')
            ->assertSee('Se enviaron las preguntas y se recibió respuesta')
            ->assertSee('Revisar los indicadores en cada ciclo');
    }
}
