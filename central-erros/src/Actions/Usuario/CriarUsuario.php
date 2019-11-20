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

    public function existeUsuario(string $emails): bool
    {

        $u = $this->entityManager->getRepository(Usuario::class)->findOneBy(array('email' => $emails));
        return ($u !== null);

        /*$qb = $this->em->createQueryBuilder();
        $qb->select('u.id ')
            ->from(Usuario::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $usuario->email)
            ->setMaxResults(1);
        return ($qb->getQuery()->getResult()->;*/
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
            /*
            */
            $Usuario = Usuario::factory(
                CentralToken::obterToken(),
                $params->email,
                $params->email);

            $this->entityManager->persist($Usuario);
            $this->entityManager->flush();

            return $response->withStatus(201, 'usuario cadastrado com sucesso');

            /*
            $data = $request->getBody()->getContents();
            $centralToken = new CentralToken();
            $Usuario->token = $centralToken->ObterToken();

            $Usuario = new Usuario();
            $Usuario->email = $params->email;
            $Usuario->senha = $params->senha;
            $Usuario->token = CentralToken::obterToken();
            return $response->withStatus(209, json_encode($params));
            return $response->withStatus(219, $centralToken->ObterToken());
            dd($params, $Usuario);
            */
        }catch (\Throwable $exception){
            return $response->withStatus(501, "falha ao cadastrar sucesso. $exception->getMessage()");
        }
    }
}