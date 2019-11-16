<?php


namespace Central\Actions\Erro;


use Doctrine\ORM\EntityManager;
use Central\Entity\Erro;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;

class AtualizarErro
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

            $Erro = $this->entityManager->find(\Central\Entity\Erro::class, $args['id']);

            if ($Erro === null) {
                return $response->withStatus(404);
            }

            $data = $request->getBody()->getContents();//file_get_contents('php://input');
            $params = json_decode($data);


            $Erro->titulo = $params->titulo;


            $this->entityManager->persist($Erro);
            $this->entityManager->flush();

            return $response->withStatus(204);
        }catch (\Throwable $exception){
            return $response->withStatus(504, $exception->getMessage());
        }
    }
}