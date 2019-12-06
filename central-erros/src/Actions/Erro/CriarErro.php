<?php


namespace Central\Actions\Erro;

use Central\Actions\ActionBase;
use Central\Entity\Erro;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class CriarErro extends ActionBase
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        try{
            $data = $request->getBody()->getContents();
            $token = $request->getHeaderLine('Authorization');
            $params = json_decode($data);

            $Erro = new Erro();
            $Erro->token = $token;
            $Erro->titulo = $params->titulo;
            $Erro->nivel = $params->nivel;
            $Erro->ip = $params->ip;
            $Erro->data_hora = $params->data_hora;
            $Erro->origem = $params->origem;
            $Erro->detalhe = $params->detalhe;
            $Erro->ambiente = $params->ambiente;
            $Erro->arquivado = false;

            $this->persistir($Erro);
            return $response->withStatus(200, 'Erro cadastrado!');
        }catch (\Throwable $exception){
            return $response->withStatus(500, $exception->getMessage());
        }
    }
}