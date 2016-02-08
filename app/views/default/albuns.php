<div class="row">
	<div class="col-md-12">
		<h3 class="page-header">Álbuns de Fotos</h3>
	</div>
</div>
<div class="row wpn-social-buttons">
	<div class="col-md-12">
		<?= wpn_widget('addthisbuttons'); ?>      
	</div>
</div>
<div class="row">
	<?php
	$col = 1; // Contador de ítens.
	$max_col = 3; // Número máximo de ítens por  linha.
	foreach($albuns->result() as $row)
	{
		if($row->status == 1)
		{
			?>
			<div class="col-md-4">
				<?php
				$capa = array(
					'src' => base_url() . '/media/capas/' . $row->capa,
					'class' => 'img-responsive',
					'alt' => $row->titulo
				);
				echo anchor('album/' . $row->id, img($capa));
				?>
				<h4>
					<?= $row->titulo; ?><br/>
					<small><?= mdate('%d/%m/%Y', strtotime($row->created)); ?></small>
				</h4>
			</div>
			<?php
			// Cria uma nova linha de acordo com a quantidade de ítens por linha.
			if($col == $max_col){ $col = 1; echo '</div><div class="row">'; } else { $col = $col +1; }
		}
	}
	?>
</div>