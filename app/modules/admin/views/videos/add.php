<section class="content-header">
	<h1>
		Videos
		<small>Painel de gerenciamento de Videos.</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?= site_url('admin/videos'); ?>"><i class="fa fa-tag"></i> Videos</a></li>
		<li>Novo cadastro</li>
	</ol>
</section>
<section class="content">
	<div class="panel panel-default">
		<div class="panel-heading">Novo cadastro de Videos</div>
		<div class="panel-body">
			<form action="<?= site_url('admin/videos/add'); ?>" method="post" role="form" >
				<div class="form-group">
					<label for="titulo">Titulo</label>
					<input type="text"  class="form-control" id="titulo" name="titulo" value="" placeholder="">
				</div>
				<div class="form-group">
					<label for="descricao">Descricao</label>
					<textarea class="form-control" id="descricao" name="descricao" placeholder="" rows=""></textarea>
				</div>
				<div class="form-group">
					<label for="link">Link</label>
					<input type="text"  class="form-control" id="link" name="link" value="" placeholder="">
				</div>
				<div class="form-group">
					<?php
                    // Status do usuário
                    $options = array(
						'0'  => 'Indisponível',
						'1'    => 'Publicado'
                    );
                    ?>
                    <label for="status">Status</label>
                    <?= form_dropdown('status', $options, null, null, 'form-control'); ?>
				</div>
				<button type="submit" class="btn btn-success">Salvar</button>
				<a href="<?= site_url('admin/videos'); ?>" class="btn btn-danger">Cancelar</a>
			</form>
		</div>
	</div>
</section>