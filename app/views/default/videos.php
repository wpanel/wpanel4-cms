<div class="row">
	<div class="col-md-12">
		<h3 class="page-header">Galeria de Vídeos</h3>
	</div>
</div>
<div class="row wpn-social-buttons">
	<div class="col-md-12">
		<?= $this->widget->runit('addthisbuttons'); ?>
	</div>
</div>
<div class="row">
	<?php
	$col = 1; // Contador de itens.
	$max_col = 3; // Número máximo de ítens por linha.
	foreach($query as $row){
		?>
		<div class="col-md-4">
			<div class="thumbnail">
				<div class="inner-video">
					<!-- 400x300 -->
					<?php
					$image_properties = array(
						'src' => 'http://img.youtube.com/vi/'.$row->link.'/0.jpg',
						'class' => 'img-responsive'
					);
					echo anchor('video/'.$row->link, img($image_properties));
					?>
				</div>
			</div>
			<div class="caption">
				<h4><?= $row->titulo; ?></h4>
			</div>
		</div>
		<?php
		// Cria uma nova linha de acordo com a quantidade de ítens por linha.
		if($col == $max_col){ echo '</div><div class="row">'; $col = 1; } else { $col = $col +1; }
	}
?>
</div>