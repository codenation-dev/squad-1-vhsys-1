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

            $buscarPor = $args['buscarPor'];
            $valor = $args['valor'];
            $ordenarPor = $args['ordenarPor'];

            //return $response->withStatus(500, "$buscarPor - $valor - $ordenarPor");
            //return $response->withStatus(500, $buscarPor + ' - ' +$valor+ ' - ' +$ordenarPor);

            $query = $this->entityManager->createQueryBuilder();
            $query->select('e')
                ->from(Erro::class, 'e');

            //haduken!!! dois if's aninhados
            if ($buscarPor !== "buscarPor") {
                if ($valor === "") {
                    return $response->withStatus(500, "valor não pode estar em branco para este tipo de pesquisa.");
                }

                if ($buscarPor == "level") {
                    $campoBuscar = "nivel";
                } else {
                    $campoBuscar = $buscarPor;
                }

                $query->where("e.$campoBuscar = :buscarPor")
                    ->setParameter('buscarPor', $valor);

            }

            if ($ordenarPor !== "ordenarPor") {
                //$query->orderBy('e.'+$ordenarPor, 'ASC');
                return $response->withStatus(500, "Ordenar Por não implementado ainda.");
            }
            //return $response->withStatus(500, "aaaaaaaaaaaaaaa");
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