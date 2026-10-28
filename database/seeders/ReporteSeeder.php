<?php

namespace Database\Seeders;

use App\Models\Reporte;
use Illuminate\Database\Seeder;

/**
 * Datos de EJEMPLO (ficticios) para el proyecto Food Waste Analytics.
 * Sirven para probar el formato del informe, no son datos reales.
 */
class ReporteSeeder extends Seeder
{
    public function run(): void
    {
        // Informe completo: fase de diseño, con riesgos y un problema abierto.
        $informe4 = Reporte::create([
            'proyecto' => 'Food Waste Analytics',
            'periodo_inicio' => '2026-11-23',
            'periodo_fin' => '2026-11-27',
            'autor' => 'Líder de proyecto',
            'fase_actual' => 'Diseño (semana 4)',
            'porcentaje_avance' => 28,
            'estado_general' => 'amarillo',
            'resumen' => 'El diseño de la base de datos y de la API avanza según lo planeado, pero falta confirmar qué datos de pedidos se pueden usar.',
            'proximos_pasos' => 'Cerrar el modelo de datos (analista y backend). Terminar los prototipos de pantallas (analista). Probar el entorno con Docker Compose (infraestructura).',
        ]);

        $informe4->avances()->createMany([
            [
                'actividad' => 'Modelo de datos de mermas',
                'detalle' => 'Primera versión de las tablas de mermas, productos y motivos.',
                'entregable' => 'Diagrama de base de datos (borrador)',
                'estado' => 'completado',
            ],
            [
                'actividad' => 'Prototipos de pantallas',
                'detalle' => 'Formulario de registro de mermas y panel de reportes.',
                'entregable' => 'Prototipos en revisión',
                'estado' => 'en_progreso',
            ],
            [
                'actividad' => 'Entorno con Docker Compose',
                'detalle' => 'Contenedores de la aplicación, la base de datos y el servidor web.',
                'entregable' => 'Archivo docker-compose.yml',
                'estado' => 'en_progreso',
            ],
        ]);

        $informe4->problemas()->createMany([
            [
                'descripcion' => 'No está claro qué datos del sistema de pedidos se pueden compartir con el módulo.',
                'impacto' => 'alto',
                'estado' => 'abierto',
                'solucion_propuesta' => 'Hacer una reunión con el restaurante piloto y definir una lista corta de datos necesarios; probar con datos de ejemplo mientras tanto.',
                'solucion_implementada' => null,
                'responsable' => 'Líder de proyecto',
                'fecha_compromiso' => '2026-12-02',
            ],
            [
                'descripcion' => 'Los prototipos del formulario de registro tardan en validarse con el restaurante.',
                'impacto' => 'medio',
                'estado' => 'en_proceso',
                'solucion_propuesta' => 'Enviar los prototipos con tres preguntas concretas y pedir respuesta en dos días.',
                'solucion_implementada' => 'Se enviaron los prototipos con las tres preguntas; falta la respuesta del restaurante.',
                'responsable' => 'Analista y diseñador',
                'fecha_compromiso' => '2026-11-30',
            ],
        ]);

        $informe4->riesgos()->createMany([
            [
                'descripcion' => 'El restaurante piloto podría no tener tiempo para validar los prototipos a tiempo.',
                'probabilidad' => 'media',
                'impacto' => 'medio',
                'mitigacion' => 'Hacer revisiones cortas de 15 minutos cada semana y enviar preguntas concretas por escrito.',
                'responsable' => 'Líder de proyecto',
            ],
            [
                'descripcion' => 'Un cambio en la operación del restaurante podría modificar los indicadores que se van a medir.',
                'probabilidad' => 'baja',
                'impacto' => 'alto',
                'mitigacion' => 'Mantener el modelo de datos flexible y revisar los indicadores al terminar cada ciclo de desarrollo.',
                'responsable' => 'Analista y diseñador',
            ],
        ]);

        // Informe de desarrollo: problema con solución en proceso.
        $informe7 = Reporte::create([
            'proyecto' => 'Food Waste Analytics',
            'periodo_inicio' => '2026-12-14',
            'periodo_fin' => '2026-12-18',
            'autor' => 'Líder de proyecto',
            'fase_actual' => 'Desarrollo, ciclo 1 (semana 7)',
            'porcentaje_avance' => 41,
            'estado_general' => 'verde',
            'resumen' => 'El registro de mermas ya funciona en el entorno de pruebas y se revisó con el restaurante piloto.',
            'proximos_pasos' => 'Empezar el cálculo de indicadores (backend). Ajustar el formulario con los comentarios del restaurante (interfaz).',
        ]);

        $informe7->avances()->createMany([
            [
                'actividad' => 'Registro de mermas',
                'detalle' => 'Formulario, validaciones y guardado en la base de datos.',
                'entregable' => 'Módulo de registro funcionando en pruebas',
                'estado' => 'completado',
            ],
            [
                'actividad' => 'Pruebas automáticas del registro',
                'detalle' => 'Pruebas de las rutas y de las validaciones principales.',
                'entregable' => 'Pruebas en el repositorio',
                'estado' => 'completado',
            ],
        ]);

        $informe7->problemas()->create([
            'descripcion' => 'El personal del restaurante tardó más de un minuto en registrar una merma durante la prueba.',
            'impacto' => 'medio',
            'estado' => 'en_proceso',
            'solucion_propuesta' => 'Reducir los campos obligatorios y dejar el motivo como lista de opciones.',
            'solucion_implementada' => 'Se redujeron los campos obligatorios de seis a cuatro; falta probar el formulario nuevo.',
            'responsable' => 'Desarrollador de interfaz',
            'fecha_compromiso' => '2026-12-22',
        ]);

        // Informe corto de otro escenario: fase de pruebas, con un problema ya resuelto.
        $informe13 = Reporte::create([
            'proyecto' => 'Food Waste Analytics',
            'periodo_inicio' => '2027-01-25',
            'periodo_fin' => '2027-01-29',
            'autor' => 'Responsable de calidad',
            'fase_actual' => 'Pruebas (semana 13)',
            'porcentaje_avance' => 82,
            'estado_general' => 'verde',
            'resumen' => 'Las pruebas de integración de la API pasaron en el entorno de pruebas después de corregir un problema de configuración.',
            'proximos_pasos' => 'Hacer las pruebas con usuarios en el restaurante piloto (calidad y líder de proyecto).',
        ]);

        $informe13->avances()->create([
            'actividad' => 'Pruebas de integración de la API',
            'detalle' => 'Casos de registro de mermas y de cálculo de indicadores.',
            'entregable' => 'Informe de pruebas',
            'estado' => 'completado',
        ]);

        $informe13->problemas()->create([
            'descripcion' => 'Las pruebas de la API fallaban en el entorno de pruebas por una versión distinta de PHP.',
            'impacto' => 'medio',
            'estado' => 'resuelto',
            'solucion_propuesta' => 'Fijar la versión de PHP en la imagen de Docker.',
            'solucion_implementada' => 'Se fijó la versión de PHP en el Dockerfile y se reconstruyeron los contenedores; las pruebas volvieron a pasar.',
            'responsable' => 'Apoyo en infraestructura',
            'fecha_compromiso' => '2027-01-27',
        ]);
    }
}
