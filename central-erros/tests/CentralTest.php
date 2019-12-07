<?php

namespace Teste;

use Central\Actions\Erro\ArquivarErro;
use Central\Actions\Erro\CriarErro;
use Central\Actions\Erro\DeletarErros;
use Central\Actions\Erro\RecuperarErros;
use Central\Actions\Erro\RecuperarTodosErros;
use Central\Actions\Usuario\CriarUsuario;
use Central\Actions\Usuario\EsqueceuSenha;
use Central\Actions\Usuario\Login;
use Central\Actions\Usuario\RecuperarUsuario;
use Central\Entity\Erro;
use Central\Entity\Usuario;
use Central\Framework\CentralToken;
use Central\Middleware\Auth;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Stream;

class CentralTest extends TestCase
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

    public function test_Login()
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

        $senhaMd5 = md5("teste");
        $email = "teste@teste.com";
        $Usuario2 = Usuario::factory(
            "",
            "teste",
            $email);
        $stream2 = new Stream('php://memory', 'wb+');
        $stream2->write(json_encode($Usuario2));
        $stream2->rewind();
        $request2 = new ServerRequest([], [], null, 'POST', $stream2);
        $Login = new Login($this->entityManager);
        $response = $Login($request2);
        $u = json_decode($response->getBody());

        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame($u->email, $email);
        $this->assertSame($u->senha, $senhaMd5);
        $this->assertNotEmpty($u->token);
    }

    public function test_EsqueceuSenha()
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

        $Usuario2 = Usuario::factory(
            "",
            "teste2",
            "teste@teste.com");
        $stream2 = new Stream('php://memory', 'wb+');
        $stream2->write(json_encode($Usuario2));
        $stream2->rewind();
        $request2 = new ServerRequest([], [], null, 'POST', $stream2);
        $EsqueceuSenha = new EsqueceuSenha($this->entityManager);
        $response = $EsqueceuSenha($request2);
        $this->assertSame($response->getStatusCode(), 200);
        $token_validar = $response->getReasonPhrase();

        $ret = CentralToken::validarToken($token_validar);
        $this->assertSame($ret, 200);

        $recuperarUsuario = new RecuperarUsuario($this->entityManager);
        $Usuario = $recuperarUsuario->obterUsuario($token_validar);
        $this->assertNotNull($Usuario);
        $this->assertSame($Usuario->email, "teste@teste.com");
    }

    public function test_CriarErro()
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

        $erroCadastrado = $this->entityManager->find(Erro::class, 1);

        $this->assertSame($erroCadastrado->token, $token);
        $this->assertSame($erroCadastrado->titulo, "PHP Fatal error:  Uncaught");
        $this->assertSame($erroCadastrado->nivel, "error");
        $this->assertSame($erroCadastrado->ip, "127.0.0.1");
        $this->assertSame($erroCadastrado->data_hora, "05/12/2019 19:47:57");
        $this->assertSame($erroCadastrado->origem, "origem");
        $this->assertSame($erroCadastrado->detalhe, "Function name must be a string in C:/xampp/htdocs/semana_2/index.php:12 Stack trace:   {main}   thrown in C:/xampp/htdocs/semana_2/index.php on line 12");
        $this->assertSame($erroCadastrado->ambiente, "dev");
        $this->assertSame($erroCadastrado->arquivado, false);;
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

    public function test_ApagarErro()
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

        $DeletarErro = new DeletarErros($this->entityManager);
        $this->assertSame($DeletarErro($request2)->getStatusCode(), 200, 'Erros excluídos com sucesso');

        $erroCadastrado = $this->entityManager->find(Erro::class, 1);
        $this->assertNull($erroCadastrado);
    }

    public function test_FiltrarErro()
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

        $recurso = [
            'buscarPor' => '',
            'valor' => '',
            'ordenarPor' => ''];

        $stream2 = new Stream('php://memory', 'wb+');
        $stream2->write(json_encode($recurso));
        $stream2->rewind();
        $request2 = new ServerRequest([], [], null, 'POST', $stream2);

        $RecuperarErros = new RecuperarErros($this->entityManager);
        $this->assertSame($RecuperarErros($request2)->getStatusCode(), 200);

        $recurso2 = [
            'buscarPor' => 'nivel',
            'valor' => 'error',
            'ordenarPor' => ''];
        $stream3 = new Stream('php://memory', 'wb+');
        $stream3->write(json_encode($recurso));
        $stream3->rewind();
        $request3 = new ServerRequest([], [], null, 'POST', $stream3);
        $this->assertSame($RecuperarErros($request3)->getStatusCode(), 200);
    }

    public function test_ObterErros()
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
        $stream->rewind();
        $this->assertSame($CriarErro($request)->getStatusCode(), 200, 'Erro cadastrado!');
        $stream->rewind();
        $this->assertSame($CriarErro($request)->getStatusCode(), 200, 'Erro cadastrado!');

        $RecuperarTodosErros = new RecuperarTodosErros($this->entityManager);
        $this->assertSame($RecuperarTodosErros($request)->getStatusCode(), 200, 'Erros obtidos!');
    }
}
