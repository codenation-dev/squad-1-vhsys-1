<?php


namespace Central\Actions\Erro;


use Central\Entity\Erro;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class ArquivarErro
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
                return $response->withStatus(404, 'Registro não encontrado');
            }

            $Erro->arquivado = true;

            $this->entityManager->persist($Erro);
            $this->entityManager->flush();

            return $response->withStatus(200, 'Erro arquivado com sucesso.');
        }catch (\Throwable $exception){
            return $response->withStatus(500, $exception->getMessage());
        }
    }
}