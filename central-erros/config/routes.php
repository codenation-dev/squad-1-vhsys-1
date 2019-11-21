<?php

$strategy = (new League\Route\Strategy\ApplicationStrategy)
    ->setContainer(\Central\Framework\App::getContainer());
$router   = (new League\Route\Router)->setStrategy($strategy);

$router->get('/central/', function ($request){
    $response = new Zend\Diactoros\Response();
    $response->getBody()->write('hommer');
    return $response;
});


$router->middleware(new \Central\Middleware\Auth);

$router->get('/central/usuario', \Central\Actions\Usuario\RecuperarTodosUsuarios::class);
$router->post('/central/criar_usuario', \Central\Actions\Usuario\CriarUsuario::class);

$router->post('/central/usuario/esqueceu_senha', \Central\Actions\Usuario\EsqueceuSenha::class);
$router->post('/central/usuario/login', \Central\Actions\Usuario\Login::class);

$router->get('/central/erro', \Central\Actions\Erro\RecuperarTodosErros::class);
$router->get('/central/erro/{id}', \Central\Actions\Erro\RecuperarErro::class);
$router->post('/central/erro', \Central\Actions\Erro\CriarErro::class);
$router->put('/central/erro[/{id}]', \Central\Actions\Erro\CriarOuAtualizarErro::class);
$router->patch('/central/erro/{id}', \Central\Actions\Erro\AtualizarErro::class);
$router->delete('/central/erro/{id}', \Central\Actions\Erro\DeletarErro::class);

return $router;