<div class="row">
	<div class="col-md-12">
		<h3 class="page-header">Galeria de Vídeos</h3>
	</div>
</div>
<div class="row wpn-social-buttons">
	<div class="col-md-12">
		<?= wpn_widget('addthisbuttons'); ?>
	</div>
</div>
<div class="row">
	<?php
	$num_cols = 1;
	foreach($videos as $video){

		/*
		 * Faz um calculo simples para adequar o total
		 * de colunas à class do bootstrap.
		 */
		$col = 12 / $max_cols;

		?>
		<div class="col-md-<?= $col; ?>">
			<div class="thumbnail">
				<div class="inner-video">
					<?php
					$image_properties = array(
						'src' => 'http://img.youtube.com/vi/'.$video->link.'/0.jpg',
						'class' => 'img-responsive'
					);
					echo anchor('video/'.$video->link.'/'.wpn_fakelink($video->titulo), img($image_properties));
					?>
				</div>
			</div>
			<div class="caption">
				<h4><?= $video->titulo; ?></h4>
			</div>
		</div>
		<?php
		// Cria uma nova linha de acordo com a quantidade de ítens por linha.
		if($num_cols == $max_cols){ 
			echo '</div><div class="row">'; 
			$num_cols = 1; 
		} else $num_cols = $num_cols ++;
	}
?>
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