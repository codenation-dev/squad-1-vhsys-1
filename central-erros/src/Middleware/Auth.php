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

        /*
         * Eu acho que esse tratamento é gambiarrrrrra, verificar melhor forma de tratar requisições que não enviam o tóquem
         */
        if (($request->getUri()->getPath() === "/central/criar_usuario") ||
            ($request->getUri()->getPath() === "/central/atualizar_token_usuario") ||
            ($request->getUri()->getPath() === "/central/usuario/esqueceu_senha") ||
            ($request->getUri()->getPath() === "/central/usuario/login") ||
            ($request->getUri()->getPath() === "/central/")) {
            return $handler->handle($request);
        }

        if (!$request->hasHeader('Authorization')){
            return (new Response)->withStatus(401);
        }
        $token = $request->getHeaderLine('Authorization');
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
        }

        $recuperarUsuario = new RecuperarUsuario(App::getContainer()->get(\Doctrine\ORM\EntityManager::class));
        $Usuario = $recuperarUsuario->obterUsuario($token);
        if ($Usuario === null) {
            return (new Response)->withStatus(404, 'nenhum usuário encontrado');
        }

        return $handler->handle($request);
    }
}