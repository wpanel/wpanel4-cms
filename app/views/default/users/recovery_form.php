<h1 class="page-header">Recuperação de senha</h1>
<p>Indique seu e-mail abaixo para iniciar o processo de recuperação de senha.</p>
<?= form_open('users/recovery'); ?>
<div class="row">
    <div class="col-sm-4 col-md-4">
        <div class="form-group">
            <label>Informe seu email</label>
            <input type="text" name="email" class="form-control" placeholder="Informe seu email..." />
            <?= form_error('email'); ?>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
        <?= anchor('users/login', 'Voltar', array('class' => 'btn btn-danger')); ?>
    </div>
</div>
<?= form_close(); ?>