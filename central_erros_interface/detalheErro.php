<!doctype html>
<html lang="pt-br">
<?php 	
  session_start();	  
  $session_value= (isset($_SESSION['token']))?$_SESSION['token']:''; 
  $p_json= (isset($_GET['json']))?$_GET['json']:''; 
?>
<head>
    <title>Detalhe Log</title>
    
    <meta charset="utf-8">
    <meta name="description" content="Projeto Final Squad 1.">
    <meta name="author" content="Squad_1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="./css/bootstrap.min.3.4.0.css"> 
    <link rel="stylesheet" href="./css/Login-Form-Clean.css">
    <link rel="stylesheet" href="./css/styles.css">  

    <script type="text/javascript">
      var token_session='<?php echo $session_value;?>';
      var pjson='<?php echo $p_json;?>';
    </script>

  </head>
  <body>
    <div class="container-fluid">

      <span class="text-muted">bem vindo sr. <?php echo $_SESSION['email']; ?>, identificado pelo token: <?php echo $_SESSION['token']; ?>.</span>

      <!-- falhas em geral como as lanÃ§adas pelo serviÃ§o -->
      <span class='msg-erro msg-falha'></span>
      <!-- exemplo: completou algum processamento mas com alguma validaÃ§Ã£o nao obrigatoria -->
      <span class='msg-alerta msg-warning'></span>
      <!-- exemplos: cadastrado, alterado, excluido com sucesso -->
      <span class='msg-exito msg-sucesso'></span>
      
      <input type="button" id="voltar" class="btn btn-primary btn-block" value="Voltar">

      <h1 class="text-center" id="ip_data"></h1>

      <h2 class="text-center">Título</h1>
      <h3 class="text-center" id="titulo">"TITULO"</h1>
      <br>
      <br>
      <h2 class="text-center">Detalhes</h1>
      <h3 class="text-center" id="detalhe">"DETALHES"</h1>
      <br>
      <br>

    </div>

    <script src="./script/jquery.min.3.4.1.js"></script>
    <script src="./script/popper.min.1.14.7.js"></script>
    <script src="./script/bootstrap.min.4.3.1.js"></script>
    <script src="./script/requisicaoAjax.js"></script>
    <script src="./script/comum.js"></script>
    <script src="./script/detalheErro.js"></script>
  </body>
</html>
