<?php

namespace Central\Actions\Erro;

use Central\Actions\ActionBase;
use Central\Entity\Erro;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class DeletarErro extends ActionBase
{
    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $response = new Response();
        try {
            $Erro = $this->entityManager->find(Erro::class, $args['id']);

            if ($Erro === null) {
                return $response->withStatus(404);
            }
            $this->remover($Erro);

            return $response->withStatus(200, 'Erro excluído com sucesso');
        }catch (\Throwable $exception){
            return $response->withStatus(500, $exception->getMessage());
        }
    }
}