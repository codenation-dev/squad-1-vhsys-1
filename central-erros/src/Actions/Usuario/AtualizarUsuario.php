<?php


namespace Central\Actions\Usuario;


use Doctrine\ORM\EntityManager;
use Central\Entity\Usuario;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;

class AtualizarUsuario
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
            $Usuario = $this->entityManager->find(\Central\Entity\Usuario::class, $args['id']);

            if ($Usuario === null) {
                return $response->withStatus(404, 'usu�rio n�o encontrado');
            }

            $data = $request->getBody()->getContents();
            $params = json_decode($data);
            $Usuario->email = $params->email;
            $this->entityManager->persist($Usuario);
            $this->entityManager->flush();

            return $response->withStatus(204);
        }catch (\Throwable $exception){
            return $response->withStatus(504, $exception->getMessage());
        }
    }
}