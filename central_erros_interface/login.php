<?php
  include 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Login</title>

  <meta charset="utf-8">
  <meta name="description" content="Projeto Final Squad 1.">
  <meta name="author" content="Squad_1">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="./css/bootstrap.min.3.4.0.css"> 
  <link rel="stylesheet" href="./css/Login-Form-Clean.css">
  <link rel="stylesheet" href="./css/signin.css">   

</head>
<body class="text-center, bg">

  <form action="" class="form-signin" method="post" id="formLogin" name="form">
    <img class="mb-4" src="img/error-icon.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal" style="text-align: center">Login do sistema</h1>
    <label for="email" class="sr-only">Email address</label>
    <input type="email" name="email" id="email" class="form-control"  placeholder="E-mail"><br>
    <label for="senha" class="sr-only">Password</label>
    <input type="password" name="senha" id="senha" class="form-control"  placeholder="Password">
    <button class="btn btn-primary btn-block" type="submit">Entrar</button>
        <button class="btn btn-primary btn-block" type="button" id="voltar">Voltar</button>
    <a href="#" id="linkEsqueceuSenha" class="text-center">Esqueci minha Senha</a>
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
    
    <script src="./script/terceiros/jquery.min.3.4.1.js"></script>
    <script src="./script/terceiros/popper.min.1.14.7.js"></script>
    <script src="./script/terceiros/bootstrap.min.4.3.1.js"></script>
    <script src="./script/comum/requisicaoAjax.js"></script>
    <script src="./script/comum/comum.js"></script>
    <script src="./script/login.js"></script>
    
  </body>
</html>
