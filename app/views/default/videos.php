<?php

/**
 * Esta função retorna somente o código do vídeo.
 **/
function get_code_video($var=''){
	$x = explode('v=', $var);
	$y = explode('&', $x[1]);
	return $y[0];
}

?>
<div class="row">
	<div class="col-md-12">
		<h3 class="page-header">Galeria de Vídeos</h3>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?= $this->widget->run('addthisbuttons'); ?>
	</div>
</div>
<div class="row">
	<?php
	$col = 1; // Contador de itens.
	$max_col = 3; // Número máximo de ítens por linha.
	foreach($videos as $item){
		?>
		<div class="col-md-4">
			<div class="Xthumbnail">
				<!-- 400x300 -->
				<?php
				if ($enclosure = $item->get_enclosure())
				{
					$image_properties = array(
						'src' => $enclosure->get_thumbnail(),
						'class' => 'img-responsive'
					);
					echo anchor('video/'.get_code_video($item->get_link()), img($image_properties));
				}
				?>
				<div class="caption">
					<h4><?= $item->get_title(); ?></h4>
				</div>
			</div>
		</div>
		<?php
		// Cria uma nova linha de acordo com a quantidade de ítens por linha.
		if($col == $max_col){ echo '</div><div class="row">'; $col = 1; } else { $col = $col +1; }
	}
?>
</div>