<?php


namespace Central\Actions\Erro;

use Central\Actions\ActionBase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Central\Entity\Erro;

class CriarOuAtualizarErro extends ActionBase
{
    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $response = new Response();
        try {
            $Erro = $this->entityManager->find(Erro::class, $args['id']);

            $data = $request->getBody()->getContents();//file_get_contents('php://input');
            $params = json_decode($data);

            //$Erro->titulo = $params->titulo;
            $this->persistir($Erro);

            return $response->withStatus(204);
        }catch (\Throwable $exception){
            return $response->withStatus(204, $exception->getMessage());
        }

    }
}