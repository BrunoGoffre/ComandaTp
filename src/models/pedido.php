<?php
namespace App\Models;
use Config\AccesoDatos;
use PDO;
use App\Models\FechasTabla;

class pedido
{
    public $id;
    public $comida;
    public $bebida;
    public $cerveza;
    public $estado;

    public function __constructor($id, $comida = null,$bebida = null,$cerveza= null, $estado = "terminado")
    {
        $this->$id = $id;
        $this->$comida = $comida;
        $this->$bebida = $bebida;
        $this->$cerveza = $cerveza;
        $this->$estado = $estado;
    }
}