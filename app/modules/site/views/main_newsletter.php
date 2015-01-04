<h3>Newsletter</h3>
<hr/>
<?php

// Mensagens do sistema;
$msg_newsletter = $this->session->flashdata('msg_newsletter');

if($msg_newsletter){
echo alerts($msg_newsletter, 'warning', true);
}

?>
<p>Cadastre seu email e receba nossas novidades em primeira mão.</p>
<div class="col-md-9">
	<?= form_open('newsletter', array('role'=>'form')); ?>
		<div class="form-group">
			<label class="control-label" for="nome">Nome</label>
			<input class="form-control" name="nome" id="nome" value="<?= set_value('nome'); ?>" placeholder="Seu nome..." type="text">
			<?= form_error('nome'); ?>
		</div>
		<div class="form-group">
			<label class="control-label" for="email">Email</label>
			<input class="form-control" name="email" id="email" value="<?= set_value('email'); ?>" placeholder="Seu email..." type="text">
			<?= form_error('email'); ?>
		</div>
		<button type="submit" class="btn btn-primary">
			<span class="glyphicon glyphicon-envelope"></span> Salvar os dados
		</button>
	<?= form_close(); ?>
</div>