<?php


namespace Central\Middleware;


use Central\Actions\Usuario\RecuperarUsuario;
use Central\Entity\Usuario;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
use \Central\Framework\App;
use Central\Framework\CentralToken;

class Auth implements  MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // TODO: Implement process() method.
        $token = "";

        if ($request->getUri()->getPath() === "/central/usuario/login") {

            $params = json_decode($request->getBody()->getContents());

            $recuperarUsuario = new RecuperarUsuario(App::getContainer()->get(\Doctrine\ORM\EntityManager::class));
            $Usuario = $recuperarUsuario->login(
                $params->email,
                $params->senha);

            if ($Usuario === null) {
                return (new Response)->withStatus(401);
            }
            $token = $Usuario->token;
        } else if ($request->getUri()->getPath() === "/central/usuario/esqueceu_senha") {

            $params = json_decode($request->getBody()->getContents());

            $em = App::getContainer()->get(\Doctrine\ORM\EntityManager::class);
            $Usuario = $em->getRepository(Usuario::class)->findOneBy(
                array('email' => $params->email
                )
            );

            if ($Usuario === null) {
                return (new Response)->withStatus(401);
            }
            $token = $Usuario->token;

        } else if (strpos($request->getUri()->getPath(), "/central/recovery") > -1) {

            $queryParams = $request->getQueryParams();
            $token = $queryParams['token'];

            if ($token === "") {
                return (new Response)->withStatus(401);
            }

        } else {
            if (!$request->hasHeader('Authorization')){
                return (new Response)->withStatus(401);
            }
            $token = $request->getHeaderLine('Authorization');
        }


        $ret = CentralToken::validarToken($token);
        switch ($ret) {
            case 402:
                return (new Response)->withStatus(402, 'autorização inválida');
                break;
            case 403:
                return (new Response)->withStatus(403, 'expirado, por favor atualize seu cadastro');
                break;
            case 404:
                return (new Response)->withStatus(404, 'nenhum usuário encontrado');
                break;
            case 500:
                return (new Response)->withStatus(500, 'token inválido');
                break;
        }

        return $handler->handle($request);
    }
}