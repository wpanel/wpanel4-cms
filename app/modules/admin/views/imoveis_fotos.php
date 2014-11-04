<link href="<?= base_url('') ?>assets/css/bootstrap.css" rel="stylesheet">
<h3 class="page-header" style="margin-top:0;">Fotos do imóvel</h3>
<script type="text/javascript">
  function apagar() {
      if(confirm('Esta opcao nao podera ser desfeita,\ntem certeza que deseja proseguir ?'))
          return true;
      else return false;
  }
</script>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" nohref>
				Fotos do imóvel
			</a>
		</div>
		<?= form_open_multipart('admin/imoveis/upload_foto', array('class'=>'navbar-form navbar-left')); ?>
			<?= form_input(array('type'=>'hidden', 'name'=>'id', 'value'=>$id)); ?>
			<div class="form-group">
				<!-- <label>Arquivo</label> -->
				<?= form_input(array('type'=>'file', 'name'=>'userfile', 'class'=>'form-controls')); ?>
			</div>
			<button type="submit" class="btn btn-primary"><?= glyphicon('floppy-disk'); ?>Enviar</button>
			<em>Medida ideal para a imagem: 400 X 300</em>
		<?= form_close(); ?>
	</div>
</nav>

<div class="row">
	<div class="col-md-12" style="margin-top:10px;">
		<?php foreach($llista_fotos as $row){ ?>
		<div class="col-xs-6 col-md-3">
			<div class="thumbnail">
				<?=  img('media/fotos_imoveis/'.$row->file); ?>
				<div class="caption">
					<?= anchor('admin/imoveis/delete_foto/'.$row->id, 'Apagar', array('class'=>'btn btn-block btn-danger', 'onclick'=>'return apagar();')); ?>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>