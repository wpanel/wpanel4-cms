<!DOCTYPE html>
<html>
	<head>

		<meta charset="utf-8">
		<title>wPanel 11 | Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Layout para administração de sites e aplicações web com Bootstrap 3.">
		<meta name="author" content="Eliel de Paula <elieldepaula@gmail.com>">

		<script src="<?=base_url('')?>lib/js/jquery.js"></script>

		<!-- Bootstrap -->
		<link href="<?=base_url('')?>lib/css/bootstrap.css" rel="stylesheet">
		<script src="<?=base_url('')?>lib/js/bootstrap.js"></script>


		<style>

			body {
				padding-top: 5%;
				background-color: #eee;
				background: url('<?=base_url('')?>lib/img/bg-login.jpg');
				background-position: center;
			}

			@media (min-width: 200px){
				.container{
					max-width: 400px;
				}
			}

			.sombra {
				-webkit-box-shadow: 11px 0px 30px 16px rgba(50, 50, 50, 0.33);
				-moz-box-shadow:    11px 0px 30px 16px rgba(50, 50, 50, 0.33);
				box-shadow:         11px 0px 30px 16px rgba(50, 50, 50, 0.33);
				border: solid 1px #999;
			}

		</style>

	</head>

	<body>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default sombra">
						<!-- Titulo do painel -->
						<div class="panel-heading">
							<h3 class="panel-title">
								<span class="glyphicon glyphicon-user"></span>&nbsp;<b>Cadastro do primeiro administrador</b>
							</h3>
						</div>
						<!-- Corpo do painel -->
						<div class="panel-body">
							<?php
							$msg_sistema = $this->session->flashdata('msg_auth');

							if ($msg_sistema) {
								echo alerts($msg_sistema, 'warning', true);
							}

							$input_open = '<div class="form-group">';
							$input_close = '</div>';

							echo form_open('admin/dashboard/firstadmin', array('role'=>'form'));

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
						<div class="panel-footer text-center">wPanel 11</div>
					</div>
				</div>
			</div>
		</div>

	</body>
</html>