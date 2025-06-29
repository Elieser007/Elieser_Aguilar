<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Productos extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nombre_producto', 'precio', 'id_categoria'];
    public function categorias(): BelongsTo
    {
        return $this->belongsTo(Categorias::class, 'id_categoria');
    }
}
