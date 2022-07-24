<h1 class="page-header">Área do usuário</h1>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation"><?= anchor('users', 'Dashboard'); ?></li>
            <li role="presentation" class="active"><?= anchor('users/profile', 'Meus dados'); ?></li>
            <li role="presentation"><?= anchor('users/logout', 'Sair'); ?></li>
        </ul>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <p>Use o formulário abaixo para atualiar seus dados.</p>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <?= form_open('users/profile', array('role' => 'form', 'class' => 'form-horizontal',)); ?>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Nome</label>
                <div class="col-sm-5">
                    <input type="text" name="name" id="name" value="<?= $profile->name ?>" class="form-control"  />
                    <?= form_error('name'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">E-mail</label>
                <div class="col-sm-5">
                    <input type="text" name="email" id="email" value="<?= $account->email; ?>" class="form-control" />
                </div>
            </div>
        
            <!-- Dados adicionais de exemplo -->
            <!-- <div class="form-group">
                <label for="demo" class="col-sm-2 control-label">Demo</label>
                <div class="col-sm-5">
                    <input type="text" name="demo" id="demo" value="<?hp // $profile->demo ?>" class="form-control"  />
                    <?php // form_error('demo'); ?>
                </div>
            </div> -->
            <!--Fim : Dados adicionais de exemplo --> 
            
            <div class="form-group">
                <div class="checkbox col-sm-offset-2 col-sm-5">
                    <label>
                        <input type="checkbox" name="alt_password" value="1"/> Alterar a senha.
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="new_password" class="col-sm-2 control-label">Nova senha</label>
                <div class="col-sm-3">
                    <input type="password" name="new_password" id="new_password" class="form-control" />
                    <?= form_error('new_password'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="confirm_password" class="col-sm-2 control-label">Confirmação</label>
                <div class="col-sm-3">
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" />
                    <?= form_error('confirm_password'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="original_password" class="col-sm-2 control-label">Senha atual</label>
                <div class="col-sm-3">
                    <input type="password" name="original_password" id="original_password" class="form-control" />
                    <?= form_error('original_password'); ?>
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-5">
                    <button type="submit" class="btn btn-primary" >Salvar</button>
                    <?= anchor('users', 'Cancelar', array('class' => 'btn btn-danger')); ?>
                </div>
            </div>
        <?= form_close(); ?>
    </div>
</div>
