<?php


namespace Central\Actions\Usuario;


use Central\Actions\ActionBase;
use Central\Entity\Usuario;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class DeletarUsuario extends ActionBase
{
    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $response = new Response();
        try {
            $Usuario = $this->entityManager->find(Usuario::class, $args['id']);

            if ($Usuario === null) {
                return $response->withStatus(404);
            }
            $this->remover($Usuario);

            return $response->withStatus(204);
        }catch (\Throwable $exception){
            return $response->withStatus(504, $exception->getMessage());
        }
    }
}