# NouriTech FoodTech · Informes de seguimiento (Food Waste Analytics)

Aplicación pequeña en **Laravel** para crear y consultar informes de seguimiento de proyectos de software de NouriTech FoodTech, con el proyecto **Food Waste Analytics** como caso de ejemplo. Todos los informes tienen el mismo formato, con secciones para **progreso**, **problemas**, **soluciones** y **riesgos**, pensado para que lo usen los equipos internos.

> Proyecto académico. Los datos del seeder son **de ejemplo** (ficticios) y sirven solo para probar el formato.

## ¿Qué incluye un informe?

| Sección | Qué se registra |
|---|---|
| 1. Datos generales | Proyecto, periodo, autor, fase actual, avance general (%), estado general (semáforo) y resumen |
| 2. Progreso | Actividades del periodo con su detalle, entregable y estado (completado o en progreso) |
| 3. Problemas y soluciones | Cada problema con su impacto, estado, **solución propuesta**, **solución implementada o resultado**, responsable y fecha compromiso |
| 4. Riesgos (opcional) | Lo que podría salir mal, con su probabilidad, impacto, **medida preventiva** y responsable |
| 5. Próximos pasos | Acciones concretas para el siguiente periodo |

Reglas del formato:

- **Cada problema debe llevar una solución propuesta.** Si falta, el sistema no guarda el informe.
- **Un problema marcado como resuelto debe indicar la solución implementada.**
- **Cada riesgo debe llevar una medida preventiva.**
- Los riesgos (lo que podría pasar) se separan de los problemas (lo que ya pasó).
- Las filas vacías del formulario se ignoran.
- El estado general usa un semáforo:
  - **Verde:** avanza según lo planeado y no hay problemas de impacto alto abiertos.
  - **Amarillo:** hay riesgos o retrasos menores.
  - **Rojo:** hay un problema que afecta un hito.

## Adaptación a otros proyectos y escenarios

El formato no está atado a un solo proyecto:

- El campo **Proyecto** y el campo **Fase actual** son de texto libre, así que sirven para cualquier proyecto de la empresa y cualquier fase (análisis, diseño, desarrollo, pruebas, implementación, cierre o mantenimiento).
- Solo son obligatorios los datos generales. **Progreso, problemas y riesgos son opcionales**, de modo que un equipo pequeño puede usar una **versión corta**: datos generales, un resumen, una o dos actividades y los próximos pasos.
- Para un incidente o una fase de pruebas se usa la sección de problemas, con la solución implementada y su resultado. En el seeder hay un informe corto de ese tipo (semana 13).
- Los textos y las listas de valores (impacto, probabilidad, estado) se pueden cambiar en los modelos `Reporte`, `Problema`, `Riesgo` y `Avance`.

## Requisitos

- PHP 8.2 o superior
- Composer
- Laravel 11 o superior
- Una base de datos compatible con Laravel (SQLite, MySQL o PostgreSQL)

## Instalación

Este repositorio contiene **solo los archivos del módulo**, no el proyecto Laravel completo. Para usarlo:

1. Crea un proyecto Laravel (o usa uno existente):

   ```bash
   composer create-project laravel/laravel nouritech-informes
   cd nouritech-informes
   ```

2. Copia las carpetas `app`, `database`, `resources`, `routes` y `tests` de este repositorio dentro de tu proyecto, y conserva la carpeta `.github` si quieres la plantilla de pull request.

3. Al final de `routes/web.php` agrega:

   ```php
   require __DIR__.'/reportes.php';
   ```

4. Configura la base de datos en `.env` y ejecuta las migraciones:

   ```bash
   php artisan migrate
   ```

5. (Opcional) Carga los informes de ejemplo:

   ```bash
   php artisan db:seed --class=ReporteSeeder
   ```

6. Inicia el servidor:

   ```bash
   php artisan serve
   ```

   Abre <http://localhost:8000/reportes>.

> Si ya habías migrado una versión anterior de este módulo, solo ejecuta `php artisan migrate`: las tablas nuevas y la columna `solucion_implementada` se agregan con migraciones aparte.

## Uso

1. Entra a `/reportes` para ver el listado de informes.
2. Haz clic en **Nuevo informe** y llena las secciones.
3. Guarda el informe. Se muestra la página del informe con todas sus secciones.

Cómo se llena cada sección:

- **Resumen:** dos o tres frases sobre cómo fue el periodo.
- **Progreso:** una fila por actividad, con un entregable concreto cuando exista.
- **Problemas y soluciones:** un problema por fila, con su impacto, la solución propuesta, lo que ya se implementó (si aplica) y quién se encarga.
- **Riesgos:** lo que podría pasar más adelante, con una medida para evitarlo.
- **Próximos pasos:** acciones concretas, no intenciones generales.

Se recomienda un informe **semanal**, que se revisa en la reunión corta del equipo.

## Estructura del proyecto

```
app/
  Http/Controllers/ReporteController.php   # listado, formulario, guardado y detalle
  Http/Requests/StoreReporteRequest.php    # validaciones del informe
  Models/Reporte.php                       # informe (tiene muchos avances, problemas y riesgos)
  Models/Avance.php                        # actividad del periodo
  Models/Problema.php                      # problema con su solución
  Models/Riesgo.php                        # riesgo con su medida preventiva
database/
  migrations/                              # tablas reportes, avances, problemas y riesgos
  seeders/ReporteSeeder.php                # informes de ejemplo
resources/views/
  layouts/app.blade.php                    # diseño base
  reportes/                                # index, create y show
routes/reportes.php                        # rutas del módulo
tests/Feature/ReporteTest.php              # pruebas del módulo
```

## Pruebas

```bash
php artisan test
```

Las pruebas revisan que el formulario tenga todas las secciones, que el informe se guarde, que se ignoren las filas vacías, que un problema sin solución o un problema resuelto sin solución implementada no se guarden, que un riesgo sin medida preventiva no se guarde, que las fechas sean coherentes y que el detalle muestre el progreso, las soluciones y los riesgos.

## Flujo de trabajo en GitHub

- La rama `main` siempre debe tener una versión que funcione.
- Cada cambio se hace en una rama nueva (por ejemplo `feature/exportar-pdf`) y se integra con un **pull request**.
- El pull request usa la plantilla de `.github/PULL_REQUEST_TEMPLATE.md` y debe tener las pruebas pasando.
- Los errores y mejoras se registran como **issues**.
- Mensajes de commit cortos y en presente (ejemplo: `Agrega validación de solución obligatoria`).

## Limitaciones conocidas

- No tiene inicio de sesión ni permisos.
- No se pueden editar ni borrar informes desde la interfaz.
- El formulario permite hasta 3 actividades, 3 problemas y 2 riesgos por informe (la validación acepta hasta 10 de cada uno).
- No exporta a PDF.

## Responsables

- Autor: _[nombre del estudiante]_
- Contexto: actividad de Gestión de Proyectos (NouriTech FoodTech, Food Waste Analytics)
