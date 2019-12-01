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
    private $entityManager;
    private $usuarioDAO;


    public function __construct(EntityManager $entityManager, UsuarioDAO $usuarioDAO)
    {
        $this->entityManager = $entityManager;
        $this->usuarioDAO = $usuarioDAO;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $result = $this->usuarioDAO->recuperarTodosUsuarios();
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