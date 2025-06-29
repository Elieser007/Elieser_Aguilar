<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['nombre_categoria' => 'Electrónica', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_categoria' => 'Ropa', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_categoria' => 'Libros', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_categoria' => 'Hogar', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
