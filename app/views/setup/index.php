<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Setup WPanelCMS | Instalação inicial do WPanel CMS</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<!-- bootstrap 3.3.4 -->
		<link href="<?= base_url('lib/css') ?>/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- Font Awesome Icons -->
		<link href="https://maxcdn.assetscdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<!-- Theme style -->
		<link href="<?= base_url('lib/css') ?>/AdminLTE.css" rel="stylesheet" type="text/css" />
		<!-- iCheck -->
		<link href="<?= base_url('lib/plugins') ?>/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="setup-page">
		<div class="setup-box box-solid">
			<div class="setup-logo">
				<b>Setup</b>WPanelCMS
			</div>
			<div class="setup-box-body">
				<p class="setup-box-msg"><b>Seja bem vindo à instalação inicial do WPanel CMS.</b></p>
				<p>Crie uma base de dados em branco no seu servidor. Caso tenha dúvidas, <a href="http://wpanelcms.com.br/post/criando-um-novo-banco-de-dados-mysql-no-cpanel.html" target="_blank">assista este tutorial</a>. Em seguida preencha os campos abaixo com os dados da base de dados que você acabou de criar.</p>
				<?php
				$msg_setup = $this->session->flashdata('msg_setup');
				if ($msg_setup)
					echo alerts($msg_setup, 'warning', true);
			    ?>
				<form action="<?= site_url('setup'); ?>" method="post" role="form" class="form-horizontal">
					<div class="form-group">
						<label for="servername" class="col-sm-3 control-label">Servidor MySQL</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="servername" name="servername" placeholder="Ex: localhost" />
							<?= form_error('servername'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="databasename" class="col-sm-3 control-label">Base de dados</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="databasename" name="databasename" placeholder="Ex: wpanel" />
							<?= form_error('databasename'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="username" class="col-sm-3 control-label">Usuário</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="username" name="username" placeholder="Ex: root" />
							<?= form_error('username'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-3 control-label">Senha</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" id="password" name="password" placeholder="Crie uma senha segura" />
							<?= form_error('password'); ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<button type="submit" class="btn btn-primary">Proseguir >></button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- jQuery 2.1.4 -->
		<script src="<?= base_url('lib/plugins') ?>/jQuery/jQuery-2.1.4.min.js"></script>
		<!-- bootstrap 3.3.2 JS -->
		<script src="<?= base_url('lib/js') ?>/bootstrap.min.js" type="text/javascript"></script>
		<!-- iCheck -->
		<script src="<?= base_url('lib/plugins') ?>/iCheck/icheck.min.js" type="text/javascript"></script>
		<script>
		$(function () {
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue',
				increaseArea: '20%' // optional
			});
		});
		</script>
	</body>
</html>