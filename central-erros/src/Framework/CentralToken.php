<?php


namespace Central\Framework;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

use function MongoDB\BSON\toJSON;

class CentralToken
{
    public static function obterToken(): string
    {
        $time = time();
        //$key = new Key('olarMundao');
        $key = new Key('Codenation');
        $signer = new Sha256;
        $token = new Builder();
        $token->expiresAt('+1 year');
        $token->issuedAt($time);
        return $token->getToken($signer, $key)->__toString();;
    }
}