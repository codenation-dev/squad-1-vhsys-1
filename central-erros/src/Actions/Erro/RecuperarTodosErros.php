<?php


namespace Central\Actions\Erro;


use Doctrine\ORM\EntityManager;
use Central\Entity\Erro;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;

class RecuperarTodosErros
{
    //private $entityManager;


    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $query = $this->entityManager->createQueryBuilder();
        $query->select('f')
            ->from(Erro::class, 'f');

        $response = new Response();
        $response->getBody()->write(
            json_encode($query->getQuery()->getResult())
        );
        return $response->withStatus(200, 'obtemos Erros');
    }
}