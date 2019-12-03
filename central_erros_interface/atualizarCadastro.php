<!doctype html>
<html lang="en">
<?php
    session_start();	
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="./script/requisicao.js"></script>
    <script src="./script/requisicaoAjax.js"></script>    
    <script src="./script/comum.js"></script>
    <script src="./script/atualizarCadastro.js"></script>
  </body>
</html>

