<?php


namespace Central\Actions\Erro;

use Doctrine\ORM\EntityManager;
use Central\Entity\Erro;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Request;

class CriarErro
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        try{
            $data = $request->getBody()->getContents();
            $token = $request->getHeaderLine('Authorization');
            $params = json_decode($data);

            $Erro = new Erro();
            $Erro->codigo = $params->codigo;
            $Erro->nivel = $params->nivel;
            $Erro->token = $token;
            $Erro->ip = $params->ip;
            $Erro->data_hora = $params->data_hora;
            $Erro->titulo = $params->titulo;
            $Erro->detalhe = $params->detalhe;
            $Erro->status = $params->status;
            $Erro->ambiente = $params->ambiente;
            $Erro->origem = $params->origem;

            $this->entityManager->persist($Erro);
            $this->entityManager->flush();

            return $response->withStatus(201, 'Erro cadastrado!');
        }catch (\Throwable $exception){
            return $response->withStatus(501, $exception->getMessage());
        }
    }
}