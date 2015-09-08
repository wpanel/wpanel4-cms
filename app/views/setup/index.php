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
				<p class="setup-box-msg"><b>Instalação inicial do WPanel CMS.</b></p>
				<p>Seja bem vindo à instalação inicial do WPanel CMS. Antes de clicar em "Proseguir", tenha certeza de ter checado os seguintes passos:</p>
				<p>
					<ol>
						<li>Certifique-se que o seu servidor atende aos <a href="http://wpanelcms.com.br/post/requisitos-minimos.html" target="_blank">requisitos mínimos</a>.</li>
						<li>Crie um novo banco de dados MySql no seu servidor.</li>
						<li>Configure os detalhes da conexão no arquivo /app/config/database.php</li>
					</ol>
				</p>
				<p class="text-center"><?= anchor('setup/migrate', 'Proseguir >>', array('class'=>'btn btn-primary')); ?></p>
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