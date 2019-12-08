<?php

namespace Test;

use Central\Actions\Erro\ArquivarErro;
use Central\Actions\Erro\CriarErro;
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

class ArquivarErroTest extends TestCase
{

    /** @var \Doctrine\ORM\EntityManager */
    private $entityManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->entityManager = EntityManager::create(
            DriverManager::getConnection(['url' => 'sqlite:///:memory:']),
            Setup::createAnnotationMetadataConfiguration(
                array(__DIR__ . '/../../src/Entity'),
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


    public function test_ArquivarErro()
    {

        $token = CentralToken::obterToken();

        $Erro = new Erro();
        $Erro->token = $token;
        $Erro->titulo = "PHP Fatal error:  Uncaught";
        $Erro->nivel = "error";
        $Erro->ip = "127.0.0.1";
        $Erro->data_hora = "05/12/2019 19:47:57";
        $Erro->origem = "origem";
        $Erro->detalhe = "Function name must be a string in C:\\xampp\\htdocs\\semana_2\\index.php:12\nStack trace:\n#0 {main}\n  thrown in C:\\xampp\\htdocs\\semana_2\\index.php on line 12";
        $Erro->ambiente = "dev";
        $Erro->arquivado = false;

        $stream = new Stream('php://memory', 'wb+');
        $stream->write(json_encode($Erro));
        $stream->rewind();

        $request = new ServerRequest([], [], null, 'POST', $stream, ['Authorization' => $token]);

        $CriarErro = new CriarErro($this->entityManager);
        $this->assertSame($CriarErro($request)->getStatusCode(), 200, 'Erro cadastrado!');

        $recurso = [['id' => 1]];


        $stream2 = new Stream('php://memory', 'wb+');
        $stream2->write(json_encode($recurso));
        $stream2->rewind();
        $request2 = new ServerRequest([], [], null, 'PUT', $stream2);

        $ArquivarErro = new ArquivarErro($this->entityManager);
        $this->assertSame($ArquivarErro($request2)->getStatusCode(), 200, 'Erro arquivado com sucesso.');

        $erroCadastrado = $this->entityManager->find(Erro::class, 1);

        $this->assertSame($erroCadastrado->token, $token);
        $this->assertSame($erroCadastrado->titulo, "PHP Fatal error:  Uncaught");
        $this->assertSame($erroCadastrado->nivel, "error");
        $this->assertSame($erroCadastrado->ip, "127.0.0.1");
        $this->assertSame($erroCadastrado->data_hora, "05/12/2019 19:47:57");
        $this->assertSame($erroCadastrado->origem, "origem");
        $this->assertSame($erroCadastrado->detalhe, "Function name must be a string in C:/xampp/htdocs/semana_2/index.php:12 Stack trace:   {main}   thrown in C:/xampp/htdocs/semana_2/index.php on line 12");
        $this->assertSame($erroCadastrado->ambiente, "dev");
        $this->assertSame($erroCadastrado->arquivado, true);;
    }
}
