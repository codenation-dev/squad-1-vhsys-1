<?php


namespace Central\Actions\Usuario;


use Central\Actions\ActionBase;
use Central\Entity\Usuario;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class EsqueceuSenha extends ActionBase
{
    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $response = new Response();
        try {
            $params = json_decode($request->getBody()->getContents());

            if ($params->email == "") {
                return $response->withStatus(500, "email em branco" + $params->email);
            }

            $Usuario = $this->entityManager->getRepository(Usuario::class)->findOneBy(array('email' => $params->email));

            if ($Usuario === null) {
                return $response->withStatus(500, "usuario nao existe");
            }

            return $response->withStatus(200, $Usuario->getSenha());
        }catch (\Throwable $exception){
            return $response->withStatus(508, $exception->getMessage());
        }
    }
}