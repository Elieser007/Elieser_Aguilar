<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function index()
    {
        $categorias = Categorias::All();
        return Inertia::render('Categories/index', [
            'categorias' => $categorias
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required|max:150',
        ]);
        $categoria = new Categorias([
            'nombre_categoria' => $request->nombre_categoria,
        ]);
        $categoria->save();
        return redirect('categorias');
    }

    public function update(Request $request, Categorias $categoria)
    {
        $request->validate([
            'nombre_categoria' => 'required|max:150',
        ]);
        $categoria->update([
            'nombre_categoria' => $request->nombre_categoria,
        ]);
        return redirect('categorias');
    }

    public function destroy(Categorias $categoria)
    {
        $categoria->delete();
        return redirect('categorias');
    }
}
