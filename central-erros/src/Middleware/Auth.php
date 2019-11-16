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
        //dd($request->getUri()->getPath()); die;

        if ($request->getUri()->getPath() === "/central/criar_usuario") {
            return $handler->handle($request);
        }
        //return $handler->handle($request);

        if (!$request->hasHeader('Authorization')){
            return (new Response)->withStatus(401);
        }

        $token = $request->getHeaderLine('Authorization');
        $chave = 'Codenation';
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
        /*
        dd(
            $tokenParsed->verify($signer, $chave),
            $tokenParsed->isExpired()
        );

        die;

        if ($token !== 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.p2lc_NG5Xay_w5gny0zQgUZz3c3Bx_Zb7d2_sUPPs84'){
            return (new Response)->withStatus(403);
        }

        return new RedirectResponse($request->getUri());

        return $handler->handle($request);*/

        /*
        $auth = $request->getHeader('Authorization');

        if ($auth == null) {
            / *
            $response = new Response();
            return $response->withStatus(401, 'sem cabeçalhudo');
            * /
            return new RedirectResponse($request->getUri());
        }

        $token = (new Parser())->parse((string) $auth[0]); // Parses from a string
        $token->getHeaders(); // Retrieves the token header
        $token->getClaims(); // Retrieves the token claims

        if ($token->isExpired()) {
            $response = new Response();
            return $response->withStatus(403, 'tá expiradão');
        } 

        //return $response;
        return new RedirectResponse($request->getUri());
        */
    }
}