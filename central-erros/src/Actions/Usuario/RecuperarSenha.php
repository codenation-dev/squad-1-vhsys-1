<?php


namespace Central\Actions\Usuario;


use Central\Actions\ActionBase;
use Central\Entity\Usuario;
use Central\Framework\CentralToken;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class RecuperarSenha extends ActionBase
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        try {
            //$queryParams = json_decode($request->getQueryParams());

            $queryParams = $request->getQueryParams();
            $tokenParams = json_decode($queryParams['token']);

            $token = $tokenParams->token_recuperacao_senha;


            $Usuario = $this->entityManager->getRepository(Usuario::class)->findOneBy(
                array('token_recuperacao_senha' =>  $token)
            );

            if ($Usuario === null) {
                return $response->withStatus(404, 'usuário não encontrado');
            }

            $response->getBody()->write(
                json_encode($Usuario)
            );
            return $response->withStatus(200);
        }catch (\Throwable $exception){
            return $response->withStatus(508, $exception->getMessage());
        }
    }

}