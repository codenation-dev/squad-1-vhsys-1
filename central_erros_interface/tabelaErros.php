<?php 	
include 'config.php';  
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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
 

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
		body {
			position: relative;
			min-height: 100%;
			height: 100%;
			overflow-y: scroll;
		}
	</style>

	<script type="text/javascript">
		var token_session='<?php echo $token_session;?>';
		var email_usuario='<?php echo $email_usu;?>';
	</script>    
</head>
<body>

	<div class="container-fluid" style="height: 100%">

		<header id="h">
			<span class="text-muted quebra" id="identUser"></span>
		</header>
		
		<div id="cabecalho">

			<input type="button" id="voltar" class="btn btn-primary" value="Voltar">     
			<input type="button" id="sair" class="btn btn-primary" value="Sair">

			<div class="text-center m-t-10 m-b-0">
				<span class='text-danger msg-erro msg-falha'></span>
				<span class='text-warning msg-alerta msg-warning'></span>
				<span class='text-success msg-exito msg-sucesso'></span>
			</div>

			<input type="hidden" name="token" id="token" >       

			<form class="form-inline" action="/action_page.php">
				<div class="form-group">
					<select id="ambiente" class="form-control">
						<option value="">Ambiente</option>
						<option value="producao">Produção</option>
						<option value="homologacao">Homologação</option>
						<option value="dev">Dev</option>
					</select>
				</div>
				<div class="form-group">
					<select id="ordenarPor" class="form-control">
						<option value="">Ordenar por</option>
						<option value="nivel">Level</option>
						<option value="frequencia">Frequência</option>
					</select>
				</div>
				<div class="form-group">
					<select id="ascDesc" class="form-control">
						<option value="">Sentido ordenção</option>
						<option value="asc">Crescente</option>
						<option value="desc">Decrescente</option>
					</select>
				</div>
				<div class="form-group">
					<select id="buscarPor" class="form-control">
						<option value="">Buscar por</option>
						<option value="nivel">Level</option>
						<option value="titulo">Descrição</option>
						<option value="origem">Origem</option>
					</select>
				</div>
				<div class="form-group">
					<select id="niveis" class="form-control">
						<option value="">Níveis</option>
						<option value="error">Erro</option>
						<option value="crit">Falha Crítica</option>
						<option value="warn">Aviso</option>
						<option value="notice">Informação</option>
					</select>
				</div>
				<div class="form-group" >
					<input class="form-control"type="text" name="pesq" id="valor" placeholder="search">
				</div>
				<div class="checkbox">
					<label><input type="checkbox" name="arquivados" id="arquivados"> Arquivados</label>
				</div>

				<button type="submit" class="btn btn-basic" id="consultar" width="20" height="20" >    
					<img  src="img/lupa.png" alt=""width="20" height="20"  >
				</button>
<!--
				<input type="text" name="pesq" id="pesq" placeholder="search">
				<button type="button" class="btn btn-default">    
					<span class="glyphicon glyphicon-search"></span> 
				</button>

-->
				<button id="limparPesquisa" class="btn btn-basic" type="reset">Limpar Pesquisa</button>
			</form>
		</div>

		<div id="toolbar">
			<button id="apagar" class="btn btn-basic" disabled>Apagar</button>
			<button id="arquivar" class="btn btn-basic" disabled>Arquivar</button>
		</div>
		<table 
			id="tabelaResultado"

			data-toolbar="#toolbar"
			data-height="460"
			data-sortable="true"
			data-classes="table table-striped table-bordered"  >			
			<thead>
				<tr id="linhaCabecalho">
					<th data-checkbox="true" class="text-center"></th>
					<th data-field="nivel" class="text-center" data-formatter="colunaNivel">Level</th>
					<th data-field="ds_amigavel" class="text-center" data-formatter="colunaLog">Log</th>
					<th data-field="frequencia" class="text-center" data-sortable="true">Eventos</th>
					<!--              
					<th data-field="id" class="text-center">id</th>
					<th data-field="arquivado" class="text-center">arquivado</th>
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
