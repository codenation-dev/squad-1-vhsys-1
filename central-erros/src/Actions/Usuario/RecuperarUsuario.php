<?php


namespace Central\Actions\Usuario;


use Doctrine\ORM\EntityManager;
use Central\Entity\Usuario;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;

class RecuperarUsuario
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
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