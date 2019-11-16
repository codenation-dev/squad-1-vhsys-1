<?php


namespace Central\Actions\Usuario;


use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;
use Central\Entity\Usuario;

class CriarOuAtualizarUsuario
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {

        $response = new Response();
        try {
            $Usuario = $this->entityManager->find(Usuario::class, $args['id']);

            $data = $request->getBody()->getContents();//file_get_contents('php://input');
            $params = json_decode($data);

            $Usuario->titulo = $params->titulo;
            $this->entityManager->persist($Usuario);
            $this->entityManager->flush();

            return $response->withStatus(204);
        }catch (\Throwable $exception){
            return $response->withStatus(204, $exception->getMessage());
        }

    }
}