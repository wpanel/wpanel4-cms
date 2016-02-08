<div class="row">
	<div class="col-md-12">
		<h3 class="page-header"><?= $album->titulo; ?></h3>
		<p><?= $album->descricao; ?></p>
		<p><?= mdate('%d/%m/%Y', strtotime($album->created)); ?></p>
		<!-- <hr/> -->
	</div>
</div>

<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
        <?= wpn_widget('addthisbuttons'); ?>      
    </div>
</div>

<div class="row">
	<div class="col-md-12">
		<?php
		$conf_foto = array(
        	'src' => base_url() . '/media/albuns/' . $album->id . '/' . $foto->filename,
        	'class' => 'img-responsive',
        	'alt' => $foto->descricao
        );
        echo img($conf_foto);
        ?>
        <h4><?= $foto->descricao; ?></h4>
	</div>
</div>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12">
		<h3 class="page-header">Comentários</h3>
        <?= wpn_widget('facebookcomments', array('link' => site_url('foto/'.$foto->id))); ?>
	</div>
</div>