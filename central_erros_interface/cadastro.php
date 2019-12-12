<?php
  include 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
		<meta name="author" content="Coderthemes">

		<title>Cadastro Central</title>

		<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="assets/css/core.css" rel="stylesheet" type="text/css"/>
		<link href="assets/css/components.css" rel="stylesheet" type="text/css"/>
		<link href="assets/css/icons.css" rel="stylesheet" type="text/css"/>
		<link href="assets/css/pages.css" rel="stylesheet" type="text/css"/>
		<link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>

		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>

		<script src="assets/js/modernizr.min.js"></script>

		<script type="text/javascript">
			var token_session='<?php echo $token_session;?>';  
			var email_usuario='<?php echo $email_usu;?>';
		</script>

	</head>
	<body>

		<div class="account-pages"></div>
		<div class="clearfix"></div>
		<div class="wrapper-page">
			<div class=" card-box">
				<div class="panel-heading">
					<h3 class="text-center"> Cadastro em <strong class="text-custom">CentError</strong> </h3>
				</div>

				<div class="panel-body">
					<form class="form-horizontal m-t-10" action="" method="post" id="forme" name="form">

						<div class="form-group ">
							<div class="col-xs-12">
								<input class="form-control" type="email" name="email" id="email" required="" placeholder="E-mail">
							</div>
						</div>

						<div class="form-group">
							<div class="col-xs-12">
								<input class="form-control" type="password" name="senha" id="senha" required="" placeholder="Senha">
							</div>
						</div>
<!--
						<div class="form-group">
							<div class="col-xs-12">
								<div class="checkbox checkbox-primary">
									<input id="checkbox-signup" type="checkbox" checked="checked">
									<label for="checkbox-signup">Eu aceito os<a href="#"> Termos e Condições</a></label>
								</div>
							</div>
						</div>
-->

						<div class="form-group text-center m-t-20">
							<div class="col-xs-12">
								<button class="btn btn-inverse btn-block text-uppercase waves-effect waves-light" type="submit">
									Registrar
								</button>
							</div>
						</div>

						<div class="form-group text-center m-t-10">
							<div class="col-xs-12">
                                <button class="btn btn-inverse btn-block text-uppercase waves-effect waves-light" type="button" id="voltar">Voltar</button>
							</div>
                		</div>

					</form>
	
				<div class="form-group text-center m-t-10 m-b-0">
					<div class="col-sm-12">
						<p><i class="fa fa-user m-r-5">
						</i>Já possui Cadastro?<a href="login.php" class="text-primary m-l-5"><b>Entrar</b></a>
						</p>
					</div>
				</div>

			</div>
		</div>

		<footer class="footer text-center">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<span class="text-muted quebra" id="emailUser"></span>
					</div>
					<div class="col-xs-12">
						Squad-1-vhsys © 2019.
					</div>
				</div>
			</div>
		</footer> 

		<div class="text-center m-t-10 m-b-0">
          <!-- falhas em geral como as lanÃ§adas pelo serviÃ§o -->
          <span class='text-warning msg-erro msg-falha'></span>
          <!-- exemplo: completou algum processamento mas com alguma validaÃ§Ã£o nao obrigatoria -->
          <span class='text-warning msg-alerta msg-warning'></span>
          <!-- exemplos: cadastrado, alterado, excluido com sucesso -->
          <span class='text-success msg-exito msg-sucesso'></span>
        </div>

		<script>
			var resizefunc = [];
		</script>

		<!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>


        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

        <script src="./script/comum/requisicaoAjax.js"></script>
        <script src="./script/comum/comum.js"></script>
        <script src="./script/cadastro.js"></script>

	</body>
</html>