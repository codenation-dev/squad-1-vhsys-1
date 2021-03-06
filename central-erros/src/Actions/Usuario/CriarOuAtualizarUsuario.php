<?php


namespace Central\Actions\Usuario;


use Central\Actions\ActionBase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Central\Entity\Usuario;

class CriarOuAtualizarUsuario extends ActionBase
{
    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $response = new Response();
        try {
            $Usuario = $this->entityManager->find(Usuario::class, $args['id']);

            $data = $request->getBody()->getContents();
            $params = json_decode($data);

            $Usuario->titulo = $params->titulo;
            $this->entityManager->persist($Usuario);
            $this->entityManager->flush();

            return $response->withStatus(204);
        }catch (\Throwable $exception){
            return $response->withStatus(204, $exception->getMessage());
        }

    }
}