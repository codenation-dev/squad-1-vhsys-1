<?php


namespace Central\Actions\Usuario;

use Central\Actions\ActionBase;
use Central\Entity\Usuario;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class Login extends ActionBase
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        try {
            $params = json_decode($request->getBody()->getContents());

            if ($params->email == "") {
                return $response->withStatus(500, "email em branco" + $params->email);
            }
            if ($params->senha == "") {
                return $response->withStatus(500, "senha em branco" + $params->senha);
            }

            $Usuario = $this->entityManager->getRepository(Usuario::class)->findOneBy(
                array('email' => $params->email,
                      'senha' =>  md5($params->senha)));

            if ($Usuario === null) {
                return $response->withStatus(500, "usuario nao existe, verifique email e/ou senha");
            }

            $response->getBody()->write(json_encode($Usuario));
            return $response->withStatus(200);
        }catch (\Throwable $exception){
            return $response->withStatus(508, $exception->getMessage());
        }
    }
}