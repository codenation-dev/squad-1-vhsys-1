<?php


namespace Central\Actions\Usuario;


use Central\Actions\ActionBase;
use Central\Entity\Usuario;
use Central\Framework\CentralToken;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class EsqueceuSenha extends ActionBase
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        try {
            $params = json_decode($request->getBody()->getContents());
            if ($params->email == "") {
                return $response->withStatus(500, "email em branco" + $params->email);
            }

            $Usuario = $this->entityManager->getRepository(Usuario::class)->findOneBy(array('email' => $params->email));


            if ($Usuario === null) {
                return $response->withStatus(500, "usuario nao existe");
            }

            $token_recuperacao_senha = CentralToken::obterToken();
            $Usuario->token_recuperacao_senha = $token_recuperacao_senha;
            $this->persistir($Usuario);

            //$url_recuperacao_senha  = "http://tuaapp.com/recovery?token=$token_recuperacao_senha";
            return $response->withStatus(200, $token_recuperacao_senha);
        }catch (\Throwable $exception){
            return $response->withStatus(508, $exception->getMessage());
        }
    }
}