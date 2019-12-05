<?php


namespace Central\Actions\Erro;


use Central\Actions\ActionBase;
use Central\Entity\Erro;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class RecuperarErros extends ActionBase
{
    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $response = new Response();
        try {
            $tokenUsuario = $request->getHeaderLine('Authorization');
            $buscarPor = $args['buscarPor'];
            $valor = $args['valor'];
            $ordenarPor = $args['ordenarPor'];

            $query = $this->entityManager->createQueryBuilder();

            //$query->select('e.codigo,e.arquivado,e.nivel,e.ip,e.data_hora,e.titulo,e.detalhe,e.status,e.ambiente,e.origem,e.token, count(e.id) as frequencia')
            //$query->select('e.titulo,e.nivel,e.ip,e.data_hora,e.origem,e.detalhe,e.token,e.ambiente,e.arquivado, count(e.id) as frequencia')
            $query->select('e.titulo,e.nivel,e.ip,e.data_hora,e.origem,e.detalhe,e.token,e.ambiente,e.arquivado,e.id')
                  ->addSelect('(select count(ee.id) as qnt from Central\Entity\Erro ee where e.titulo = ee.titulo and e.nivel = ee.nivel and e.ip = ee.ip and e.data_hora = ee.data_hora and e.origem = ee.origem and e.detalhe = ee.detalhe and e.token = ee.token and e.ambiente = ee.ambiente and e.arquivado = ee.arquivado) as frequencia')
                  ->from(Erro::class, 'e')
                  ->where('e.token = :token')
                  ->setParameter('token', $tokenUsuario)
                  ->andWhere("e.arquivado = :arquivado")
                  ->setParameter('arquivado', false);

            if ($buscarPor !== "buscarPor") {
                if ($valor === "valor") {
                    return $response->withStatus(500, "valor não pode estar em branco para este tipo de pesquisa.");
                }
                $query->andWhere("e.$buscarPor LIKE :buscarPor")
                      ->setParameter('buscarPor', '%'.$valor.'%');
            }

            //$query->groupby('e.codigo,e.nivel,e.ip,e.data_hora,e.titulo,e.detalhe,e.status,e.ambiente,e.origem,e.token');
            //$query->groupby('e.titulo,e.nivel,e.ip,e.data_hora,e.origem,e.detalhe,e.token,e.ambiente,e.arquivado');
            if ($ordenarPor !== "ordenarPor") {
                if ($ordenarPor == "nivel") {
                    $query->orderBy("e.$ordenarPor", 'ASC');
                } else {
                   // $query->orderBy("$ordenarPor", 'DESC');
                }
            }

            //dd($query->getQuery());
            $response->getBody()->write(
                json_encode($query->getQuery()->getResult())
            );
            return $response->withStatus(200, 'Erros obtidos!');
        }catch (\Throwable $exception){
            return $response->withStatus(500, $exception->getMessage());
        }
    }
}