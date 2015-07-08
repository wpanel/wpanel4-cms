<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
        <?= $this->widgets->addthis_buttons(); ?>
    </div>
</div>
<div class="row">
  <div class="col-md-12">
	<div class="embed-responsive embed-responsive-16by9">
		<iframe src="//www.youtube.com/embed/<?= $code; ?>" frameborder="0" allowfullscreen></iframe>
	</div>
</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3>Comentários</h3>
        <?= $this->widgets->facebook_comments(site_url('video/'.$code)); ?>
	</div>
</div>