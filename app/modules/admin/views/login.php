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
				padding-top: 10%;
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
								<span class="glyphicon glyphicon-user"></span>&nbsp;<b>Login de usuários</b>
							</h3>
						</div>
						<!-- Corpo do painel -->
						<div class="panel-body">
							<?php
							$msg_sistema = $this->session->flashdata('msg_auth');

							if ($msg_sistema) {
								echo alerts($msg_sistema, 'warning', true);
							}
							echo form_open('admin/login', array('role' => 'form'));
							?>
							<div class="form-group">
								<label class="control-label" for="email">Email</label>
								<input class="form-control" id="email" name="email" placeholder="Seu email..." type="email">
								<?php echo form_error('email');?>
							</div>
							<div class="form-group">
								<label class="control-label" for="password">Senha</label>
								<input class="form-control" id="password" name="password" placeholder="Sua senha..." type="password">
								<?php echo form_error('password');?>
							</div>
							<p>
								<button type="submit" class="btn btn-lg btn-primary btn-block">
									<span class="glyphicon glyphicon-log-in"></span>&nbsp;Entrar
								</button>
							</p>
							<p class="text-center">
								<?= anchor('admin/repass', 'Recuperar senha'); ?>
							</p>
							<?php 
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