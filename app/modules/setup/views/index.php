<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Setup WPanel | <?= wpn_lang('setup_title', 'First admin creation'); ?></title>
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
				<p class="login-box-msg"><?= wpn_lang('setup_title', 'First admin creation'); ?></p>
				<?php
				$msg_sistema = $this->session->flashdata('msg_auth');
				if ($msg_sistema)
					echo alerts($msg_sistema, 'warning', true);

				echo form_open('setup', array('role'=>'form'));
				?>
				<div class="form-group">
				    <label for="name"><?= wpn_lang('input_fullname', 'Full name'); ?></label>
					<input type="text" name="name" id="name" value="<?= set_value('name'); ?>" class="form-control" />
					<?= form_error('name'); ?>
				</div>
				<div class="form-group">
					<label for="email"><?= wpn_lang('input_validemail', 'Valid email'); ?></label>
					<input type="email" name="email" value="<?= set_value('email'); ?>" class="form-control" />
					<?= form_error('email'); ?>
				</div>
				<div class="form-group">
					<div class="form-group">
						<label for="password"><?= wpn_lang('input_password', 'Password'); ?></label>
						<input type="password" name="password" class="form-control" />
						<?= form_error('password'); ?>
					</div>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="agree" value="1">
						Li e concordo com a <a href="http://wpanel.org/licenca.html" target="_blank">Licença e termos de uso</a>.
					</label>
					<?= form_error('agree'); ?>
				</div>
				<hr/>
				<button type="submit" class="btn btn-primary">
					<?= wpn_lang('bot_next', 'Next').' <span class="glyphicon glyphicon-chevron-right"></span>'; ?>
				</button>
				<?= form_close(); ?>
			</div>
			<p class="text-center" style="padding-top:20px;">&copy; Wpanel CMS <?= date('Y') ?>, <a href="http://wpanel.org/licenca.html" target="_blank"><?= wpn_lang('wpn_licence', 'Terms and licence'); ?></a>. <?= wpn_lang('wpn_developed', 'Developed by'); ?> <a href="http://elieldepaula.com.br" target="_blank">Eliel de Paula</a>.</p>
		</div>px;
	</body>
</html>
