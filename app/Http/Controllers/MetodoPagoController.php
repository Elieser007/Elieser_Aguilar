<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodoPago;

class MetodoPagoController extends Controller
{
    public function index()
    {
        $metodosPago = MetodoPago::activos()->get();
        return response()->json($metodosPago);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100|unique:metodo_pagos,nombre',
        ]);
        $metodo = MetodoPago::create($validatedData);
        return response()->json($metodo, 201);
    }

    public function show(string $id)
    {
        $metodo = MetodoPago::activos()->findOrFail($id);
        return response()->json($metodo);
    }

    public function update(Request $request, string $id)
    {
        $metodo = MetodoPago::activos()->findOrFail($id);
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100|unique:metodo_pagos,nombre,' . $id . ',idmetodopago',
            'estado' => 'sometimes|boolean'
        ]);
        $metodo->update($validatedData);
        return response()->json($metodo);
    }

    public function destroy(string $id) 
    {
        $metodo = MetodoPago::activos()->findOrFail($id);
        $metodo->eliminar(); 
        return response()->json(['message' => 'Método de pago desactivado exitosamente'], 200);
    }
}
