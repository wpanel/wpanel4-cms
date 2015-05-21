<div class="row" style="margin-bottom: 30px;">
	<div class="col-md-12">
		<h3 class="page-header"><?= $album->titulo; ?></h3>
		<p><?= $album->descricao; ?></p>
		<p><?= mdate('%d/%m/%Y', strtotime($album->created)); ?></p>
		<!-- <hr/> -->
	</div>
</div>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
        <!-- AddThis Button BEGIN -->
         <div class="addthis_toolbox addthis_default_style ">
             <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
             <a class="addthis_button_tweet"></a>
             <a class="addthis_button_pinterest_pinit"></a>
             <a class="addthis_counter addthis_pill_style"></a>
         </div>
         <!-- AddThis Button END -->
    </div>
</div>
<div class="row">
	<?php
	$col = 1; // Contador de ítens.
	$max_col = 3; // Número máximo de ítens por  linha.
	foreach($fotos->result() as $row)
  {
    if($row->status == 1)
    {
      ?>
      <div class="col-md-4">
        <?php
        $conf_foto = array(
              'src' => base_url() . '/media/albuns/' . $album->id . '/' . $row->filename,
              'class' => 'img-responsive',
              'alt' => $row->descricao
            );
            echo anchor('foto/'.$row->id, img($conf_foto));
            ?>
            <h4><?= $row->descricao; ?></h4>
      </div>
      <?php
      // Cria uma nova linha de acordo com a quantidade de ítens por linha.
      if($col == $max_col){ $col = 0; echo '</div><div class="row">'; } else { $col = $col +1; }
    }
	}
	?>
</div>
<div class="row" style="margin-top: 20px;">
	<div class="col-md-12">
		<h3 class="page-header">Comentários</h3>
		<div class="fb-comments"
            data-href="<?php echo site_url('album/' . $album->id); ?>"
            data-num-posts="15" data-width="100%"></div>
	</div>
</div>
