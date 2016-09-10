<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Setup WPanel | Cadastro do primeiro administrador</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<!-- bootstrap 3.3.4 -->
		<link href="<?= base_url('lib/css') ?>/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- Theme style -->
		<link href="<?= base_url('lib/css') ?>/AdminLTE.css" rel="stylesheet" type="text/css" />
	</head>
	<body class="login-page">
		<div class="login-box">
			<div class="login-logo">
				<b>Setup</b>WPanel
			</div>
			<div class="login-box-body">
				<p class="login-box-msg">Cadastro do primeiro administrador</p>
				<?php

				$msg_sistema = $this->session->flashdata('msg_auth');

				if ($msg_sistema) 
					echo alerts($msg_sistema, 'warning', true);

				$input_open = '<div class="form-group">';
				$input_close = '</div>';

				echo form_open('setup', array('role'=>'form'));

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

				echo form_button(array('type'=>'submit', 'name'=>'submit', 'content'=>'Cadastrar <span class="glyphicon glyphicon-chevron-right"></span>', 'class'=>'btn btn-primary'));

				echo form_close();

				?>
			</div>
		</div>
	</body>
</html>