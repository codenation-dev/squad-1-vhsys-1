<?php


namespace Central\Actions\Usuario;


use Central\Actions\ActionBase;
use Central\Entity\Erro;
use Central\Entity\Usuario;
use Central\Framework\CentralToken;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class AtualizarAutenticacaoUsuario extends ActionBase
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        try {
            $params = json_decode($request->getBody()->getContents());

            if ($params->token !== "") {
                $Usuario = $this->entityManager->getRepository(Usuario::class)->findOneBy(
                    array('email' => $params->email,
                        'token_recuperacao_senha' =>  $params->token));
            } else {
                $Usuario = $this->entityManager->getRepository(Usuario::class)->findOneBy(
                    array('email' => $params->email));
            }

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
                ->set('e.token', ':tokenNovo')
                ->setParameter('tokenNovo', $tokenNovo)
                ->where('e.token = :old_token')
                ->setParameter('old_token', $tokenAtual)
                ->getQuery()
                ->execute();
            /*
             * aqui termina o trecho de codigo que deve ir para outra classe
             */
            $Usuario->senha = md5($params->senha);
            $Usuario->token = $tokenNovo;
            $Usuario->token_recuperacao_senha = "";
            $this->persistir($Usuario);

            return $response->withStatus(200, 'usuario atualizado com sucesso');
        }catch (\Throwable $exception){
            return $response->withStatus(500, $exception->getMessage());
        }
    }
}