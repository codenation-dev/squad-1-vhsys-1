<?php


namespace Central\Actions\Usuario;


use Central\Actions\ActionBase;
use Central\Entity\URL;
use Central\Entity\Usuario;
use Central\Framework\CentralMail;
use Central\Framework\CentralToken;
use Central\Middleware\Auth;
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



            $baseN = basename($request->getHeaderLine('referer'));
            $url_base_interface = str_replace($baseN, "", $request->getHeaderLine('referer'));

            $parametrosURL = '?{"email":"'.$params->email.'", "token":"'.$Usuario->token.'", "token_recuperacao_senha":"'.$token_recuperacao_senha.'"}';
            $url_recuperacao_senha  = "<a href='".$url_base_interface."atualizarCadastro.php".$parametrosURL.">Teste</a>";

            //$url_recuperacao_senha  = "<a href='http://".$request->getHeaderLine('host')."/central/recovery?token=$token_recuperacao_senha'>Teste</a>";


            CentralMail::enviarEmail($Usuario->email, $url_recuperacao_senha);

            $resp = new URL();
            $resp->url = $url_recuperacao_senha;

            //$response->getBody()->write(json_encode($resp));
            $response->getBody()->write("Um link foi enviado para o e-mail cadastrado.");

            return $response->withStatus(200);
        }catch (\Throwable $exception){
            return $response->withStatus(500, $exception->getMessage());
        }
    }
}