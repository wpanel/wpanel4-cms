<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>404 Página não encontrada</title>
		<!-- Bootstrap -->
		<link href="<?php echo config_item('base_url'); ?>lib/css/bootstrap.css" rel="stylesheet">
		<script src="<?php echo config_item('base_url'); ?>lib/js/bootstrap.js"></script>
		<style type="text/css">
			body {
				padding-top: 5%;
				background-color: #eee;
				background: url('<?php echo config_item('base_url'); ?>lib/img/bg-login.jpg');
				background-position: center;
			}

			@media (min-width: 200px){
				.container{
					max-width: 700px;
				}
			}

			.mensagem {
				background-color: #999;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center jumbotron">
					<h1><?php echo $heading; ?></h1>
					<?php echo $message; ?>
					<p><a href="<?php echo config_item('base_url'); ?>" class="btn btn-primary">Voltar para a p&aacute;gina inicial.</a></p>
					<script type="text/javascript">
					var GOOG_FIXURL_LANG = 'pt-BR';
					var GOOG_FIXURL_SITE = '<?php echo config_item('base_url'); ?>'
					</script>
					<script type="text/javascript"
					src="http://linkhelp.clients.google.com/tbproxy/lh/wm/fixurl.js">
					</script>
				</div>
			</div>
		</div>
	</body>
</html>