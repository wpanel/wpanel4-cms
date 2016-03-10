<?php

// Captura o avatar do usuário.
$avatar = login_userobject('image');
if($avatar)
	$avatar = base_url('media/avatar') . '/'.$avatar;
else
	$avatar = base_url('lib/img') . '/no-user.jpg';

?>
<section class="content-header">
	<h1>
		<?= wpn_lang('mod_dashboard', 'Dashboard'); ?>
		<small><?= wpn_lang('wpn_welcome', 'Welcome to WPanel CMS'); ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><i class="fa fa-dashboard"></i> <?= wpn_lang('mod_dashboard', 'Dashboard'); ?></li>
	</ol>
</section>
<section class="content">
	<div class="box">
		<div class="box-body">
			<div class="row">
				<div class="col-md-3 hidden-xs"><img src="<?= $avatar; ?>" class="img-responsive img-thumbnail" alt="<?= login_userobject('name'); ?>"/></div>
				<div class="col-md-4">
					<h2><?= wpn_lang('wpn_hello', 'Hello'); ?> <?= login_userobject('name'); ?>.</h2>
					<p><?= login_userobject('name'); ?> - <?= login_userobject('email'); ?></p>
					<p><?= wpn_lang('wpn_since', 'Since'); ?> <?= datetime_for_user(login_userobject('created'), 0); ?></p>
					<p><?= anchor('admin/usuarios/profile', wpn_lang('lnk_manageprofile','Manage my profile'), array('class'=>'btn btn-primary')); ?></p>
				</div>
				<div class="col-md-5">
					<h4><?= wpn_lang('wpn_sumary', 'Sumary'); ?></h4>
					<table class="table table-striped">
						<tbody>
							<tr>
								<td><?= wpn_lang('mod_post', 'Posts'); ?></td>
								<td><?php echo badge($total_posts); ?></td>
							</tr>
							<tr>
								<td><?= wpn_lang('mod_page', 'Pages'); ?></td>
								<td><?php echo badge($total_paginas); ?></td>
							</tr>
							<tr>
								<td><?= wpn_lang('mod_banner', 'Banners'); ?></td>
								<td><?php echo badge($total_banners); ?></td>
							</tr>
							<tr>
								<td><?= wpn_lang('mod_event', 'Events'); ?></td>
								<td><?php echo badge($total_agendas); ?></td>
							</tr>
							<tr>
								<td><?= wpn_lang('mod_Galery', 'Galery'); ?></td>
								<td><?php echo badge($total_albuns); ?></td>
							</tr>
							<tr>
								<td><?= wpn_lang('mod_video', 'Videos'); ?></td>
								<td><?php echo badge($total_videos); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4" style="margin-top:10px;">
					<a 
					href="<?= site_url('admin/posts'); ?>" 
					class="btn btn-primary btn-lg btn-block" 
					style="padding-top:30px;padding-bottom:30px;">
					<span class="glyphicon glyphicon-list-alt"></span> <?= wpn_lang('bot_manage_posts', 'Manage Posts'); ?>
					</a>
				</div>
				<div class="col-md-4" style="margin-top:10px;">
					<a 
					href="<?= site_url('admin/pages'); ?>" 
					class="btn btn-primary btn-lg btn-block" 
					style="padding-top:30px;padding-bottom:30px;">
						<span class="glyphicon glyphicon-list-alt"></span> <?= wpn_lang('bot_manage_pages', 'Manage Pages'); ?>
					</a>
				</div>
				<div class="col-md-4" style="margin-top:10px;">
					<a 
					href="<?= site_url('admin/banners'); ?>" 
					class="btn btn-primary btn-lg btn-block" 
					style="padding-top:30px;padding-bottom:30px;">
						<span class="glyphicon glyphicon-align-justify"></span> <?= wpn_lang('bot_manage_banners', 'Manage Banners'); ?>
					</a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4" style="margin-top:10px;">
					<a 
					href="<?= site_url('admin/usuarios'); ?>" 
					class="btn btn-warning btn-lg btn-block" 
					style="padding-top:30px;padding-bottom:30px;">
						<span class="glyphicon glyphicon-user"></span> <?= wpn_lang('bot_manage_users', 'Manage Users'); ?>
					</a>
				</div>
				<div class="col-md-4" style="margin-top:10px;">
					<a 
					href="<?= site_url('admin/configuracoes'); ?>" 
					class="btn btn-danger btn-lg btn-block" 
					style="padding-top:30px;padding-bottom:30px;">
						<span class="glyphicon glyphicon-cog"></span> <?= wpn_lang('bot_configurations', 'Configurations'); ?>
					</a>
				</div>
				<div class="col-md-4" style="margin-top:10px;">
					<a 
					href="<?= site_url(); ?>" target="_blank" 
					class="btn btn-success btn-lg btn-block" 
					style="padding-top:30px;padding-bottom:30px;">
						<span class="glyphicon glyphicon-globe"></span> <?= wpn_lang('bot_view_site', 'Visualizar Site'); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>