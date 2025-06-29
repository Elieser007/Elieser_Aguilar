<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asumimos que las categorías ya existen y tienen IDs 1, 2, 3, 4
        DB::table('productos')->insert([
            [
                'nombre_producto' => 'Smartphone',
                'precio' => 50000,
                'id_categoria' => 1, // Electrónica
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_producto' => 'Camiseta',
                'precio' => 1500,
                'id_categoria' => 2, // Ropa
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_producto' => 'Novela',
                'precio' => 2000,
                'id_categoria' => 3, // Libros
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_producto' => 'Lámpara',
                'precio' => 3500,
                'id_categoria' => 4, // Hogar
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
