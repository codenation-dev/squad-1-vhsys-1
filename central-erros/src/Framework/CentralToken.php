<?php


namespace Central\Framework;


use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token;

use function MongoDB\BSON\toJSON;

class CentralToken
{

    public function ObterToken(string $email, string $senha): string
    {
        $key = new Key('olarMundao');
        $signer = new Sha256;
        $token = new Builder();
        $token->expiresAt('+1 year');
        $token->identifiedBy($email.$senha);
        return $token->getToken($signer, $key)->__toString();;
    }
}