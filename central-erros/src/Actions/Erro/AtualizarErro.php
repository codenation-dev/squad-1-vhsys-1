<?php


namespace Central\Actions\Erro;


use Central\Actions\ActionBase;
use Doctrine\ORM\EntityManager;
use Central\Entity\Erro;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;

class AtualizarErro extends ActionBase
{
    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $response = new Response();
        try {

            $Erro = $this->entityManager->find(\Central\Entity\Erro::class, $args['id']);

            if ($Erro === null) {
                return $response->withStatus(404);
            }

            $data = $request->getBody()->getContents();
            $params = json_decode($data);

            $this->persistir($Erro);

            return $response->withStatus(204);
        }catch (\Throwable $exception){
            return $response->withStatus(504, $exception->getMessage());
        }
    }
}