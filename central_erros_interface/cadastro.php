<?php
  include 'config.php';
  $p_email= (isset($_GET['email']))?$_GET['email']:''; 
  $p_senha= (isset($_GET['senha']))?$_GET['senha']:''; 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cadastro</title>
    
    <meta charset="utf-8">
    <meta name="description" content="Projeto Final Squad 1.">
    <meta name="author" content="Squad_1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="./css/bootstrap.min.3.4.0.css"> 
    <link rel="stylesheet" href="./css/Login-Form-Clean.css">
    <link rel="stylesheet" href="./css/signup.css">  

  </head>
  <body class="text-center, bg">
      <form action="" class="form-signin" method="post" id="forme" name="form">
        <img class="mb-4" src="img/error-icon.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal" style="text-align: center">Cadastro do sistema</h1>
        <label for="email" class="sr-only">Email address</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="E-mail"><br>
        <label for="senha" class="sr-only">Password</label>
        <input type="password" name="senha" id="senha" class="form-control" placeholder="Password">
        <button class="btn btn-primary btn-block" type="submit">Enviar</button>
        <button class="btn btn-primary btn-block" type="button" id="voltar">Voltar</button>
        <a href="login.php" class="text-center">Já possuo Cadastro</a>
        <p class="mt-5 mb-3 text-muted">Squad-1-vhsys © 2019</p>
        <div class="response">
          <!-- falhas em geral como as lanÃ§adas pelo serviÃ§o -->
          <span class='msg-erro msg-falha'></span>
          <!-- exemplo: completou algum processamento mas com alguma validaÃ§Ã£o nao obrigatoria -->
          <span class='msg-alerta msg-warning'></span>
          <!-- exemplos: cadastrado, alterado, excluido com sucesso -->
          <span class='msg-exito msg-sucesso'></span>
        </div>
      </form>
    </div>

    <script src="./script/terceiros/jquery.min.3.4.1.js"></script>
    <script src="./script/terceiros/popper.min.1.14.7.js"></script>
    <script src="./script/terceiros/bootstrap.min.4.3.1.js"></script>
    <script src="./script/comum/requisicaoAjax.js"></script>
   
    <script src="./script/comum/comum.js"></script>
    <script type="text/javascript">
      var token_session='<?php echo $token_session;?>';  
      var pemail='<?php echo $p_email;?>';
      var psenha='<?php echo $p_senha;?>';
    </script>
    <script src="./script/cadastro.js"></script>
  </body>
</html>
