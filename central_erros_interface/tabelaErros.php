<!doctype html>
<html lang="pt-br">
<?php 	
  include 'config.php';	 
  
  $session_value= (isset($_SESSION['token']))?$_SESSION['token']:''; 
  $email_usu= (isset($_SESSION['email']))?$_SESSION['email']:''; 

  $p_ambiente= (isset($_GET['ambiente']))?$_GET['ambiente']:''; 
  $p_buscarPor= (isset($_GET['buscarPor']))?$_GET['buscarPor']:''; 
  $p_valor= (isset($_GET['valor']))?$_GET['valor']:''; 
  $p_ordenarPor= (isset($_GET['ordenarPor']))?$_GET['ordenarPor']:'';
?>
<head>
    <title>Lista de Log</title>
    
    <meta charset="utf-8">
    <meta name="description" content="Projeto Final Squad 1.">
    <meta name="author" content="Squad_1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="./css/Login-Form-Clean.css">
    <link rel="stylesheet" href="./css/styles.css">   
    <link rel="stylesheet" href="./css/bootstrap.min.3.4.0.css"> 
    <link rel="stylesheet" href="./css/bootstrap-table.min.1.15.5.css">   
    <link rel="stylesheet" href="./css/font-awesome.min.4.7.0.css">   

    <script src="./script/terceiros/jquery.min.3.4.1.js"></script>
    <script src="./script/terceiros/bootstrap-table.min.1.15.5.js"></script>    
    <script src="./script/terceiros/bootstrap.min.3.4.0.js"></script>
    <!-- tem que deixar local
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> -->

    <style type="text/css">
      body {
        font-family: Arial,sans-serif;
        font-size: 12px;
        overflow: hidden;
      }
      html, body {
        min-height: 100%;
        height: 100%;
      }
    </style>

    <script type="text/javascript">
      var token_session='<?php echo $session_value;?>';
      var email_usuario='<?php echo $email_usu;?>';
      if (token_session === "") {
        window.location.href = "./index.php";
      }
      var pambiente='<?php echo $p_ambiente;?>';
      var pbuscarPor='<?php echo $p_buscarPor;?>';
      var pvalor='<?php echo $p_valor;?>';
      var pordenarPor='<?php echo $p_ordenarPor;?>';
    </script>
    
  </head>
  <body>
    <header>
      <span class="text-muted quebra">Bem vindo <?php echo $_SESSION['email']; ?>. Seu token é: <?php echo $_SESSION['token']; ?>.</span>
    </header>

      <div class="container-fluid" style="height: 100%; overflow: auto;">
      
      <input type="button" id="sair" class="btn btn-primary btn-block" value="Sair">
      

      <!-- falhas em geral como as lanÃ§adas pelo serviÃ§o -->
      <span class='msg-erro msg-falha'></span>
      <!-- exemplo: completou algum processamento mas com alguma validaÃ§Ã£o nao obrigatoria -->
      <span class='msg-alerta msg-warning'></span>
      <!-- exemplos: cadastrado, alterado, excluido com sucesso -->
      <span class='msg-exito msg-sucesso'></span>

      <input type="hidden" name="token" id="token" >

      <h1 class="text-center">Listar logs</h1>

      <select id="ambiente">
        <option value="">Ambiente</option>
        <option value="producao">Produção</option>
        <option value="homologacao">Homologação</option>
        <option value="dev">Dev</option>
      </select>

      <select id="ordenarPor">
        <option value="">Ordenar por</option>
        <option value="nivel">Level</option>
        <option value="frequencia">Frequência</option>
      </select>

      <select id="buscarPor">
        <option value="">Buscar por</option>
        <option value="nivel">Level</option>
        <option value="titulo">Descrição</option>
        <option value="origem">Origem</option>
      </select>

      <input type="text" name="pesq" id="valor" placeholder="search">
      <button type="button" class="btn btn-default" id="consultar">    
        Lupa
      <!--
        <i class="fa fa-search"></i>
        <span class="glyphicon glyphicon-search"></span> 
      -->
      </button>
      <button type="button" class="btn btn-default" id="limparPesquisa">Limpar pesquisa
      </button>
      

      <br>
      <input type="button" id="arquivar" class="btn btn-primary btn-block" value="Arquivar">
      <input type="button" id="apagar" class="btn btn-primary btn-block" value="Apagar">

      <table 
        id="tabelaResultado"
        data-classes="table table-striped table-condensed"  >			
        <thead>
          <tr id="linhaCabecalho">
            <th data-checkbox="true" class="text-center"></th>
            <th data-field="nivel" class="text-center">Level</th>
            <th data-field="ds_amigavel" class="text-center">Log</th>
            <th data-field="frequencia" class="text-center">Eventos</th>
            <th data-field="id" class="text-center">id</th>
            <!--
            <th data-field="titulo" class="text-center">titulo</th>
            <th data-field="ip" class="text-center">ip</th>
            <th data-field="data_hora" class="text-center">data_hora</th>
            <th data-field="ambiente" class="text-center">ambiente</th>
            <th data-field="origem" class="text-center">origem</th>
            <th data-field="token" class="text-center">token</th>
            <th data-field="arquivado" class="text-center">arquivado</th>
            -->
          </tr>
        </thead>
      </table>
    </div>

    <script src="./script/comum/requisicaoAjax.js"></script>
    <script src="./script/comum/comum.js"></script>
    <script src="./script/tabelaErros.js"></script>
  </body>
</html>
