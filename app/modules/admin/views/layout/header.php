<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Admin WPanel</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<!-- Bootstrap 3.3.4 -->
		<link href="<?= base_url('lib/css') ?>/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- Font Awesome Icons -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<!-- Ionicons -->
		<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
		<!-- Theme style -->
		<link href="<?= base_url('lib/css') ?>/AdminLTE.min.css" rel="stylesheet" type="text/css" />
		<!-- AdminLTE Skins. -->
		<link href="<?= base_url('lib/css') ?>/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<?php 
	$skin = login_userobject('skin');
	if($skin == '')
		$skin = 'blue';

	$avatar = login_userobject('image');
	if($avatar)
		$avatar = base_url('media/avatar') . '/'.$avatar;
	else
		$avatar = base_url('lib/img') . '/no-user.jpg';
	
	$msg_sistema = $this->session->flashdata('msg_sistema'); 

	?>

	<body <?php if($msg_sistema) echo "onload=\"sysmsg('".$msg_sistema."');\""; ?> class="skin-<?= $skin; ?> sidebar-mini">

	<!-- Site wrapper -->
	<div class="wrapper">

		<header class="main-header">
			<!-- Logo -->
			<a href="<?= site_url('admin'); ?>" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><b>A</b>WP</span>
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg"><b>Admin</b>WPanel</span>
			</a>
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top" role="navigation">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Navegação</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</a>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<!-- User Account: style can be found in dropdown.less -->
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?= $avatar; ?>" class="user-image" alt="<?= login_userobject('name'); ?>"/>
								<span class="hidden-xs"><?= login_userobject('name'); ?></span>
							</a>
							<ul class="dropdown-menu">
								<!-- User image -->
								<li class="user-header">
									<img src="<?= $avatar; ?>" class="img-circle" alt="<?= login_userobject('name'); ?>" />
									<p>
										<?= login_userobject('name'); ?>
										<small>Cadastrado em <?= datetime_for_user(login_userobject('created'), false); ?></small>
									</p>
								</li>
								<!-- Menu Footer-->
								<li class="user-footer">
									<div class="pull-left">
										<?= anchor('admin/usuarios/profile', glyphicon('user') . 'Perfil', array('class'=>'btn btn-primary btn-flat')); ?>
									</div>
									<div class="pull-right">
										<?= anchor('/admin/logout', glyphicon('off') . 'Sair', array('class'=>'btn btn-danger btn-flat')); ?>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<!-- Left side column. contains the sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<!-- Sidebar user panel -->
				<div class="user-panel">
					<div class="pull-left image">
						<img src="<?= $avatar; ?>" class="img-circle" alt="<?= login_userobject('name'); ?>" />
					</div>
					<div class="pull-left info">
						<p><?= login_userobject('name'); ?></p>
					</div>
				</div>
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<ul class="sidebar-menu">
					<li class="header">OPÇÕES PRINCIPAIS</li>
					<li <?= active_link('dashboard'); ?>>
						<?= anchor('admin/dashboard', '<i class="fa fa-dashboard"></i> <span>Dashboard</span>'); ?>
					</li>
					<li <?= active_link('posts'); ?>>
						<?= anchor('admin/posts', '<i class="fa fa-files-o"></i> <span>Postagens</span>'); ?>
					</li>
					<li <?= active_link('pages'); ?>>
						<?= anchor('admin/pages', '<i class="fa fa-files-o"></i> <span>Páginas</span>'); ?>
					</li>
					<li <?= active_link('agendas'); ?>>
						<?= anchor('admin/agendas', ' <i class="fa fa-calendar"></i> <span>Agenda de eventos</span>'); ?>
					</li>
					<li <?= active_link('banners'); ?>>
						<?= anchor('admin/banners', '<i class="fa fa-shirtsinbulk"></i> <span>Banners</span>'); ?>
					</li>
					<li <?= active_link('albuns'); ?>
						<?= active_link('fotos'); ?>><?= anchor('admin/albuns', '<i class="fa fa-camera"></i> <span>Albuns de fotos</span>'); ?>
					</li>
					<li <?= active_link('videos'); ?>> 
						<?= anchor('admin/videos', '<i class="fa fa-film"></i> <span>Vídeos</span>'); ?>
					</li>
					<li <?= active_link('menus'); ?> <?= active_link('menuitens'); ?>><?= anchor('admin/menus', '<i class="fa fa-reorder"></i> <span>Gerenciador de menus</span>'); ?>
					</li>
					<li <?= active_link('newsletters'); ?>>
						<?= anchor('admin/newsletters', '<i class="fa fa-envelope-o"></i> <span>Newsletters</span>'); ?>
					</li>
					<li <?= active_link('usuarios'); ?>>
						<?= anchor('admin/usuarios', '<i class="fa fa-users"></i> <span>Usuários</span>'); ?>
					</li>
					<li <?= active_link('configuracoes'); ?>>
						<?= anchor('admin/configuracoes', '<i class="fa fa-cog"></i> <span>Configurações</span>'); ?>
					</li>
				</ul>
			</section>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">