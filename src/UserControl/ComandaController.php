<?php

namespace Aplicacion\Controller;

use Aplicacion\models\alimentosTable;
use Aplicacion\models\bebidasTable;
use Aplicacion\models\cervezasTable;
use Aplicacion\models\mesaTable;
use Aplicacion\models\empleadosTable;
use Illuminate\Contracts\Routing\Registrar;
use Aplicacion\models\JSend;
use Aplicacion\models\pedidosTable;
use Utils\Token;

class ComandaController
{

    public function getOne($request, $response, $args)
    {
        $jSend = new JSend("error");
        $id = $args['id'];

        $empleado = pedidosTable::where('id', $id)->first();
        if (isset($empleado)) {
            $jSend->data = $empleado;
            $response->getBody()->write(json_encode($jSend));
        } else {
            $jSend->message = "ID Inexistente";
            $response->getBody()->write(json_encode($jSend));
        }

        return $response;
    }

    public function getAll($request, $response, $args)
    {

        $jSend = new JSend('Exito');

        $jSend->data = pedidosTable::get();

        $response->getBody()->write(json_encode($jSend));

        return $response;
    }

    public static function Insert($request, $response, $args)
    {
        $jSend = new JSend('error');
        $params = $request->getParsedBody();
        $alimentoId = $params['alimentoId'] ?? '';
        $cerveza = $params['cerveza'] ?? '';
        $bebida = $params['bebida'] ?? '';
        $mesa = $params['mesa'] ?? '';

        $alimento = alimentosTable::where('id', $alimentoId)->first();
        $bebida = bebidasTable::where('id', $bebida)->first();
        $cervezas = cervezasTable::where('id', $cerveza)->first();
        $mesa = mesaTable::where('codigoMesa', $mesa)->first();;

        if ($alimento != null && $bebida != null && $cervezas != null && $mesa != null) {
            $codigo = self::RandomCode(5);

            $pedido = new pedidosTable();
            $pedido->comida = $alimento->descripcion;
            $pedido->bebida = $bebida->descripcion;
            $pedido->cerveza = $cervezas->descripcion;
            $pedido->estado = "Pendiente";
            $pedido->Codigo = $codigo;
            $pedido->en_preparacion = 0;
            $pedido->mesa = $mesa->codigoMesa;
            $mesa->codigoPedido = $codigo;
            $mesa->estadoPedido = "Pendiente";

            $pedido->save();
            $mesa->save();

            $jSend->status = 'success';
            $jSend->data->mensajeExito = 'Guardado exitoso';
        } else {
            $jSend->message = 'No hay alimento con ese id';
        }


        $response->getBody()->write(json_encode($jSend));
        return  $response;
    }

    public function prepararPedido($request, $response, $args)
    {

        $jSend = new JSend("Error");
        $params = $request->getParsedBody();
        $idPedido = $params["idPedido"];


        $pedidoBuscado = pedidosTable::where('id', $idPedido)->first();
        
        if (isset($pedidoBuscado)) {
            $mesa = mesaTable::where('codigoMesa', $pedidoBuscado->mesa)->first();
            $mesa->estadoPedido = "Preparando";

            if ($pedidoBuscado->estado != "Entregado") {

                $pedidoBuscado->estado = "Preparando";
            
                $pedidoBuscado->en_preparacion = 1;

                $pedidoBuscado->save();
                $mesa->save();


                $jSend->message = "Asignacion Existosa";
                $jSend->status = "success";
            } else {
                $jSend->message = "pedido Entregado";
            }
        } else {
            $jSend->message = "ID no encontrado";
        }



        $response->getBody()->write(json_encode($jSend));

        return $response;
    }

    public function terminarPedido($request, $response, $args)
    {

        $jSend = new JSend("Error");
        $params = $request->getParsedBody();
        $idPedido = $params["idPedido"];

        $pedido = pedidosTable::where('id', $idPedido)->first();

        if (isset($pedido)) {

            $mesa = mesaTable::where('codigoMesa', $pedido->mesa)->first();
            if ($pedido->estado != "entregado") {
                
                $pedido->estado = "entregado";
                $pedido->en_preparacion = 0;
            $mesa->estadoPedido = "Entregado";
            $mesa->codigoPedido= "";
                $pedido->save();
            $mesa->save();



                $jSend->message = "Pedido Preparado";
                $jSend->status = "Success";
            } else {
                $jSend->message = "El pedido Ya fue preparado";
            }
        } else {
            $jSend->message = "ID incorrecto";
        }





        $response->getBody()->write(json_encode($jSend));

        return $response;
    }

    public function entregarPedido($request, $response, $args)
    {

        $jSend = new JSend("Error");
        $params = $request->getParsedBody();
        $idPedido = $params["idPedido"];

        $pedido = pedidosTable::where('id', $idPedido)->first();

        if (isset($pedido)) {
            if ($pedido->estado == "preparado") {

                $pedido->estado = "preparado";
                $pedido->en_preparacion = 0;
                $pedido->save();

                $jSend->message = "Pedido entregado";
                $jSend->status = "Success";
            } else {
                $jSend->message = "El pedido aun no esta listo";
            }
        } else {
            $jSend->message = "ID incorrecto";
        }





        $response->getBody()->write(json_encode($jSend));

        return $response;
    }

    public static function RandomCode($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}
