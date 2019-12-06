<?php

namespace Test;

use Central\Actions\Usuario\CriarUsuario;
use Central\Entity\Erro;
use Central\Entity\Usuario;
use Central\Middleware\Auth;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;

class CriarUsuarioTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    private $entityManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->entityManager = EntityManager::create(
                DriverManager::getConnection(['url' => 'sqlite:///:memory:']),
                Setup::createAnnotationMetadataConfiguration(
                    array(__DIR__ . '/../src/Entity'),
                    false,
                null,
                null,
                false
            )
        );
        $tool = new SchemaTool($this->entityManager);
        $tool->createSchema(
            [
                $this->entityManager->getClassMetadata(Usuario::class),
                $this->entityManager->getClassMetadata(Erro::class)
            ]
        );
    }

    public function testExisteMiddleware(): void
    {
        $this->assertTrue(class_exists(Auth::class), 'Nao foi criado o middleware de autenticação: Locadora\Middleware\Auth');
    }
}
