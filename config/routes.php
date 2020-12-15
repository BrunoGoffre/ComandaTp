<?php

use Aplicacion\Controller\EmpleadosController;
use Aplicacion\Controller\UserController;
use Aplicacion\Controller\ComandaController;
use Aplicacion\Middlewares\AuthSocioMiddleware;
use Aplicacion\Middlewares\JSONMiddleWare;
use Aplicacion\Middlewares\AuthTokenMiddleWare;
use Slim\Routing\RouteCollectorProxy;

return function ($app) {

    $app->post('/login[/]', UserController::class . ":generarToken");

    $app->group('/empleados', function (RouteCollectorProxy $group) {

        $group->get('/{id}', EmpleadosController::class . ":GetOne");

        $group->get('[/]', EmpleadosController::class . ":GetAll");

    })->add(new AuthSocioMiddleware);

    $app->group('/pedidos', function (RouteCollectorProxy $group) {

        $group->get('/{id}', ComandaController::class . ":getOne");
    
        $group->get('[/]', ComandaController::class . ":getAll");
    
        $group->post('[/]', ComandaController::class . ":Insert");
        
    
    })->add(new AuthTokenMiddleWare);

    $app->group('/Mozo', function (RouteCollectorProxy $group) {

        $group->post('/AsignarPedido', ComandaController::class . ":prepararPedido");
    
        $group->post('entregarPedido[/]', ComandaController::class . ":entregarPedido");
    
    })->add(new AuthTokenMiddleWare);

    $app->post('/preparador[/]', ComandaController::class . ":terminarPedido")->add(new AuthTokenMiddleWare);

    $app->add(new JSONMiddleWare);
};
