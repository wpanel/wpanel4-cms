<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Setup WPanel CMS | First admin creation</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<!-- bootstrap 3.3.4 -->
		<link href="<?= base_url('lib/css') ?>/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- Theme style -->
		<link href="<?= base_url('lib/css') ?>/AdminLTE.css" rel="stylesheet" type="text/css" />
	</head>
	<body class="login-page">
		<div class="login-box">
			<div class="login-logo">
				<b>Setup</b>WPanel CMS
			</div>
			<div class="login-box-body">
				<p class="login-box-msg">First admin creation.</p>
				<?php
				$msg_sistema = $this->session->flashdata('msg_auth');
				if ($msg_sistema)
					echo alerts($msg_sistema, 'warning', true);

				echo form_open('setup', array('role'=>'form'));
				?>
				<div class="form-group">
				    <label for="name">Full name</label>
					<input type="text" name="name" id="name" value="<?= set_value('name'); ?>" class="form-control" />
					<?= form_error('name'); ?>
				</div>
				<div class="form-group">
					<label for="email">Valid Email</label>
					<input type="email" name="email" value="<?= set_value('email'); ?>" class="form-control" />
					<?= form_error('email'); ?>
				</div>
				<div class="form-group">
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" class="form-control" />
						<?= form_error('password'); ?>
					</div>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="agree" value="1">
						I agreee with the <a href="http://wpanel.org/licenca.html" target="_blank">license and terms of use.</a>.
					</label>
					<?= form_error('agree'); ?>
				</div>
				<hr/>
				<button type="submit" class="btn btn-block btn-primary">
					Next <span class="glyphicon glyphicon-chevron-right"></span>
				</button>
				<?= form_close(); ?>
			</div>
			<p class="text-center" style="padding-top:20px;">&copy; Wpanel CMS <?= date('Y') ?>, all rights reserved.<br/>Developed by <a href="http://dotsistemas.com.br" target="_blank">Dot Sistemas</a>.</p>
		</div>
	</body>
</html>
