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
                $response->getBody()->write("email em branco");
                return $response->withStatus(500);
            }
            if ($params->senha == "") {
                $response->getBody()->write("senha em branco");
                return $response->withStatus(500);
            }

            $Usuario = $this->entityManager->getRepository(Usuario::class)->findOneBy(
                array('email' => $params->email,
                      'senha' =>  md5($params->senha)
                )
            );

            if ($Usuario === null) {
                $response->getBody()->write("usuario nao existe, verifique email e/ou senha");
                return $response->withStatus(500);
            }

            $response->getBody()->write(json_encode($Usuario));
            return $response->withStatus(200);
        }catch (\Throwable $exception){
            return $response->withStatus(508, $exception->getMessage());
        }
    }
}