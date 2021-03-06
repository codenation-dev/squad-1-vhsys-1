<?php


namespace Central\Actions\Erro;


use Central\Actions\ActionBase;
use Central\Entity\Erro;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class ArquivarErro extends ActionBase
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $ids_nao_encontrados = [];
        $response = new Response();
        try {
            $data = $request->getBody()->getContents();
            $params = json_decode($data);

            foreach ($params as $id) {
                $Erro = $this->entityManager->find(Erro::class, $id->id);

                if ($Erro === null) {
                    array_push($ids_nao_encontrados, $id->id);
                    continue;
                }
                $Erro->arquivado = true;
                $this->persistir($Erro);
            }

            if (count($ids_nao_encontrados) > 0) {
                $response->getBody()->write('Os seguintes ids não foram encontrados. '.json_encode($ids_nao_encontrados));
            } else {
                $response->getBody()->write('Erros arquivados com sucesso.');
            }

            return $response->withStatus(200);
        }catch (\Throwable $exception){
            return $response->withStatus(500, $exception->getMessage());
        }
    }
}