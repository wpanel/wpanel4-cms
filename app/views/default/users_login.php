<h1 class="page-header">
    Login<br/>
    <small>Efetue seu login ou cadastre-se para ter acesso ao material restrito.</small>
</h1>

<div class="row">
    <div class="col-sm-6 col-sm-6">

        <?= form_open('users/login', array('class'=>'col-sm-10', 'role'=>'form')); ?>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Seu e-mail...">
                <?= form_error('email'); ?>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Sua senha...">
                <?= form_error('password'); ?>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        <?= form_close(); ?>

    </div>
    <div class="col-sm-6 col-sm-6">
        <h3>Cadastre-se!</h3>
        <p>Crie seu cadastro clicando no botão abaixo.</p>
        <p><?= anchor('users/register', 'Cadastro', array('class' => 'btn btn-primary')); ?></p>
    </div>
</div>