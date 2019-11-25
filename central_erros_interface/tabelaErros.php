<!doctype html>
<html lang="pt-br">
<?php 	
  session_start();	
  
  $session_value= (isset($_SESSION['token']))?$_SESSION['token']:''; 
  $p_buscarPor= (isset($_GET['buscarPor']))?$_GET['buscarPor']:''; 
  $p_valor= (isset($_GET['valor']))?$_GET['valor']:''; 
  $p_ordenarPor= (isset($_GET['ordenarPor']))?$_GET['ordenarPor']:''; 
?>
<head>
    <!-- Required meta tags -->
    <title>Logues</title>
    
    <meta charset="utf-8">
    <meta name="description" content="Projeto Final Squad 1.">
    <meta name="author" content="Squad_1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script type="text/javascript">
      var token_session='<?php echo $session_value;?>';
      var pbuscarPor='<?php echo $p_buscarPor;?>';
      var pvalor='<?php echo $p_valor;?>';
      var pordenarPor='<?php echo $p_ordenarPor;?>';
    </script>

    <!-- Form CSS -->
    <link rel="stylesheet" href="css/Login-Form-Clean.css">
    <link rel="stylesheet" href="css/styles.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>

    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>    
    <link href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>


    <style type="text/css">
	    .msg-erro{ color: red; background-color: white; }
      .msg-alerta{ background-color: yellow; }
      .msg-exito{ color: green; background-color: white; }
      .msg-processando{ color: DodgerBlue; background-color: white; }
    </style>
  </head>
  <body>
    <div class="container-fluid">

      <span class="text-muted">bem vindo sr. <?php echo $_SESSION['email']; ?>, O Chupa-Cabras proprietário do token: <?php echo $_SESSION['token']; ?>.</span>

      <!-- falhas em geral como as lanÃ§adas pelo serviÃ§o -->
      <span class='msg-erro msg-falha'></span>
      <!-- exemplo: completou algum processamento mas com alguma validaÃ§Ã£o nao obrigatoria -->
      <span class='msg-alerta msg-warning'></span>
      <!-- exemplos: cadastrado, alterado, excluido com sucesso -->
      <span class='msg-exito msg-sucesso'></span>

      <input type="hidden" name="token" id="token" >

      <h1 class="text-center">Listar logs</h1>

      <select>
        <option value="producao">Produção</option>
        <option value="homologacao">Homologação</option>
        <option value="dev">Dev</option>
      </select>

      <select id="ordenarPor">
        <option value="ordenarPor">Ordenar por</option>
        <option value="level">Level</option>
        <option value="frequencia">Frequência</option>
      </select>

      <select id="buscarPor">
        <option value="buscarPor">Buscar por</option>
        <option value="level">Level</option>
        <option value="descricao">Descrição</option>
        <option value="origem">Origem</option>
      </select>

      <input type="text" name="pesq" id="valor" placeholder="search">
      <button type="button" class="btn btn-default" id="consultar">    <span class="glyphicon glyphicon-search"></span> </button>
      

      <br>
      <input type="button" id="cons" class="btn btn-primary btn-block" value="Arquivar">
      <input type="button" id="cons" class="btn btn-primary btn-block" value="Apagar">

      <table 
        id="tabelaResultado"
        data-classes="table table-striped table-condensed" 
        data-show-columns="true"
        data-show-refresh="true" >			
        <thead>
          <tr id="linhaCabecalho">
            <th data-checkbox="true"></th>
            <th data-field="codigo">codigo</th>
            <th data-field="token">token</th>
            <th data-field="nivel">nivel</th>
            <th data-field="ip">ip</th>
            <th data-field="data_hora">data_hora</th>
            <th data-field="titulo">titulo</th>
            <th data-field="detalhe">detalhe</th>
            <th data-field="status">status</th>
            <th data-field="ambiente">ambiente</th>
            <th data-field="origem">origem</th>
          </tr>
        </thead>
      </table>
    
<!--
      <table id="table">
      id="tabelaResultado"
        <thead>
          <tr id="linhaCabecalho">
            <th data-field="codigo">codigo</th>
            <th data-field="token">token</th>
            <th data-field="nivel">nivel</th>
            <th data-field="ip">ip</th>
            <th data-field="data_hora">data_hora</th>
            <th data-field="titulo">titulo</th>
            <th data-field="detalhe">detalhe</th>
            <th data-field="status">status</th>
            <th data-field="ambiente">ambiente</th>
            <th data-field="origem">origem</th>
          </tr>
        </thead>
      </table>      
-->
    </div>

    <script src="./script/requisicao.js"></script>
    <script src="./script/requisicaoAjax.js"></script>
    <script src="./script/comum.js"></script>
    <script src="./script/tabelaErros.js"></script>
  </body>
</html>

