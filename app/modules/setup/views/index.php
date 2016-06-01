<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Setup WPanelCMS | Instalação inicial do WPanel CMS</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<!-- bootstrap 3.3.4 -->
		<link href="../lib/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- Theme style -->
		<link href="../lib/css/AdminLTE.css" rel="stylesheet" type="text/css" />
		<!-- jQuery 2.1.4 -->
	    <script src="../lib/plugins/jQuery/jQuery-2.1.4.min.js"></script>
		<!-- Bootstrap 3.3.2 JS -->
	    <script src="../lib/js/bootstrap.min.js" type="text/javascript"></script>
	    <script type="text/javascript">
	    $(function(){
	    	$("#opt_sqlite").click(function(){
	    		$("#servername_control").hide();
	    		$("#user_control").hide();
	    		$("#pass_control").hide();
	    		$("#intro_mysql").hide();
	    	});
	    	$("#opt_mysql").click(function(){
	    		$("#servername_control").show();
	    		$("#user_control").show();
	    		$("#pass_control").show();
	    		$("#intro_mysql").show();
	    	});
	    });
	    </script>
	</head>
	<body class="setup-page">
		<div class="setup-box box-solid">
			<div class="setup-logo">
				<b>Setup</b>WPanelCMS
			</div>
			<div class="setup-box-body">
				<p class="setup-box-msg"><b>Seja bem vindo à instalação inicial do WPanel CMS.</b></p>
				<?php
				$msg_setup = $this->session->flashdata('msg_setup');
				if ($msg_setup)
					echo alerts($msg_setup, 'warning', true);
			    ?>
			    
				<?= form_open('', array('role'=>'form', 'class'=>'form-horizontal')); ?>
					<div class="form-group">
						<label for="siteurl" class="col-sm-4 control-label">URL da aplicação</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="siteurl" name="siteurl" placeholder="Ex: http://seusite.com/" />
							<?= form_error('siteurl'); ?>
						</div>
					</div>
					<!-- ocultar index.php da URL -->
					<!-- usar extensão .html -->
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-4 checkbox">
							<label>
								<input type="checkbox" name="urlamigavel" value="1" /> Ocultar index.php da URL.
							</label>
							<label>
								<input type="checkbox" name="usaextensao" value="1" /> Usar extensão .html na URL.
							</label>
						</div>
					</div>
					<hr/>
					<p id="intro_mysql">Crie uma base de dados em branco no seu servidor. Caso tenha dúvidas, <a href="http://wpanelcms.com.br/post/criando-um-novo-banco-de-dados-mysql-no-cpanel.html" target="_blank">veja este tutorial</a>. Em seguida preencha os campos abaixo com os dados da base de dados que você acabou de criar.</p>
					<div class="form-group">
						<label for="servername" class="col-sm-4 control-label">Tipo de banco de dados</label>
						<div class="col-sm-8 radio">
							<label id="opt_mysql">
								<input type="radio" name="tipo_database" id="tipo_database_mysql" value="mysql" checked>
								MySQL&nbsp;&nbsp;&nbsp;
							</label>
							<label id="opt_sqlite">
								<input type="radio" name="tipo_database" id="tipo_database_sqlite" value="sqlite">
								SQLite 3
							</label>
						</div>
					</div>
					<div class="form-group" id="servername_control">
						<label for="servername" class="col-sm-4 control-label">Servidor MySQL</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="servername" name="servername" placeholder="Ex: localhost" />
							<?= form_error('servername'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="databasename" class="col-sm-4 control-label">Base de dados</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="databasename" name="databasename" placeholder="Ex: wpanel" />
							<?= form_error('databasename'); ?>
						</div>
					</div>
					<div class="form-group" id="user_control">
						<label for="username" class="col-sm-4 control-label">Usuário</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="username" name="username" placeholder="Ex: root" />
							<?= form_error('username'); ?>
						</div>
					</div>
					<div class="form-group" id="pass_control">
						<label for="password" class="col-sm-4 control-label">Senha</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" id="password" name="password" placeholder="Crie uma senha segura" />
							<?= form_error('password'); ?>
						</div>
					</div>
					<hr/>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<button type="submit" class="btn btn-primary">Proseguir <span class="glyphicon glyphicon-chevron-right"></span></button>
						</div>
					</div>
				<?= form_close(); ?>
			</div>
			<p class="text-center" style="margin-top:10px;">
				&reg;<?= date('Y'); ?> <a href="http://wpanelcms.com.br" target="_blank">Wpanel CMS</a>, desenvolvido por <a href="http://elieldepaula.com.br" target="_blank">Eliel de Paula</a>.
			</p>
		</div>
		
	</body>
</html>