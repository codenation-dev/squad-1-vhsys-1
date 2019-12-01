<?php


namespace Central\Actions\Usuario;


use Central\Actions\ActionBase;
use Central\Entity\Erro;
use Central\Entity\Usuario;
use Central\Framework\CentralToken;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class AtualizarTokenUsuario extends ActionBase
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        try {
            $params = json_decode($request->getBody()->getContents());
            $Usuario = $this->entityManager->getRepository(Usuario::class)->findOneBy(array('email' => $params->email));

            if ($Usuario === null) {
                return $response->withStatus(404, 'usuário não encontrado');
            }

            $tokenAtual = $Usuario->token;
            $tokenNovo = CentralToken::obterToken();

            /*
             * atualizar token nos erros
             *
             */
            $queryBuilder = $this->entityManager->getRepository(Erro::class)->createQueryBuilder('e');
            $queryBuilder->update()
                ->set('e.token', $tokenNovo)
                ->where('e.token = :old_token')
                ->setParameter('old_token', $tokenAtual)
                ->getQuery()
                ->execute();
            /*
             * aqui termina o trecho de codigo que deve ir para outra classe
             */
            $Usuario->senha = $params->senha;
            $Usuario->token = $tokenNovo;
            $this->entityManager->persist($Usuario);
            $this->entityManager->flush();

            return $response->withStatus(200, 'token atualziado com sucesso');
        }catch (\Throwable $exception){
            return $response->withStatus(500, $exception->getMessage());
        }
    }
}