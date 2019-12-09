<?php 	
  include 'config.php';
  
  $token_session= (isset($_SESSION['token']))?$_SESSION['token']:''; 
  $email_usu= (isset($_SESSION['email']))?$_SESSION['email']:''; 

  $p_ambiente= (isset($_GET['ambiente']))?$_GET['ambiente']:''; 
  $p_buscarPor= (isset($_GET['buscarPor']))?$_GET['buscarPor']:''; 
  $p_valor= (isset($_GET['valor']))?$_GET['valor']:''; 
  $p_ordenarPor= (isset($_GET['ordenarPor']))?$_GET['ordenarPor']:'';  
  $p_ascDesc= (isset($_GET['ascDesc']))?$_GET['ascDesc']:'';
  $p_arquivados= (isset($_GET['arquivados']))?$_GET['arquivados']:'';  
?>
<!doctype html>
<html lang="pt-br">
<head>
    <title>Lista de Log</title>
    
    <meta charset="utf-8">
    <meta name="description" content="Projeto Final Squad 1.">
    <meta name="author" content="Squad_1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="./css/Login-Form-Clean.css">
    <link rel="stylesheet" href="./css/bootstrap.min.3.4.0.css"> 
    <link rel="stylesheet" href="./css/bootstrap-table.min.1.15.5.css">   
    <link rel="stylesheet" href="./css/font-awesome.min.4.7.0.css">   

    <script src="./script/terceiros/jquery.min.3.4.1.js"></script>
    <script src="./script/terceiros/bootstrap-table.min.1.15.5.js"></script>    
    <script src="./script/terceiros/bootstrap.min.3.4.0.js"></script>
    <link rel="stylesheet" href="./css/styles.css">   

    <style type="text/css">   
      html, body {
        position: relative;
			min-height: 100%;
      height: 100%;
      overflow: hidden;
      }
    </style>

    <script type="text/javascript">
      var token_session='<?php echo $token_session;?>';
      var email_usuario='<?php echo $email_usu;?>';
      if (token_session === "") {
        window.location.href = "./index.php";
      }
      var pambiente='<?php echo $p_ambiente;?>';
      var pbuscarPor='<?php echo $p_buscarPor;?>';
      var pvalor='<?php echo $p_valor;?>';
      var pordenarPor='<?php echo $p_ordenarPor;?>';
      var pascDesc='<?php echo $p_ascDesc;?>';      
      var parquivados='<?php echo $p_arquivados;?>';
    </script>
    
  </head>
  <body>
    <header id="h">
      <span class="text-muted quebra">Bem vindo <?php echo $_SESSION['email']; ?>. Seu token é: <?php echo $_SESSION['token']; ?>.</span>
    </header>

      <div class="container-fluid" style="height: 100%">
      
      <div id="cabecalho">
        
        <input type="button" id="voltar" class="btn btn-primary btn-block" value="Voltar">     
        <input type="button" id="sair" class="btn btn-primary btn-block" value="Sair">

        <!-- falhas em geral como as lanÃ§adas pelo serviÃ§o -->
        <span class='msg-erro msg-falha'></span>
        <!-- exemplo: completou algum processamento mas com alguma validaÃ§Ã£o nao obrigatoria -->
        <span class='msg-alerta msg-warning'></span>
        <!-- exemplos: cadastrado, alterado, excluido com sucesso -->
        <span class='msg-exito msg-sucesso'></span>

        <input type="hidden" name="token" id="token" >       
        
        <form class="form-inline" action="/action_page.php">
          <div class="form-group">
            <label for="ambiente">Ambiente:</label><br>
            <select id="ambiente">
              <option value=""></option>
              <option value="producao">Produção</option>
              <option value="homologacao">Homologação</option>
              <option value="dev">Dev</option>
            </select>
          </div>
          <div class="form-group">
            <label for="ordenarPor">Ordenar por:</label><br>
            <select id="ordenarPor">
              <option value=""></option>
              <option value="nivel">Level</option>
              <option value="frequencia">Frequência</option>
            </select>
          </div>
          <div class="form-group">
            <label for="ascDesc" id="lblAscDesc">Sentido ordenção:</label><br>
            <select id="ascDesc">
              <option value=""></option>
              <option value="asc">Crescente</option>
              <option value="desc">Decrescente</option>
            </select>
          </div>
          <div class="form-group">
            <label for="buscarPor">Buscar por:</label><br>
            <select id="buscarPor">
              <option value=""></option>
              <option value="nivel">Level</option>
              <option value="titulo">Descrição</option>
              <option value="origem">Origem</option>
            </select>
          </div>
          <div class="form-group">
            <label for="niveis" id="lblNiveis">Níveis:</label><br>
            <select id="niveis">
              <option value="error">Erro</option>
              <option value="crit">Falha Crítica</option>
              <option value="warn">Aviso</option>
              <option value="notice">Informação</option>
            </select>
          </div>
          <div class="form-group" >
            <label for="valor" id="lblValor">Valor:</label><br>
            <input type="text" name="pesq" id="valor" placeholder="search">
          </div>
          <div class="checkbox">
            <label><input type="checkbox" name="arquivados" id="arquivados"> Arquivados</label>
          </div>

          <button type="submit" class="btn btn-default" id="consultar" width="20" height="20" >    
            <img  src="img/lupa.png" alt=""width="20" height="20"  >
          </button>
          <button type="button" class="btn btn-default" id="limparPesquisa">
            Limpar pesquisa
          </button>
        </form>

        
        <input type="button" id="arquivar" class="btn btn-primary btn-block" value="Arquivar">
        <input type="button" id="apagar" class="btn btn-primary btn-block" value="Apagar">
     </div>

      <table 
        id="tabelaResultado"
        data-classes="table table-striped table-condensed"  >			
        <thead>
          <tr id="linhaCabecalho">
            <th data-checkbox="true" class="text-center"></th>
            <th data-field="nivel" class="text-center" data-formatter="colunaNivel">Level</th>
            <th data-field="ds_amigavel" class="text-center" data-formatter="colunaLog">Log</th>
            <th data-field="frequencia" class="text-center">Eventos</th>
            <th data-field="id" class="text-center">id</th>
            <th data-field="arquivado" class="text-center">arquivado</th>
            <!--              
            <th data-field="titulo" class="text-center">titulo</th>
            <th data-field="ip" class="text-center">ip</th>
            <th data-field="data_hora" class="text-center">data_hora</th>
            <th data-field="ambiente" class="text-center">ambiente</th>
            <th data-field="origem" class="text-center">origem</th>
            <th data-field="token" class="text-center">token</th>
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
