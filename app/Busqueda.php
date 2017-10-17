<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Busqueda
 *
 * @package App
 * @property string $fehca
 * @property string $ubicacion
 * @property string $no_personas
*/
class Busqueda extends Model
{
    protected $fillable = ['fehca', 'ubicacion', 'no_personas'];
    
    
}
                