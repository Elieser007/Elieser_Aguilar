<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorias extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nombre_categoria'];
    public function Productos(): HasMany
    {
        return $this->hasMany(Productos::class);
    }
}
