<?php
namespace Aplicacion\models;

use Illuminate\Database\Eloquent\Model;

class bebidasTable extends Model{
    protected $table = "bebidas";
    public $timestamps = false;
    //protected $table = "datos"; //forzar una tabla especifica y que no lea user por default
   // protected $primaryKey = ""; // esatblecer primarykey
    
    
}