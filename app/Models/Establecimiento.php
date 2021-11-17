<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establecimiento extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
        
    ];
    // relacion uno a uno categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
