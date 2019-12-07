<!doctype html>
<html lang="pt-br">
<?php 	
	session_start();	
?>
<head>
    <title>Login</title>
    
    <meta charset="utf-8">
    <meta name="description" content="Projeto Final Squad 1.">
    <meta name="author" content="Squad_1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="./css/bootstrap.min.3.4.0.css"> 
    <link rel="stylesheet" href="./css/Login-Form-Clean.css">
    <link rel="stylesheet" href="./css/styles.css">   
    
  </head>
  <body>
    <div class="login-clean">

      <!-- falhas em geral como as lanÃ§adas pelo serviÃ§o -->
      <span class='msg-erro msg-falha'></span>
      <!-- exemplo: completou algum processamento mas com alguma validaÃ§Ã£o nao obrigatoria -->
      <span class='msg-alerta msg-warning'></span>
      <!-- exemplos: cadastrado, alterado, excluido com sucesso -->
      <span class='msg-exito msg-sucesso'></span>

      <h1 class="text-center">Login</h1>
      <form action="" method="post" id="formLogin" name="form">
        <div class="form-group">
          <input type="email" name="email" id="email" class="form-control"  placeholder="e-mail"><br>
          <input type="password" name="senha" id="senha" class="form-control"  placeholder="password">
        </div>
        <input type="submit" class="btn btn-primary btn-block"  value="Enviar">
        <br>
        <a href="#" class="text-center" id="linkEsqueceuSenha">Esqueceu a Senha</a>
      </form>
    </div>
    
    <script src="./script/terceiros/jquery.min.3.4.1.js"></script>
    <script src="./script/terceiros/popper.min.1.14.7.js"></script>
    <script src="./script/terceiros/bootstrap.min.4.3.1.js"></script>
    <script src="./script/comum/requisicaoAjax.js"></script>
    <script src="./script/comum/comum.js"></script>
    <script src="./script/login.js"></script>
    
  </body>
</html>
