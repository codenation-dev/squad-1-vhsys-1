<?php
use \Central\Framework\App;

App::getContainer()->add(\Doctrine\ORM\EntityManager::class, function () {
    return (include __DIR__ . '/doctrine.php');
});

App::getContainer()->add(\Central\Actions\Erro\RecuperarTodosErros::class, function () {
    return new \Central\Actions\Erro\RecuperarTodosErros(
        App::getContainer()->get(\Doctrine\ORM\EntityManager::class)
    );
});

App::getContainer()->add(\Central\Actions\Erro\RecuperarErro::class, function () {
    return new \Central\Actions\Erro\RecuperarErro(
        App::getContainer()->get(\Doctrine\ORM\EntityManager::class)
    );
});

App::getContainer()->add(\Central\Actions\Erro\CriarErro::class, function () {
    return new \Central\Actions\Erro\CriarErro(
        App::getContainer()->get(\Doctrine\ORM\EntityManager::class)
    );
});

App::getContainer()->add(\Central\Actions\Erro\CriarOuAtualizarErro::class, function () {
    return new \Central\Actions\Erro\CriarOuAtualizarErro(
        App::getContainer()->get(\Doctrine\ORM\EntityManager::class)
    );
});

App::getContainer()->add(\Central\Actions\Erro\AtualizarErro::class, function () {
    return new \Central\Actions\Erro\AtualizarErro(
        App::getContainer()->get(\Doctrine\ORM\EntityManager::class)
    );
});

App::getContainer()->add(\Central\Actions\Erro\DeletarErro::class, function () {
    return new \Central\Actions\Erro\DeletarErro(
        App::getContainer()->get(\Doctrine\ORM\EntityManager::class)
    );
});




/*
App::getContainer()->add(\Central\Actions\Usuario\RecuperarTodosUsuarios::class, function () {
    return new \Central\Actions\Usuario\RecuperarTodosUsuarios(
        App::getContainer()->get(\Doctrine\ORM\EntityManager::class)
    );
});
*/

App::getContainer()->add(\Central\Actions\Usuario\RecuperarTodosUsuarios::class, function () {
    return new \Central\Actions\Usuario\RecuperarTodosUsuarios(
        App::getContainer()->get(\Doctrine\ORM\EntityManager::class)
    );
});

App::getContainer()->add(\Central\Actions\Usuario\RecuperarUsuario::class, function () {
    return new \Central\Actions\Usuario\RecuperarUsuario(
        App::getContainer()->get(\Doctrine\ORM\EntityManager::class)
    );
});

App::getContainer()->add(\Central\Actions\Usuario\CriarUsuario::class, function () {
    return new \Central\Actions\Usuario\CriarUsuario(
        App::getContainer()->get(\Doctrine\ORM\EntityManager::class)
    );
});

App::getContainer()->add(\Central\Actions\Usuario\CriarOuAtualizarUsuario::class, function () {
    return new \Central\Actions\Usuario\CriarOuAtualizarUsuario(
        App::getContainer()->get(\Doctrine\ORM\EntityManager::class)
    );
});

App::getContainer()->add(\Central\Actions\Usuario\AtualizarUsuario::class, function () {
    return new \Central\Actions\Usuario\AtualizarUsuario(
        App::getContainer()->get(\Doctrine\ORM\EntityManager::class)
    );
});

App::getContainer()->add(\Central\Actions\Usuario\DeletarUsuario::class, function () {
    return new \Central\Actions\Usuario\DeletarUsuario(
        App::getContainer()->get(\Doctrine\ORM\EntityManager::class)
    );
});