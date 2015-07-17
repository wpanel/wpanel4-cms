<!DOCTYPE html>
<html>
    <head>

        <title><?= $wpn_title; ?></title>

        <?= $wpn_meta; ?>

        <!-- Bootstrap -->
        <link href="<?= $wpn_assets; ?>/css/bootstrap.min.css" rel="stylesheet">
        <!-- Estilo do layout -->
        <link href="<?= $wpn_assets; ?>/css/template.css" rel="stylesheet">
        <!-- jQuery -->
        <script src="<?= $wpn_assets; ?>/js/jquery-2.1.4.min.js"></script>

        <script src="<?= $wpn_assets; ?>/js/bootstrap.min.js" type="text/javascript"></script>

        <?= $wpn_header_addthis; ?>

        <?= $wpn_header_facebook; ?>

        <?= $wpn_background; ?>

    </head>
    <body>

		<div class="container wpn-corpo">
			<div class="row">
				<div class="col-md-12">
					<?= $this->widget->run('slidebanner', array('position'=>'slide')); ?>
				</div>
			</div>
			<div class="row">
				<nav class="navbar navbar-default">
					<div class="container">
						<div class="navbar-header">
							<a class="navbar-brand" href="<?= site_url(); ?>">
								<!-- Use uma logomarca ou o título -->
								<?php//= $wpn_logomarca; ?>
								<?= $wpn_title; ?>
							</a>
						</div>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<?= $this->widget->run('wpanelmenu', array('menu_id' => 1, 'class_menu' => 'nav navbar-nav navbar-left')); ?>
						</div>
					</div>
				</nav>
			</div>
			<div class="row">
				<div class="col-md-9">
