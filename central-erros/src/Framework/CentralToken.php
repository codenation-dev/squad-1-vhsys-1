<?php


namespace Central\Framework;

use Central\Entity\Usuario;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

use Zend\Diactoros\Response;
use function MongoDB\BSON\toJSON;

class CentralToken
{
    public static function validarToken(string $token): int
    {
        //$token = $request->getHeaderLine('Authorization');
        $chave = 'Codenation';
        //$chave = 'olarMundao';
        $parser = new Parser();
        $tokenParsed = $parser->parse($token);
        $signer = new Sha256();

        if (!$tokenParsed->verify($signer, $chave)) {
            return 402;
            //return (new Response)->withStatus(402, 'autorização inválida');
        }

        if ($tokenParsed->isExpired()) {
            return 403;
            //return (new Response)->withStatus(402, 'expirado, por favor atualize seu cadastro');
        }

        /*
         * tirar esse trecho daqui e colocar no usuario
         */
        $em = App::getContainer()->get(\Doctrine\ORM\EntityManager::class);
        $Usuario = $em->getRepository(Usuario::class)->findOneBy(array('token' => $token));
        if ($Usuario === null) {
            return 404;
            //return (new Response)->withStatus(404, 'nenhum usuário encontrado');
        }
        return 200;
    }
    public static function obterToken(): string
    {
        $time = time();

        //$key = new Key('olarMundao');
        $key = new Key('Codenation');

        $signer = new Sha256;
        $token = new Builder();
        $token->expiresAt($time + 360000);
        $token->issuedAt($time);
        return $token->getToken($signer, $key)->__toString();;
    }
}