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

				$input_open = '<div class="form-group">';
				$input_close = '</div>';

				echo form_open('setup', array('role'=>'form'));

				echo $input_open;
				echo form_label(wpn_lang('input_fullname', 'Full name'), 'name');
				echo form_input(array('name'=>'name', 'value'=> set_value('name'), 'class'=>'form-control'));
				echo form_error('name');
				echo $input_close;

				echo $input_open;
				echo form_label(wpn_lang('input_validemail', 'Valid email'), 'email');
				echo form_input(array('name'=>'email', 'value'=> set_value('email'), 'type'=>'email', 'class'=>'form-control'));
				echo form_error('email');
				echo $input_close;

				echo $input_open;
				echo form_label(wpn_lang('input_password', 'Password'), 'password');
				echo form_password(array('name'=>'password', 'value'=> set_value('password'), 'class'=>'form-control'));
				echo form_error('password');
				echo $input_close;

				echo form_button(array('type'=>'submit', 'name'=>'submit', 'content'=> wpn_lang('bot_next', 'Next').' <span class="glyphicon glyphicon-chevron-right"></span>', 'class'=>'btn btn-primary'));

				echo form_close();

				?>
			</div>
		</div>
	</body>
</html>