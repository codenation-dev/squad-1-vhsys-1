<?php


namespace Central\Actions\Erro;


use Central\Entity\Erro;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class RecuperarErros
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $response = new Response();
        try {
            $tokenUsuario = $request->getHeaderLine('Authorization');
            $buscarPor = $args['buscarPor'];
            $valor = $args['valor'];
            $ordenarPor = $args['ordenarPor'];

            $query = $this->entityManager->createQueryBuilder();



            /*
            if ($ordenarPor !== "ordenarPor") {
                if ($ordenarPor == "nivel") {
                    $query->select('e.codigo,e.nivel,e.ip,e.data_hora,e.titulo,e.detalhe,e.status,e.ambiente,e.origem,e.token');

                } else {
                    $query->select('e.codigo,e.nivel,e.ip,e.data_hora,e.titulo,e.detalhe,e.status,e.ambiente,e.origem,e.token, count(e.id) as frequencia');
                }
            } else {
                $query->select('e.codigo,e.nivel,e.ip,e.data_hora,e.titulo,e.detalhe,e.status,e.ambiente,e.origem,e.token');
            }
            */
            $query->select('e.codigo,e.nivel,e.ip,e.data_hora,e.titulo,e.detalhe,e.status,e.ambiente,e.origem,e.token, count(e.id) as frequencia')
                  ->from(Erro::class, 'e')
                  ->where('e.token = :token')
                  ->setParameter('token', $tokenUsuario)
                  ->andWhere("e.arquivado = :arquivado")
                  ->setParameter('arquivado', false);

            //haduken!!! dois if's aninhados
            if ($buscarPor !== "buscarPor") {
                if ($valor === "") {
                    return $response->withStatus(500, "valor não pode estar em branco para este tipo de pesquisa.");
                }

                $query->andWhere("e.$buscarPor = :buscarPor")
                    ->setParameter('buscarPor', $valor);
            }

            $query->groupby('e.codigo,e.nivel,e.ip,e.data_hora,e.titulo,e.detalhe,e.status,e.ambiente,e.origem,e.token');


            if ($ordenarPor !== "ordenarPor") {
                if ($ordenarPor == "nivel") {
                    $query->orderBy("e.$ordenarPor", 'ASC');
                } else {
                    $query->orderBy("$ordenarPor", 'DESC');
                }
            }

            //
            // ->setMaxResults( 4 );

            $response->getBody()->write(
                json_encode($query->getQuery()->getResult())
            );
            return $response->withStatus(200, 'Erros obtidos!');
        }catch (\Throwable $exception){
            return $response->withStatus(500, $exception->getMessage());
        }
    }
}