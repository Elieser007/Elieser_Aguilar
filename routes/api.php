<?php

use App\Http\Controllers\BancoController;
use App\Http\Controllers\CondicionPagoController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProveedorDocumentoController;
use App\Http\Controllers\TipoDocumentoProveedorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->group(function () {
    // Rutas para Proveedores (CRUD completo, consumidas por Vue.js)
    // El except(['destroy']) en resource significa que la eliminación es personalizada.
    Route::resource('proveedores', ProveedorController::class)->except(['destroy']);
    // Ruta personalizada para la "eliminación lógica" (desactivación) de proveedores
    Route::put('proveedores/{proveedor}/desactivar', [ProveedorController::class, 'destroy']);

    /// LISTAR documentos de un proveedor
    Route::get('proveedores/{proveedor}/documentos', [ProveedorDocumentoController::class, 'index']);

    // SUBIR un nuevo documento para un proveedor
    Route::post('proveedores/{proveedor}/documentos', [ProveedorDocumentoController::class, 'store']);

    // DESCARGAR un documento específico de un proveedor (el método show en el controlador)
    Route::get('proveedores/{proveedor}/documentos/{documento}', [ProveedorDocumentoController::class, 'show']);

    // ELIMINACIÓN LÓGICA (DESACTIVACIÓN) de un documento de proveedor
    // Esta ruta PUT ahora apunta al método 'desactivar' en el controlador
    Route::put('proveedores/{proveedor}/documentos/{documento}/desactivar', [ProveedorDocumentoController::class, 'desactivar']); // <-- ¡CORREGIDO!

    // ELIMINACIÓN FÍSICA de un documento de proveedor (opcional, si realmente lo necesitas)
    // Esta ruta DELETE ahora apunta al método 'destroy' en el controlador para borrado físico
    Route::delete('proveedores/{proveedor}/documentos/{documento}', [ProveedorDocumentoController::class, 'destroy']);

    // Rutas para los Catálogos (solo 'index' para obtener la lista, consumidas por Vue.js)
    Route::get('bancos', [BancoController::class, 'index']);
    Route::post('bancos', [BancoController::class, 'store']); // Para crear bancos
    Route::put('bancos/{banco}', [BancoController::class, 'update']); // Para actualizar
    Route::put('bancos/{banco}/desactivar', [BancoController::class, 'destroy']); // Para desactivar (soft delete)
    Route::get('metodo-pagos', [MetodoPagoController::class, 'index']);
    Route::post('metodo-pagos', [MetodoPagoController::class, 'store']);
    Route::put('metodo-pagos/{metodo_pago}', [MetodoPagoController::class, 'update']);
    Route::put('metodo-pagos/{metodo_pago}/desactivar', [MetodoPagoController::class, 'destroy']); // Para desactivar
    Route::get('condicion-pagos', [CondicionPagoController::class, 'index']);
    Route::post('condicion-pagos', [CondicionPagoController::class, 'store']);
    Route::put('condicion-pagos/{condicion_pago}', [CondicionPagoController::class, 'update']);
    Route::put('condicion-pagos/{condicion_pago}/desactivar', [CondicionPagoController::class, 'destroy']);
    Route::get('tipo-documento-proveedors', [TipoDocumentoProveedorController::class, 'index']);
    Route::post('tipo-documento-proveedors', [TipoDocumentoProveedorController::class, 'store']);
    Route::put('tipo-documento-proveedors/{tipo_documento_proveedor}', [TipoDocumentoProveedorController::class, 'update']);
    Route::put('tipo-documento-proveedors/{tipo_documento_proveedor}/desactivar', [TipoDocumentoProveedorController::class, 'destroy']);

    Route::get('personas', [PersonaController::class, 'index']); 

    Route::get('proveedores/{proveedor}/documentos/{documento}/descargar', [ProveedorDocumentoController::class, 'descargar']);
});