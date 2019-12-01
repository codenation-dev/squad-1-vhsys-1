<?php


namespace Central\Actions\Erro;


use Central\Actions\ActionBase;
use Central\Entity\Erro;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class RecuperarTodosErros extends ActionBase
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        try {
            $tokenUsuario = $request->getHeaderLine('Authorization');
        	$query = $this->entityManager->createQueryBuilder();
            $query->select('f')
                ->from(Erro::class, 'f')
                ->where('f.token = :token')
                ->setParameter('token', $tokenUsuario)
                ->andWhere("f.arquivado = :arquivado")
                ->setParameter('arquivado', false);

            $response->getBody()->write(
                json_encode($query->getQuery()->getResult())
            );
            return $response->withStatus(200, 'Erros obtidos!');
        }catch (\Throwable $exception){
            return $response->withStatus(508, $exception->getMessage());
        }
    }
}