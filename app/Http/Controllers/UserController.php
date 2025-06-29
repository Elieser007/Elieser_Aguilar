<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filtro por nombre
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        // Filtro por correo electrónico
        else if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
        }
        // Filtro por fecha de creación
        else if ($request->filled('createdAtFrom') && $request->filled('createdAtTo')) {
            $query->whereDate('created_at', '>=', $request->input('createdAtFrom'))->whereDate('created_at', '<=', $request->input('createdAtTo'));
        }

        $users = $query->paginate()->withQueryString();

        // Devuelve la vista Inertia con los usuarios paginados
        return Inertia::render('Users/Index', [
            'users' => $users
        ]);
    }
}
