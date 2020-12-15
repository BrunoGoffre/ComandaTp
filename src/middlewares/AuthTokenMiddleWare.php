<?php
namespace Aplicacion\Middlewares;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Utils\Token;
use Aplicacion\models\JSend;
use Throwable;

class AuthTokenMiddleWare
{
    public function __invoke(Request $request, RequestHandler $handler)
    {   
        $response = new Response();
        $token = $_SERVER['HTTP_TOKEN'] ?? '';
        if (Token::AutenticarToken($token)){

            $resp = $handler->handle($request);
            $existingContent = (string) $resp->getBody();
            $response->getBody()->write($existingContent);
            return $response;

        }else{

            $jSend = new JSend('error');
            $jSend->message = 'Token invalido';

            $response = new Response();
            $response->getBody()->write(json_encode($jSend));

            return $response->withStatus(403);
        }
    }
}
?>