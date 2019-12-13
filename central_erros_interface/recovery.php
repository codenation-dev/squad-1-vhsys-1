<?php
    include 'config.php';    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Recuperar Senha</title>
	
	<meta charset="utf-8">
    <meta name="description" content="Projeto Final Squad 1.">
    <meta name="author" content="Squad_1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!--<link rel="shortcut icon" href="assets/images/favicon_1.ico">-->

	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/core.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/components.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />

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
				<h3 class="text-center"> Recuperar Senha <strong class="text-custom">CentError</strong></h3>
			</div>

			<div class="panel-body">					
				<div class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					Informe seu <b>Email</b> e siga as instruções que serão enviadas para você!
				</div>
				<form class="form-horizontal m-t-10" action="" method="post" id="formRecovery" name="formRecovery">					
					
					<div class="form-group">
						<div class="col-xs-12">
							<input class="form-control" name="email" id="email" type="email" required="" placeholder="E-mail">
						</div>
					</div>

					<div class="form-group text-center m-t-10">
						<div class="col-xs-12">
							<button class="btn btn-inverse btn-block text-uppercase waves-effect waves-light" type="submit">Enviar</button>
						</div>
					</div>
					
					<div class="form-group text-center m-t-10">
						<div class="col-xs-12">
							<button class="btn btn-inverse btn-block text-uppercase waves-effect waves-light" type="button" id="voltar">Voltar</button>
						</div>
					</div>

				</form>
				<div class="text-center m-t-10 m-b-0">
					<span class='text-danger msg-erro msg-falha'></span>
					<span class='text-warning msg-alerta msg-warning'></span>
					<span class='text-success msg-exito msg-sucesso'></span>
				</div>
			</div>
		</div>
	</div>
	
	<footer class="footer text-center">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					Squad-1-vhsys © 2019.
				</div>
			</div>
		</div>
	</footer> 

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
	<script src="./script/recovery.js"></script>
</body>
</html>
