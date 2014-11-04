<div class="row">
	<div class="col-md-12">
		<h3><?php echo $titulo_pagina; ?></h3>
		<hr/>
	</div>
	<div class="col-md-12">
		<?php
		foreach ($posts->result() as $key => $value) {
		?>
		<div>
			<h4>
				<?php echo $value->title; ?> <br/>
				<small><?php echo mdate('%d/%m/%Y', strtotime($value->created)); ?> | <?php echo $this->wpanel->categorias_do_post($value->id); ?></small>
			</h4>
			<p>
				<?php echo word_limiter(strip_tags($value->content), 30); ?>
			</p>
			<p>
				<?php echo anchor('post/'.$value->link, 'Leia mais...'); ?>
			</p>
		</div>
		<?php
		}
		?>
	</div>
</div>