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
<!-- Mostra a lista de álbuns em formato de mosaico. -->
<div class="row">
	<?php
	$num_cols = 1;
	foreach($albuns as $album)
	{
		
		/*
		 * Faz um calculo simples para adequar o total
		 * de colunas à class do bootstrap.
		 */
		$col = 12 / $max_cols;

		?>
		<div class="col-md-<?= $col; ?>">
			<?php
	        // Exibe a imagem de capa caso ela exista.
	        if (file_exists('./media/capas/'.$album->capa)) {
		        ?>
		        <div class="wpn-capa">
					<?php
					$capa = array(
						'src' => '/media/capas/' . $album->capa,
						'class' => 'img-responsive',
						'alt' => $album->titulo
					);
					echo anchor('album/'.$album->id.'/'.wpn_fakelink($album->titulo), img($capa));
					?>
				</div>
				<?php 
			}
			?>
			<h4>
				<?= $album->titulo; ?><br/>
				<small><?= mdate('%d/%m/%Y', strtotime($album->created)); ?></small>
			</h4>
		</div>
		<?php
		// Cria uma nova linha de acordo com a quantidade de ítens por linha.
		if($num_cols == $max_cols){ 
			$num_cols = 1; 
			echo '</div><div class="row">'; 
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