<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo') | NouriTech FoodTech</title>
    <style>
        body { font-family: Calibri, Arial, sans-serif; margin: 0; color: #222; background: #f5f5f5; }
        header { background: #2f5d50; color: #fff; padding: 14px 24px; font-weight: bold; }
        main { max-width: 960px; margin: 24px auto; padding: 0 16px; }
        .tarjeta { background: #fff; border: 1px solid #ddd; border-radius: 6px; padding: 16px 20px; margin-bottom: 18px; }
        .barra { display: flex; justify-content: space-between; align-items: center; }
        h1 { font-size: 1.5rem; } h2 { font-size: 1.15rem; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; vertical-align: top; font-size: .92rem; }
        th { background: #e6e6e6; }
        label { display: block; margin: 10px 0 4px; font-weight: bold; }
        input, select, textarea { width: 100%; box-sizing: border-box; padding: 6px; font: inherit; }
        .fila { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; border-top: 1px dashed #bbb; padding-top: 6px; margin-top: 10px; }
        .boton { display: inline-block; background: #2f5d50; color: #fff; padding: 8px 14px; border: 0; border-radius: 4px; text-decoration: none; cursor: pointer; font: inherit; }
        .aviso { background: #e3f3e8; border: 1px solid #9bcaa9; padding: 10px; border-radius: 4px; margin-bottom: 14px; }
        .errores { background: #fdeaea; border: 1px solid #e0a0a0; padding: 10px; border-radius: 4px; margin-bottom: 14px; }
        .semaforo { padding: 2px 10px; border-radius: 10px; font-size: .85rem; color: #fff; }
        .semaforo.verde { background: #2e8b57; } .semaforo.amarillo { background: #c9a100; } .semaforo.rojo { background: #b83232; }
        .ayuda { color: #666; font-size: .85rem; }
    </style>
</head>
<body>
    <header>NouriTech FoodTech · Informes de seguimiento</header>
    <main>
        @if (session('ok'))
            <div class="aviso">{{ session('ok') }}</div>
        @endif
        @yield('contenido')
    </main>
</body>
</html>
