<?php
namespace Aplicacion\Middlewares;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Utils\Token;
use Aplicacion\Models\JSend;

class AuthSocioMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $response = new Response();

        $token = $_SERVER['HTTP_TOKEN'] ?? '';
        $usuario = Token::AutenticarToken($token);
        if($usuario->tipo_usuario == 'socio')
        {
            $response = $handler->handle($request);

            //$response->getBody()->write($existingContent);

            return $response;
        }
        else
        {
            $jSend = new JSend('Error');
            $jSend->message = 'Acceso no autorizado';

            $response->getBody()->write(json_encode($jSend));

            return $response->withStatus(403);
        }
    }
}
?>