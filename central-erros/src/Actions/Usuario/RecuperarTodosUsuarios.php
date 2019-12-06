<?php


namespace Central\Actions\Usuario;


use Central\Actions\ActionBase;
use Doctrine\ORM\EntityManager;
use Central\Entity\Usuario;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;

class RecuperarTodosUsuarios extends ActionBase
{

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $query = $this->entityManager->createQueryBuilder();
        $query->select('f')
            ->from(Usuario::class, 'f');

        $response = new Response();
        $response->getBody()->write(
            json_encode($query->getQuery()->getResult())
        );
        return $response->withStatus(200, 'obtemos Usuarios');
    }
}