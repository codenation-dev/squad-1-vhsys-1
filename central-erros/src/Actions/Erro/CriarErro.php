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

            $origem_formatada = str_replace("\\", "/", $params->origem);
            $origem_formatada = str_replace("\n", " ", $origem_formatada);
            $origem_formatada = str_replace("\r", " ", $origem_formatada);
            $origem_formatada = str_replace("#0", " ", $origem_formatada);
            $origem_formatada = str_replace("'", " ", $origem_formatada);

            $Erro->origem = $origem_formatada;

            $detalhe_formatado = str_replace("\n", " ", $params->detalhe);
            $detalhe_formatado = str_replace("#0", " ", $detalhe_formatado);
            $detalhe_formatado = str_replace("\r", " ", $detalhe_formatado);
            $detalhe_formatado = str_replace("\\", "/", $detalhe_formatado);
            $detalhe_formatado = str_replace("'", "", $detalhe_formatado);

            $Erro->detalhe = $detalhe_formatado;
            $Erro->ambiente = $params->ambiente;
            $Erro->arquivado = false;

            $this->persistir($Erro);

            $response->getBody()->write('Erro cadastrado!');
            return $response->withStatus(200);
        }catch (\Throwable $exception){
            return $response->withStatus(500, $exception->getMessage());
        }
    }
}