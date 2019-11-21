<?php
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <title>Cadastro!</title>
    
    <meta charset="utf-8">
    <meta name="description" content="Projeto Final Squad 1.">
    <meta name="author" content="Edgar Brasil Sovinski">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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

      <h1 class="text-center">Login</h1>
      <form action="" method="post" id="forme" name="form">
          <div class="form-group">
              <input type="email" name="email" id="email" class="form-control"  placeholder="e-mail"><br>
              <input type="password" name="senha" id="senha" class="form-control"  placeholder="password">
          </div>
          <input type="submit" class="btn btn-primary btn-block"  value="Enviar">
          <input type="button" id="cons" class="btn btn-primary btn-block" value="Consultar">
          <br>
          <a href="#" id="linkEsqueceuSenha">Esqueceu a Senha</a>
      </form>
    </div>


    <script src="./requisicao.js"></script>
    <script src="./requisicaoAjax.js"></script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS 
  
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  
-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  
    
    <script src="./index.js"></script>
  </body>
</html>

