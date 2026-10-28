<?php

use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

Route::resource('reportes', ReporteController::class)
    ->only(['index', 'create', 'store', 'show']);
