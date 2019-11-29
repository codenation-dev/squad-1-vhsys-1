<?php


namespace Central\Actions\Usuario;


use Central\Entity\Usuario;
use Central\Framework\CentralToken;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class AtualizarTokenUsuario
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        try {
            $params = json_decode($request->getBody()->getContents());
            $Usuario = $this->entityManager->getRepository(Usuario::class)->findOneBy(array('email' => $params->email));

            if ($Usuario === null) {
                return $response->withStatus(404, 'usuário não encontrado');
            }

            $Usuario->senha = $params->senha;
            $Usuario->token = CentralToken::obterToken();
            $this->entityManager->persist($Usuario);
            $this->entityManager->flush();

            return $response->withStatus(200, 'token atualziado com sucesso');
        }catch (\Throwable $exception){
            return $response->withStatus(500, $exception->getMessage());
        }
    }
}