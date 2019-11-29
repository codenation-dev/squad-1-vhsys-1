<?php

$strategy = (new League\Route\Strategy\ApplicationStrategy)
    ->setContainer(\Central\Framework\App::getContainer());
$router   = (new League\Route\Router)->setStrategy($strategy);

$router->post('/central/criar_usuario', \Central\Actions\Usuario\CriarUsuario::class);

$router->group('/central', function ($router) {
    $router->map('GET', '/usuario', \Central\Actions\Usuario\RecuperarTodosUsuarios::class);
    $router->map('GET', '/usuario/{id}', \Central\Actions\Usuario\RecuperarUsuario::class);
    $router->map('PUT', '/usuario/[{id}]', \Central\Actions\Usuario\CriarOuAtualizarUsuario::class);
    $router->map('PATCH', '/usuario/{id}', \Central\Actions\Usuario\AtualizarUsuario::class);
    $router->map('DELETE', '/usuario/{id}', \Central\Actions\Usuario\DeletarUsuario::class);
    $router->map('POST', '/usuario/esqueceu_senha', \Central\Actions\Usuario\EsqueceuSenha::class);
    $router->map('POST', '/usuario/login', \Central\Actions\Usuario\Login::class);

    $router->map('GET', '/erro/{buscarPor}/{valor}/{ordenarPor}', \Central\Actions\Erro\RecuperarErros::class);
    $router->map('GET', '/erro', \Central\Actions\Erro\RecuperarTodosErros::class);
    $router->map('GET', '/erro/{id}', \Central\Actions\Erro\RecuperarErro::class);
    $router->map('POST', '/erro', \Central\Actions\Erro\CriarErro::class);
    $router->map('PUT', '/erro/[{id}]', \Central\Actions\Erro\CriarOuAtualizarErro::class);
    $router->map('PUT', '/erro/arquivar/{id}', \Central\Actions\Erro\ArquivarErro::class);
    $router->map('PATCH', '/erro/{id}', \Central\Actions\Erro\AtualizarErro::class);
    $router->map('DELETE', '/erro/{id}', \Central\Actions\Erro\DeletarErro::class);

    $router->middleware(new \Central\Middleware\Auth);
});

return $router;