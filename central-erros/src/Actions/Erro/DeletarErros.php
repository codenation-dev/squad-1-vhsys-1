<?php


namespace Central\Actions\Erro;


use Central\Actions\ActionBase;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class DeletarErros extends ActionBase
{
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
                $this->remover($Erro);
            }

            if (count($ids_nao_encontrados) > 0) {
                return $response->withStatus(201, 'Os seguintes ids não foram encontrados. '.json_encode($ids_nao_encontrados));
            }
            return $response->withStatus(200, 'Erros excluídos com sucesso');
        }catch (\Throwable $exception){
            return $response->withStatus(500, $exception->getMessage());
        }
    }
}