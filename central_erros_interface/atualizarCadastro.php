<!doctype html>
<html lang="pt-br">
<?php
    session_start();	
    $p_token= (isset($_GET['token']))?$_GET['token']:''; 
    $p_email= (isset($_GET['email']))?$_GET['email']:''; 
    $p_senha= (isset($_GET['senha']))?$_GET['senha']:''; 
?>

<head>
    <!-- Required meta tags -->
    <title>Atualizar Cadastro</title>
    
    <meta charset="utf-8">
    <meta name="description" content="Projeto Final Squad 1.">
    <meta name="author" content="Squad_1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script type="text/javascript">    
        var ptoken='<?php echo $p_token;?>';
        var pemail='<?php echo $p_email;?>';
        var psenha='<?php echo $p_senha;?>';
    </script>

    <!-- Form CSS -->
    <link rel="stylesheet" href="css/Login-Form-Clean.css">
    <link rel="stylesheet" href="css/styles.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style type="text/css">
        .msg-erro{ color: red; background-color: white; }
        .msg-alerta{ background-color: yellow; }
        .msg-exito{ color: green; background-color: white; }
        .msg-processando{ color: DodgerBlue; background-color: white; }
    </style>
  </head>
  <body>
    <div class="login-clean">
        <!-- falhas em geral como as lanÃ§adas pelo serviÃ§o -->
        <span class='msg-erro msg-falha'></span>
        <!-- exemplo: completou algum processamento mas com alguma validaÃ§Ã£o nao obrigatoria -->
        <span class='msg-alerta msg-warning'></span>
        <!-- exemplos: cadastrado, alterado, excluido com sucesso -->
        <span class='msg-exito msg-sucesso'></span>

        <h1 class="text-center" id="tit">Atualizar Usuário</h1>
        <form action="" method="post" id="forme" name="form">
            <div class="form-group">
                <input type="email" name="email" id="email" class="form-control" placeholder="e-mail"><br>
                <input type="password" name="senha" id="senha" class="form-control" placeholder="password">
            </div>

            <input type="submit"  class="btn btn-primary btn-block" value="Enviar">
        </form>
    </div>

    <script src="./script/jquery.min.3.4.1.js"></script>
    <script src="./script/popper.min.1.14.7.js"></script>
    <script src="./script/bootstrap.min.4.3.1.js"></script>
    <script src="./script/requisicaoAjax.js"></script>
    <script src="./script/comum.js"></script>
    <script src="./script/atualizarCadastro.js"></script>
  </body>
</html>

