<div class="row">
  <div class="col-md-12">
    <h3>Vídeo</h3>
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
		<div class="fb-comments" 
            data-href="<?= site_url('video/'.$code); ?>" 
            data-num-posts="15" data-width="100%"></div>
	</div>
</div>