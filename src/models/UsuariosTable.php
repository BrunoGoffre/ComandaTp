<?php
namespace Aplicacion\models;

use Illuminate\Database\Eloquent\Model;

class UsuariosTable extends Model{
    protected $table = "usuarios";
    public $timestamps = false;
    //protected $table = "datos"; //forzar una tabla especifica y que no lea user por default
   // protected $primaryKey = ""; // esatblecer primarykey
    
    
}