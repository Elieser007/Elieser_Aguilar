<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\Categorias;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index(Request $request)
    {
        $query = Productos::query();

        // Filtro por nombreAdd commentMore actions
        if ($request->filled('name')) {
            $query->where('nombre_producto', 'like', '%' . $request->input('name') . '%');
        }
        // Filtro por correo electrónico
        else if ($request->filled('categories')) {
            $query->where('id_categoria', 'like', '%' . $request->input('categories') . '%');
        }
        // Filtro por fecha de creación
        else if ($request->filled('createdAtFrom') && $request->filled('createdAtTo')) {
            $query->whereDate('created_at', '>=', $request->input('createdAtFrom'))->whereDate('created_at', '<=', $request->input('createdAtTo'));
        }

        $productos = $query->with('categorias:id,nombre_categoria')->orderBy('productos.id', 'desc')->get();

        $categorias = Categorias::all();

        return Inertia::render('Products/index', [
            'productos' => $productos,
            'categorias' => $categorias
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_producto' => 'required|max:80',
            'precio' => 'required|numeric',
            'id_categoria' => 'required|numeric',
        ]);
        $producto = new Productos([
            'nombre_producto' => $request->nombre_producto,
            'precio' => $request->precio,
            'id_categoria' => $request->id_categoria,
        ]);
        $producto->save();
        return redirect('productos');
    }

    public function show(Productos $producto)
    {
        //
    }

    public function edit(Productos $producto)
    {
        //
    }

    public function update(Request $request, Productos $producto)
    {
        $request->validate([
            'nombre_producto' => 'required|max:80',
            'precio' => 'required|numeric',
            'id_categoria' => 'required|numeric',
        ]);
        $producto->update([
            'nombre_producto' => $request->nombre_producto,
            'precio' => $request->precio,
            'id_categoria' => $request->id_categoria,
        ]);
        return redirect('productos');
    }

    public function destroy(Productos $producto)
    {
        $producto->delete();
        return redirect('productos');
    }
}
