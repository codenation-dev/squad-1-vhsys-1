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

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $ids_nao_encontrados = [];
        $response = new Response();
        try {
            $data = $request->getBody()->getContents();
            $params = json_decode($data);

            foreach ($params as $id) {
                $Erro = $this->entityManager->find(\Central\Entity\Erro::class, $id->id);
                if ($Erro === null) {
                    array_push($ids_nao_encontrados, $id->id);
                    continue;
                }
                $Erro->arquivado = true;
                $this->entityManager->persist($Erro);
                $this->entityManager->flush();
            }

            if (count($ids_nao_encontrados) > 0) {
                return $response->withStatus(201, 'Os seguintes ids não foram encontrados. '.json_encode($ids_nao_encontrados));
            }
            return $response->withStatus(200, 'Erro arquivado com sucesso.');
        }catch (\Throwable $exception){
            return $response->withStatus(500, $exception->getMessage());
        }
    }
}