<?php


namespace Central\Actions\Usuario;

use Central\Framework\CentralToken;
use Doctrine\ORM\EntityManager;
use Central\Entity\Usuario;
use Lcobucci\JWT\Parser;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Request;

class CriarUsuario
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
            $data = $request->getBody()->getContents(); //file_get_contents('php://memory'); //$request->getBody();//
            $params = json_decode($data);

            $Usuario = new Usuario();

            $centralToken = new CentralToken();

            $Usuario->email = $params->email;
            $Usuario->senha = $params->senha;
            $Usuario->token = $centralToken->ObterToken();;

            //dd($params, $Usuario);

            $this->entityManager->persist($Usuario);
            $this->entityManager->flush();

            //dd($params, $Usuario);

            return $response->withStatus(207, 'erro cadastrado com sucesso');
        }catch (\Throwable $exception){
            return $response->withStatus(501, $exception->getMessage());
        }
    }
}