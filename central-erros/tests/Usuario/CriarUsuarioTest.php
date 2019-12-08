<?php

namespace Test;

use Central\Actions\Usuario\CriarUsuario;
use Central\Actions\Usuario\EsqueceuSenha;
use Central\Actions\Usuario\Login;
use Central\Actions\Usuario\RecuperarUsuario;
use Central\Entity\Erro;
use Central\Entity\Usuario;
use Central\Framework\CentralToken;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Stream;

class CriarUsuarioTest extends TestCase
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

    public function test_CriarUsuario()
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
        $this->assertSame($CriarUsuario($request)->getStatusCode(), 200, 'usuario cadastrado com sucesso');
        $this->assertSame($this->entityManager->find(Usuario::class, 1)->email, "teste@teste.com", 'o email cadastrado esta diferente do esperado');//
    }

    public function test_CriarUsuarioComMesmoEmail()
    {
        $Usuario = Usuario::factory(
            "",
            "teste",
            "teste@teste.com");
        $stream = new Stream('php://memory', 'wb+');
        $stream->write(json_encode($Usuario));
        $stream->rewind();
        $request = new ServerRequest([], [], null, 'POST', $stream);

        $Usuario2 = Usuario::factory(
            "",
            "teste2",
            "teste@teste.com");
        $stream2 = new Stream('php://memory', 'wb+');
        $stream2->write(json_encode($Usuario2));
        $stream2->rewind();
        $request2 = new ServerRequest([], [], null, 'POST', $stream2);

        $CriarUsuario = new CriarUsuario($this->entityManager);
        $this->assertSame($CriarUsuario($request)->getStatusCode(), 200, 'usuario cadastrado com sucesso');
        $this->assertSame($CriarUsuario($request2)->getStatusCode(), 500, 'ja existe usuario com este email');
    }

}
