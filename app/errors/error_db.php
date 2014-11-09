<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Erro na basse de dados</title>
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
					max-width: 800px;
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
					<?php echo '<p>' . anchor('/', 'Página inicial', array('class'=>'btn btn-primary')) . '</p>';?>
				</div>
			</div>
		</div>
	</body>
</html>