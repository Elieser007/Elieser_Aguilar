<?php

namespace App\Http\Controllers;

use App\Models\Persona; 
use Illuminate\Http\Request;

class PersonaController extends Controller
    {
        
        public function index()
        {
            try {
                // Obtener todas las personas
                $personas = Persona::all();

                // Añadir el atributo 'full_name' (nombre completo) a cada persona
                
                $personas->each(function ($persona) {
                    // Solo si el accesor 'full_name' no se ha añadido ya automáticamente por un toArray()
                    if (!isset($persona->full_name)) {
                        $persona->append('full_name');
                    }
                });

                return response()->json($personas);

            } catch (\Exception $e) {
                
                // Devuelve una respuesta de error JSON para que el frontend pueda manejarla
                return response()->json(['message' => 'Error interno del servidor al cargar personas.'], 500);
            }
        }

        
    }
