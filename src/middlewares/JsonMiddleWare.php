<?php
namespace Aplicacion\Middlewares;

class JSONMiddleWare {

    public function __invoke($request, $handler) {
        $response = $handler->handle($request);

        $response = $response->withHeader('Content-Type', 'application/json');

        return $response;
    }
}