<?php


namespace Central\Actions\Erro;


use Central\Actions\ActionBase;
use Central\Entity\Erro;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class RecuperarErros extends ActionBase
{
    public function __invoke(ServerRequestInterface $request/*, array $args*/): ResponseInterface
    {
        $response = new Response();
        try {
            $tokenUsuario = $request->getHeaderLine('Authorization');

            $params = json_decode($request->getBody()->getContents());

            $ambiente = $params->ambiente;
            $buscarPor = $params->buscarPor;
            $valor = $params->valor;
            $ordenarPor = $params->ordenarPor;
            $ascDesc = strtoupper($params->ascDesc);
            $arquivados = $params->arquivados;

            $query = $this->entityManager->createQueryBuilder();
            $query->select('e.titulo,e.nivel,e.ip,e.data_hora,e.origem,e.detalhe,e.token,e.ambiente,e.arquivado,e.id')
                  ->addSelect('(select count(ee.id) as qnt from Central\Entity\Erro ee where e.titulo = ee.titulo and e.nivel = ee.nivel and e.detalhe = ee.detalhe and e.token = ee.token and e.ambiente = ee.ambiente and e.arquivado = ee.arquivado) as frequencia')
                  ->from(Erro::class, 'e')
                  ->where('e.token = :token')
                  ->setParameter('token', $tokenUsuario)
                  ->andWhere("e.arquivado = :arquivado")
                  ->setParameter('arquivado', $arquivados);


            if ($ambiente !== "") {
                $query->andWhere("e.ambiente = :ambiente")
                      ->setParameter('ambiente', $ambiente);
            }

            if ($buscarPor !== "") {
                if ($valor === "") {
                    return $response->withStatus(500, "valor não pode estar em branco para este tipo de pesquisa.");
                }
                $query->andWhere("e.$buscarPor LIKE :buscarPor")
                    ->setParameter('buscarPor', '%'.$valor.'%');
            }

            if ($ordenarPor !== "") {
                $campo = $ordenarPor;
                if ($ordenarPor === "nivel") {
                    $campo = "e.$ordenarPor";
                }
                $query->orderBy($campo, $ascDesc);
            }

            $response->getBody()->write(
                json_encode($query->getQuery()->getResult())
            );
            return $response->withStatus(200, 'Erros obtidos!');
        }catch (\Throwable $exception){
            return $response->withStatus(500, $exception->getMessage());
        }
    }
}