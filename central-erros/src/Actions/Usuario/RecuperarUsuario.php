<?php


namespace Central\Actions\Usuario;


use Central\Actions\ActionBase;
use Central\Entity\Usuario;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class RecuperarUsuario extends ActionBase
{
    public function obterUsuario(string $token)
    {
        return $this->entityManager->getRepository(Usuario::class)->findOneBy(array('token' => $token));
    }
    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $Usuario = $this->entityManager->find(Usuario::class, $args['id']);

        $response = new Response();
        $response->getBody()->write(
            json_encode($Usuario)
        );
        return $response->withStatus(200);
    }
}