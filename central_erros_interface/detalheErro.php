<?php 	
  include 'config.php';
?>
<!doctype html>
<html lang="pt-br">
<head>
    <title>Detalhe Log</title>
    
    <meta charset="utf-8">
    <meta name="description" content="Projeto Final Squad 1.">
    <meta name="author" content="Squad_1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="./css/bootstrap.min.3.4.0.css"> 
    <link rel="stylesheet" href="./css/Login-Form-Clean.css">
    <link rel="stylesheet" href="./css/styles.css">  

    <style type="text/css">   
      html, body {
        height: 100%;
        margin: 0;
      }
    </style>

    <script type="text/javascript">
      var token_session='<?php echo $token_session;?>';
      var email_usuario='<?php echo $email_usu;?>';   
    </script>
  </head>
  <body>
    
    <div class="container-fluid">
    <header>
      <span class="text-muted quebra" id="identUser"></span>
    </header>

      <div>
        <input type="button" id="voltar" class="btn btn-primary" value="Voltar">     
        <input type="button" id="sair" class="btn btn-primary" value="Sair">

        <h1 id="ip_data"></h1>
      </div>
      <div style="height:350px;overflow: auto;">
       <div class="article">
          <h4><b>Título</b></h4>
          <h5 id="titulo"></h5>
          <br>
          <h4><b>Detalhes</b></h4>
          <h5 class="quebra" id="detalhe"></h5>
        </div>
        <div class="nav">
          <!--<label class="nivel" id="nivel"></label>-->
          <h3><span class="label label-default" id="nivel"></span></h3>
          <br>
          <h5><b>Eventos</b></h5>
          <p id="frequencia"></p>
          <br>
          <h5><b>Coletado por</b></h5>
          <p class="quebra" id="token"></p>
        </div>      
      </div>    
    </div>

          <div class="text-center m-t-10 m-b-0">
              <span class='text-danger msg-erro msg-falha'></span>
              <span class='text-warning msg-alerta msg-warning'></span>
              <span class='text-success msg-exito msg-sucesso'></span>
          </div>


        <div style="height: 55px;">
			</div>
  
    <script src="./script/terceiros/jquery.min.3.4.1.js"></script>
    <script src="./script/terceiros/popper.min.1.14.7.js"></script>
    <script src="./script/terceiros/bootstrap.min.4.3.1.js"></script>
    <script src="./script/comum/requisicaoAjax.js"></script>
    <script src="./script/comum/comum.js"></script>
    <script src="./script/detalheErro.js"></script>
  </body>
</html>
