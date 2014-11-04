<h3>Fale conosco</h3>
<hr/>
<?php

// Mensagens do sistema;
$msg_contato = $this->session->flashdata('msg_contato');

if($msg_contato){
    echo alerts($msg_contato, 'warning', true);
}

?>
<div class="row">
    <div class="col-sm-offset-2 col-md-10">
        <?= $conf->texto_contato; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        
        <?= form_open('contato', array('class'=>'form-horizontal', 'role'=>'form')); ?>
            <div class="form-group">
                <div class="col-sm-2">
                    <label for="nome" class="control-label">Nome</label>
                </div>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Seu nome...">
                    <?= form_error('nome'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label for="email" class="control-label">Email</label>
                </div>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Seu email...">
                    <?= form_error('email'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label for="telefone" class="control-label">Telefone</label>
                </div>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="telefone" id="telefone" placeholder="Seu telefone...">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label for="mensagem" class="control-label">Mensagem</label>
                </div>
                <div class="col-sm-10">
                    <textarea class="form-control" name="mensagem" id="mensagem" rows="8"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <?= $captcha; ?>
                    Digite o que voce está lendo na imagem no campo abaixo.
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label for="captcha" class="control-label">Confirmação</label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="captcha" id="captcha" placeholder="Texto de confirmação...">
                    <?= form_error('captcha'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Enviar a mensagem</button>
                </div>
            </div>
        <?= form_close(); ?>

    </div>
</div>