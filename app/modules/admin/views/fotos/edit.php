<section class="content-header">
    <h1>
        Álbuns de foto
        <small>Gerencie os álbuns de foto do site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/albuns'); ?>"><i class="fa fa-camera"></i> Álbuns</a></li>
        <li>Alteração de foto</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Alteração de foto</h3>
        </div>
        <div class="box-body">
			<?= form_open_multipart('admin/fotos/edit/'.$row->id, array('role'=>'form')); ?>
				<div class="form-group">
					<label>Selecione a imagem</label>
					<input type="file" name="userfile" class="form-control" />
				</div>
            	<p style="margin-top:15px;"><b>Pré-visualização da imagem:</b></p>
				<?php
            	$data = array(
					'src'=>'media/albuns/'.$row->album_id.'/'.$row->filename, 
					'class'=>'img-responsive img-thumbnail', 
					'style'=>'margin-top:5px;'
				);
				echo img($data);
				?>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="alterar_imagem" value="1" />
						Alterar a imagem.
					</label>
				</div>
				<div class="form-group">
					<label>Descrição</label>
					<input type="text" name="descricao" value="<?= $row->descricao; ?>" class="form-control" />
				</div>
				<div class="form-group">
					<label>Status</label>
					<select name="status" class="form-control">
						<option value="0" <?php if($row->status == 0){ echo 'selected'; } ?> >Indisponível</option>
						<option value="1" <?php if($row->status == 1){ echo 'selected'; } ?> >Publicado</option>
					</select>
				</div>
				<hr/>
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<button type="submit" class="btn btn-primary">Salvar as alterações</button>
						&nbsp; <?= anchor('admin/fotos/index/'.$row->album_id, 'Cancelar', array('class' => 'btn btn-danger')); ?>
					</div>
				</div>
			<?= form_close(); ?>
        </div>
    </div>
</section>
