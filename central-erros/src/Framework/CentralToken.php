<?php


namespace Central\Framework;


use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token;

use function MongoDB\BSON\toJSON;

class CentralToken
{

    public function ObterToken(): string
    {

        $time = time();
        $key = new Key('olarMundao');
        $signer = new Sha256;
        $token = new Builder();
        $token->expiresAt('+1 year');
        $token->issuedAt($time);
        return $token->getToken($signer, $key)->__toString();;
    }
}