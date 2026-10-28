# NouriTech · Informes de seguimiento (Food Waste Analytics)

Aplicación pequeña en **Laravel** para crear y consultar informes de seguimiento del proyecto **Food Waste Analytics**. Todos los informes tienen el mismo formato, con tres secciones principales: **progreso**, **problemas** y **soluciones**.

> Proyecto académico. Los datos del seeder son **de ejemplo** (ficticios) y sirven solo para probar el formato.

## ¿Qué incluye un informe?

| Sección | Qué se registra |
|---|---|
| Datos generales | Proyecto, periodo, autor, fase actual, avance general (%), estado general (semáforo) y resumen |
| Progreso | Actividades del periodo con su detalle, entregable y estado (completado o en progreso) |
| Problemas y soluciones | Cada problema con su impacto, estado, **solución propuesta**, responsable y fecha compromiso |
| Próximos pasos | Acciones concretas para el siguiente periodo |

Reglas del formato:

- **Cada problema debe llevar una solución propuesta.** Si falta, el sistema no guarda el informe.
- Las filas vacías del formulario se ignoran.
- El estado general usa un semáforo:
  - **Verde:** avanza según lo planeado y no hay problemas de impacto alto abiertos.
  - **Amarillo:** hay riesgos o retrasos menores.
  - **Rojo:** hay un problema que afecta un hito.

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

## Uso

1. Entra a `/reportes` para ver el listado de informes.
2. Haz clic en **Nuevo informe** y llena las cuatro secciones.
3. Guarda el informe. Se muestra la página del informe con todas sus secciones.

Cómo se llena cada sección:

- **Resumen:** dos o tres frases sobre cómo fue el periodo.
- **Progreso:** una fila por actividad, con un entregable concreto cuando exista.
- **Problemas y soluciones:** un problema por fila, con su impacto, la solución propuesta y quién se encarga.
- **Próximos pasos:** acciones concretas, no intenciones generales.

Se recomienda un informe **semanal**, que se revisa en la reunión corta con el administrador del restaurante piloto.

## Estructura del proyecto

```
app/
  Http/Controllers/ReporteController.php   # listado, formulario, guardado y detalle
  Http/Requests/StoreReporteRequest.php    # validaciones del informe
  Models/Reporte.php                       # informe (tiene muchos avances y problemas)
  Models/Avance.php                        # actividad del periodo
  Models/Problema.php                      # problema con su solución
database/
  migrations/                              # tablas reportes, avances y problemas
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

Las pruebas revisan que el formulario tenga las tres secciones, que el informe se guarde, que se ignoren las filas vacías, que un problema sin solución no se guarde y que las fechas sean coherentes.

## Flujo de trabajo en GitHub

- La rama `main` siempre debe tener una versión que funcione.
- Cada cambio se hace en una rama nueva (por ejemplo `feature/exportar-pdf`) y se integra con un **pull request**.
- El pull request usa la plantilla de `.github/PULL_REQUEST_TEMPLATE.md` y debe tener las pruebas pasando.
- Los errores y mejoras se registran como **issues**.
- Mensajes de commit cortos y en presente (ejemplo: `Agrega validación de solución obligatoria`).

## Limitaciones conocidas

- No tiene inicio de sesión ni permisos.
- No se pueden editar ni borrar informes desde la interfaz.
- El formulario permite hasta 3 actividades y 3 problemas por informe (la validación acepta hasta 10).
- No exporta a PDF.

## Responsables

- Autor: Arias Luna Angel Daniel
- Contexto: actividad de Gestión de Proyectos (NouriTech, Food Waste Analytics)
