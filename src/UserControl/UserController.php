<?php
namespace Aplicacion\Controller;

use Aplicacion\models\UsuariosTable;
use Illuminate\Contracts\Routing\Registrar;
use Aplicacion\models\JSend;
use Utils\Token;

class UserController{

    public function getAll($request, $response, $args) {
        $response->getBody()->write(json_encode("BienMostro"));

        return $response;
    }
   
    public function Login($request, $response, $args) {
        // $jSend = new JSend('error');
        // $params = $request->getParsedBody();
        // $email = $params['email'] ?? '';
        // $clave = $params['password'] ?? '';
        // $lista = Usuario::GetAll();
        // foreach ($lista as $value)
        // {
        //     if($value->email === $email && $value->clave === sha1($clave) && $value->estado !== 'borrado')
        //     {
        //         if($value->tipo === 'empleado')
        //         {
        //             $listaEmpleados = Empleado::GetAll();
        //             $empleado = Empleado::FindByEmail($listaEmpleados, $email);
        //             if($empleado !== false)
        //                 $jwt = Token::CrearToken($value->email, $value->tipo, $empleado->ocupacion);
        //             else
        //                 $jwt = Token::CrearToken($value->email, $value->tipo, 'sin ocupacion');
        //         }
        //         else
        //             $jwt = Token::CrearToken($value->email, $value->tipo, 'sin ocupacion');
        //         $value->UpdateLoginDttm();
        //         $jSend->status = 'success';
        //         $jSend->data->token = $jwt;
        //         return json_encode($jSend);
        //     }
        // }
        // $jSend->message = 'Email y/o clave incorrecto/s';
        // return json_encode($jSend);
    }

    public function generarToken($request, $response, $args) {
        $jSend = new JSend('error');
        $req = $request->getParsedBody();
        
        $email = $req['email'] ?? '';
        
        $usuario = UsuariosTable::where('email',$email)->first();
        
        if ($usuario != null){
                $token = Token::GenerarToken($usuario["email"],$usuario["tipo_usuario"]);
                $jSend->status = 'success';
                $jSend->data->token = $token;
                $response->getBody()->write(json_encode($jSend));
                return $response;
        } else{
            $jSend->message = 'Email incorrecto';
            $response->getBody()->write(json_encode($jSend));
            return $response;
        }
        // foreach ($todos as $value)
        // {
        //     if($value->email === $email && $value->tipo_empleados == 'empleado')                
        //     {
        //         $token = Token::GenerarToken($value->email, $value->tipo_empleado);
        //         $jSend->status = 'success';
        //         $jSend->data->token = $token;
        //         $response->getBody()->write(json_encode($jSend));
        //         return $response;
        //     }
        //     else if($value->email === $email && $value->tipo_empleados == 'socio'){
        //         $token = Token::GenerarToken($value->email, $value->tipo_empleado);
        //         $jSend->status = 'success';
        //         $jSend->data->token = $token;
        //         $response->getBody()->write(json_encode($jSend));
        //         return $response;
        //     }           
        // }
        // $jSend->message = 'Email incorrecto';
        // $response->getBody()->write(json_encode($jSend));
        // return $response;
    }   







//    public function addUser($request, $response, $args) {
//         $id = $args['id'];
//         $user = regitros::where('id',$id)->first();

//         $user->email = "marina";
//         $rta = $user->save();        
//         $response->getBody()->write(json_encode($user));
//         return $response;
//     }  
//     public function getAll($request, $response, $args) {
//         $rta = regitros::get();
        
//         $response->getBody()->write(json_encode($rta));
//         return $response;
//     }
//     public function delete($request, $response, $args) {
//         $id = $args['id'];
//         $user = regitros::where('id',$id)->first();
//         $rta = $user->delete();
        
//         $response->getBody()->write(json_encode($rta));
//         return $response;
//     }
//     public function addUsuario($request, $response, $args) {
//         $user = new regitros;
//         $user->email="Bruno";
//         $user->tipo = "admin";
//         $user->password = "123";
//         $user->foto = "foto";
        
//         $rta = $user->save();

//         $response->getBody()->write(json_encode($rta));
//         return $response;
//     }
    
}