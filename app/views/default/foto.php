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
        	'src' => '/media/albuns/' . $album->id . '/' . $picture->filename,
        	'class' => 'img-responsive',
        	'alt' => $picture->descricao
        );
        echo img($conf_foto);
        ?>
        <h4><?= $picture->descricao; ?></h4>
	</div>
</div>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12">
		<h3 class="page-header">Comentários</h3>
        <?= wpn_widget('facebookcomments', array('link' => site_url('foto/'.$picture->id))); ?>
	</div>
</div>

<div class="row wpn-ads">
    <div class="col-md-12">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-0286050943868335"
             data-ad-slot="6888761431"
             data-ad-format="auto"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
</div>