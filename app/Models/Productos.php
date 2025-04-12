<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'productos';


    /**
     *
     * Aquí lo que hacemos es declarar los campos que se van a rellenar en la bdd
     *
     */

    protected $fillable = [
        'nombre_producto',
        'precio',
        'stock',
        'categoria',
        'imagen',
        'created_at',
    ];
}
