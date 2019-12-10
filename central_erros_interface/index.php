<?php
	include 'config.php';
?>
<!doctype html>
<html lang="pt-br">
<head>
    <title>Inicio</title>
    
    <meta charset="utf-8">
    <meta name="description" content="Projeto Final Squad 1.">
    <meta name="author" content="Squad_1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="./css/bootstrap.min.3.4.0.css"> 
    <link rel="stylesheet" href="./css/Login-Form-Clean.css">
    <link rel="stylesheet" href="./css/styles.css">  

    <script type="text/javascript">
      var token_session='<?php echo $token_session;?>';
      var email_usuario='<?php echo $email_usu;?>';
    </script>
    
  </head>
  <body>
    <div class="login-clean">

      <!-- falhas em geral como as lanÃ§adas pelo serviÃ§o -->
      <span class='msg-erro msg-falha'></span>
      <!-- exemplo: completou algum processamento mas com alguma validaÃ§Ã£o nao obrigatoria -->
      <span class='msg-alerta msg-warning'></span>
      <!-- exemplos: cadastrado, alterado, excluido com sucesso -->
      <span class='msg-exito msg-sucesso'></span>

      <!-- <input type="button" id="cadastro" class="btn btn-primary btn-block" value="Cadastrar"> -->
      <input type="button" id="login" class="btn btn-primary btn-block" value="Login">  
    </div>
     
    <script src="./script/terceiros/jquery.min.3.4.1.js"></script>
    <script src="./script/terceiros/popper.min.1.14.7.js"></script>
    <script src="./script/terceiros/bootstrap.min.4.3.1.js"></script>    
    <script src="./script/comum/comum.js"></script>
    <script src="./script/index.js"></script>
  </body>
</html>
