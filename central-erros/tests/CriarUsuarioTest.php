<?php

namespace Test;

use Central\Actions\Usuario\CriarUsuario;
use Central\Entity\Erro;
use Central\Entity\Usuario;
use Central\Framework\CentralToken;
use Central\Middleware\Auth;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Stream;

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
    public function test__invoke()
    {


        $Usuario = Usuario::factory(
            "",
            "teste",
            "teste@teste.com");


        $stream = new Stream('php://memory', 'wb+');
        $stream->write(json_encode($Usuario));
        $stream->rewind();

        $request = new ServerRequest([], [], null, 'POST', $stream);

        $CriarUsuario = new CriarUsuario($this->entityManager);
        $this->assertSame($CriarUsuario($request)->getStatusCode(), 201, 'usuario cadastrado com sucesso');
        $this->assertSame($this->entityManager->find(Usuario::class, 1)->email, "teste@teste.com", 'o email cadastrado esta diferente do esperado');//
    }

    public function testExisteUsuario()
    {
//
    }
}
