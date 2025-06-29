<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CondicionPago;
class CondicionPagoController extends Controller
{
    public function index()
    {
        $condicionesPago = CondicionPago::activos()->get();
        return response()->json($condicionesPago);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100|unique:condicion_pagos,nombre',
            
        ]);

        $condicion = CondicionPago::create($validatedData);
        return response()->json($condicion, 201); // 201 Created
    }

    /**
     * Muestra una condición de pago específica.
     */
    public function show(string $id)
    {
        $condicion = CondicionPago::activos()->findOrFail($id);
        return response()->json($condicion);
    }

    /**
     * Actualiza la condición de pago especificada en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        $condicion = CondicionPago::activos()->findOrFail($id);

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100|unique:condicion_pagos,nombre,' . $id . ',idcondicionpago',
            'estado' => 'sometimes|boolean' // 'sometimes' significa que es opcional, pero si se envía, debe ser booleano
        ]);

        $condicion->update($validatedData);
        return response()->json($condicion);
    }

    /**
     * Desactiva (elimina lógicamente) la condición de pago especificada.
     */
    public function destroy(string $id)
    {
        $condicion = CondicionPago::activos()->findOrFail($id);
        $condicion->eliminar(); // Asume que tienes un método 'eliminar()' para soft delete en tu modelo CondicionPago
        return response()->json(['message' => 'Condición de pago desactivada exitosamente'], 200);
    }
}
