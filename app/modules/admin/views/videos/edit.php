<section class="content-header">
	<h1>
		Videos
		<small>Painel de gerenciamento de Videos.</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?= site_url('admin/videos'); ?>"><i class="fa fa-tag"></i> Videos</a></li>
		<li>Alteração de cadastro</li>
	</ol>
</section>
<section class="content">

<div class="panel panel-default">
	<div class="panel-heading">Alteração de Videos</div>
	<div class="panel-body">

		<form action="<?= site_url('admin/videos/edit/'.$row->id); ?>" method="post" role="form" >
			<div class="form-group">
				<label for="titulo">Titulo</label>
				<input type="text"  class="form-control" id="titulo" name="titulo" value="<?= $row->titulo; ?>" placeholder="">
			</div>
			<div class="form-group">
				<label for="descricao">Descricao</label>
				<textarea class="form-control" id="descricao" name="descricao" placeholder="" rows=""><?= $row->descricao; ?></textarea>
			</div>
			<div class="form-group">
				<label for="link">Link</label>
				<input type="text"  class="form-control" id="link" name="link" value="https://www.youtube.com/watch?v=<?= $row->link; ?>" placeholder="">
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
                <?= form_dropdown('status', $options, array($row->status), array('class'=>'form-control')); ?>
			</div>
			<div class="form-group">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $row->link; ?>" frameborder="0" allowfullscreen></iframe>
			</div>
			<button type="submit" class="btn btn-success">Salvar</button>
			<a href="<?= site_url('admin/videos'); ?>" class="btn btn-danger">Cancelar</a>
		</form>

	</div>
</div>
</section>
