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
		Dashboard
		<small>Seja bem vindo ao WPanel CMS.</small>
	</h1>
	<ol class="breadcrumb">
		<li><i class="fa fa-dashboard"></i> Dashboard</li>
	</ol>
</section>
<section class="content">
	<div class="box">
		<div class="box-body">
			<div class="row">
				<div class="col-md-3 hidden-xs"><img src="<?= $avatar; ?>" class="img-responsive" alt="<?= login_userobject('name'); ?>"/></div>
				<div class="col-md-4">
					<h2>Olá <?= login_userobject('name'); ?>.</h2>
					<p><?= login_userobject('name'); ?> - <?= login_userobject('email'); ?></p>
					<p>Cadastrado em <?= datetime_for_user(login_userobject('created'), 0); ?></p>
					<p><?= anchor('admin/usuarios/profile', 'Alterar meus dados', array('class'=>'btn btn-primary')); ?></p>
				</div>
				<div class="col-md-5">
					<h4>Resumo do seu conteúdo</h4>
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>Postagens</td>
								<td><?php echo badge($total_posts); ?></td>
							</tr>
							<tr>
								<td>Páginas</td>
								<td><?php echo badge($total_paginas); ?></td>
							</tr>
							<tr>
								<td>Banners</td>
								<td><?php echo badge($total_banners); ?></td>
							</tr>
							<tr>
								<td>Agendas</td>
								<td><?php echo badge($total_agendas); ?></td>
							</tr>
							<tr>
								<td>Álbuns e foto</td>
								<td><?php echo badge($total_albuns); ?></td>
							</tr>
							<tr>
								<td>Vídeos</td>
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
					<span class="glyphicon glyphicon-list-alt"></span> Gerenciar Postagens
					</a>
				</div>
				<div class="col-md-4" style="margin-top:10px;">
					<a 
					href="<?= site_url('admin/pages'); ?>" 
					class="btn btn-primary btn-lg btn-block" 
					style="padding-top:30px;padding-bottom:30px;">
						<span class="glyphicon glyphicon-list-alt"></span> Gerenciar Páginas
					</a>
				</div>
				<div class="col-md-4" style="margin-top:10px;">
					<a 
					href="<?= site_url('admin/banners'); ?>" 
					class="btn btn-primary btn-lg btn-block" 
					style="padding-top:30px;padding-bottom:30px;">
						<span class="glyphicon glyphicon-align-justify"></span> Gerenciar Banners
					</a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4" style="margin-top:10px;">
					<a 
					href="<?= site_url('admin/usuarios'); ?>" 
					class="btn btn-warning btn-lg btn-block" 
					style="padding-top:30px;padding-bottom:30px;">
						<span class="glyphicon glyphicon-user"></span> Gerenciar Usuários
					</a>
				</div>
				<div class="col-md-4" style="margin-top:10px;">
					<a 
					href="<?= site_url('admin/configuracoes'); ?>" 
					class="btn btn-danger btn-lg btn-block" 
					style="padding-top:30px;padding-bottom:30px;">
						<span class="glyphicon glyphicon-cog"></span> Configurações
					</a>
				</div>
				<div class="col-md-4" style="margin-top:10px;">
					<a 
					href="<?= site_url(); ?>" target="_blank" 
					class="btn btn-success btn-lg btn-block" 
					style="padding-top:30px;padding-bottom:30px;">
						<span class="glyphicon glyphicon-globe"></span> Visualizar o site
					</a>
				</div>
			</div>
		</div>
	</div>
</section>