<!-- <div style="background-color:#ff9;border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;"> -->
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert">
		<span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span>
	</button>

	<h4>Um erro de PHP foi encontrado</h4>

	<p><b>Gravidade:</b> <?php echo $severity; ?></p>
	<p><b>Mensagem:</b>  <?php echo $message; ?></p>
	<p><b>Arquivo:</b> <?php echo $filepath; ?></p>
	<p><b>Linha:</b> <?php echo $line; ?></p>

</div>