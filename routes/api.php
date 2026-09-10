<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProspectController;
use App\Http\Controllers\FollowUpController;

// 1. Ruta para cerrar prospecto (debe ir antes del apiResource)
Route::patch('/prospects/{prospect}/close', [ProspectController::class, 'close']);

// 2. Ruta para agregar seguimientos a un prospecto
Route::post('/prospects/{prospect}/follow-ups', [FollowUpController::class, 'store']);

// 3. Rutas CRUD completas de Prospectos (index, store, show, update, destroy)
Route::apiResource('prospects', ProspectController::class);
