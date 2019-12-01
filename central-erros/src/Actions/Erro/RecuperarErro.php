<?php


namespace Central\Actions\Erro;


use Central\Actions\ActionBase;
use Central\Entity\Erro;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class RecuperarErro extends ActionBase
{
    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $Erro = $this->entityManager->find(Erro::class, $args['id']);

        $response = new Response();
        $response->getBody()->write(
            json_encode($Erro)
        );
        return $response->withStatus(200, 'Erro obtido!');
    }
}