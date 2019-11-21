<?php


namespace Central\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;

class Auth implements  MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // TODO: Implement process() method.

        /*
         * Eu acho que esse tratamento é gambiarrrrrra, verificar melhor forma de tratar requisições que não enviam o tóquem
         */
        if (($request->getUri()->getPath() === "/central/criar_usuario") ||
            ($request->getUri()->getPath() === "/central/usuario/esqueceu_senha") ||
            ($request->getUri()->getPath() === "/central/usuario/login") ||
            ($request->getUri()->getPath() === "/central/")) {
            return $handler->handle($request);
        }

        if (!$request->hasHeader('Authorization')){
            return (new Response)->withStatus(401);
        }

        $token = $request->getHeaderLine('Authorization');
        $chave = 'Codenation';
        //$chave = 'olarMundao';
        $parser = new Parser();
        $tokenParsed = $parser->parse($token);
        $signer = new Sha256();

        if (!$tokenParsed->verify($signer, $chave)) {
            return (new Response)->withStatus(403, 'não verificado');
        }

        if ($tokenParsed->isExpired()) {
            return (new Response)->withStatus(403, 'expirrado');
        }

        return $handler->handle($request);
    }
}