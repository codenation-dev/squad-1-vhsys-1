<?php


namespace Central\Actions\Usuario;

use Central\Framework\CentralToken;
use Doctrine\ORM\EntityManager;
use Central\Entity\Usuario;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class CriarUsuario
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function existeUsuario(string $emails): bool
    {
        $u = $this->entityManager->getRepository(Usuario::class)->findOneBy(array('email' => $emails));
        return ($u !== null);
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        try{
            $params = json_decode($request->getBody()->getContents());

            if ($params->email == "") {
                return $response->withStatus(500, "email em branco");
            }

            if ($params->senha == "") {
                return $response->withStatus(500, "senha em branco");
            }

            if ($this->existeUsuario($params->email)) {
                return $response->withStatus(500, "ja existe usuario com este email");
            }

            $Usuario = Usuario::factory(
                CentralToken::obterToken(),
                $params->senha,
                $params->email);

            $this->entityManager->persist($Usuario);
            $this->entityManager->flush();

            return $response->withStatus(201, 'usuario cadastrado com sucesso');
        }catch (\Throwable $exception){
            return $response->withStatus(501, "falha ao cadastrar usuario. $exception->getMessage()");
        }
    }
}