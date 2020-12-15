<?php
namespace Aplicacion\Controller;

use Aplicacion\models\UsuariosTable;
use Illuminate\Contracts\Routing\Registrar;
use Aplicacion\models\JSend;
use Utils\Token;

class EmpleadosController{
    public function getOne($request, $response, $args) {
        $id = $args['id'];

        $empleado = UsuariosTable::where('id',$id)->first();
        if (isset($empleado)){

            if ($empleado->tipo_usuario == "empleado"){
                
                $response->getBody()->write(json_encode($empleado));
            }else{
                $response->getBody()->write(json_encode("Error: el id ingreso no pertenece a un empleado"));
            }
        }else{
            $response->getBody()->write(json_encode("ID: Inexistente"));
        }

        return $response;
    }

    public function getAll($request, $response, $args) {

        //$empleados = UsuariosTable::get();
        $empleados = UsuariosTable::where('tipo_usuario',"empleado")->get();

        $response->getBody()->write(json_encode($empleados));

        return $response;
    }

}