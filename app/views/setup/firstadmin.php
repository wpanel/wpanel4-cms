<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Admin WPanel | Cadastro do primeiro administrador</title>
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
	<body class="login-page">
		<div class="login-box">
			<div class="login-logo">
				<b>Admin</b>WPanel
			</div>
			<div class="login-box-body">
				<p class="login-box-msg">Cadastro do primeiro administrador</p>
				<?php

				$msg_sistema = $this->session->flashdata('msg_auth');

				if ($msg_sistema) echo alerts($msg_sistema, 'warning', true);

				$input_open = '<div class="form-group">';
				$input_close = '</div>';

				echo form_open('setup/firstadmin', array('role'=>'form'));

				echo $input_open;
				echo form_label('Nome completo', 'name');
				echo form_input(array('name'=>'name', 'value'=> set_value('name'), 'class'=>'form-control'));
				echo form_error('name');
				echo $input_close;

				echo $input_open;
				echo form_label('Email válido', 'email');
				echo form_input(array('name'=>'email', 'value'=> set_value('email'), 'type'=>'email', 'class'=>'form-control'));
				echo form_error('email');
				echo $input_close;

				echo $input_open;
				echo form_label('Nome de usuário', 'username');
				echo form_input(array('name'=>'username', 'value'=> set_value('username'), 'class'=>'form-control'));
				echo form_error('username');
				echo $input_close;

				echo $input_open;
				echo form_label('Senha', 'password');
				echo form_password(array('name'=>'password', 'value'=> set_value('password'), 'class'=>'form-control'));
				echo form_error('password');
				echo $input_close;

				echo form_button(array('type'=>'submit', 'name'=>'submit', 'content'=>'Cadastrar', 'class'=>'btn btn-primary'));

				echo form_close();

				?>
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