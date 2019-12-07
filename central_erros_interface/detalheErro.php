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
      //alert(pjson);
    </script>

  </head>
  <body>
    <header>
      <span class="text-muted quebra">Bem vindo <?php echo $_SESSION['email']; ?>. Seu token é: <?php echo $_SESSION['token']; ?>.</span>
    </header>

    <section>
      <nav>
        <label class="nivel" id="nivel"></label>
        <br>
        <h5 >Eventos</h5>
        <p id="frequencia"></p>
        <br>
        <h5 >Coletado por</h5>
        <p class="quebra" id="token"></p>
      </nav>

      <article>

        <input type="button" id="voltar" class="btn" value="Voltar">
        <h1 id="ip_data"></h1>

        <h4 >Título</h4>
        <h5 id="titulo"></h5>
        <br>
        <h4 >Detalhes</h4>
        <h5 class="quebra" id="detalhe"></h5>
      </article>
    </section>

    <script src="./script/terceiros/jquery.min.3.4.1.js"></script>
    <script src="./script/terceiros/popper.min.1.14.7.js"></script>
    <script src="./script/terceiros/bootstrap.min.4.3.1.js"></script>
    <script src="./script/comum/requisicaoAjax.js"></script>
    <script src="./script/comum/comum.js"></script>
    <script src="./script/detalheErro.js"></script>
  </body>
</html>
