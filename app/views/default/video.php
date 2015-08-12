<div class="row">
	<div class="col-md-12">
		<h3 class="page-header"><?= $video->titulo; ?></h3>
	</div>
</div>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
        <?= $this->widget->run('addthisbuttons'); ?>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="embed-responsive embed-responsive-16by9">
			<iframe src="//www.youtube.com/embed/<?= $video->link; ?>" frameborder="0" allowfullscreen></iframe>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h5>Descrição</h5>
		<p><?= $video->descricao; ?></p>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3>Comentários</h3>
        <?= $this->widget->run('facebookcomments', array('link' => site_url('video/'.$video->link))); ?>
	</div>
</div>