<h1 class="page-header">Alteração de dados pessoais</h1>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation"><?= anchor('users', 'Dashboard'); ?></li>
            <li role="presentation" class="active"><?= anchor('users/profile', 'Profile'); ?></li>
            <li role="presentation"><?= anchor('users/logout', 'Sair'); ?></li>
        </ul>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <?= form_open('users/profile', array('role' => 'form', 'class' => 'form-horizontal',)); ?>
        <div class="form-group">
            <label for="name" id="lb_nome" class="col-sm-3 control-label">Nome <b>(*)</b></label>
            <div class="col-sm-9">
                <input type="text" name="name" id="name" value="<?= $extra->name; ?>" class="form-control"  />
                <?= form_error('name'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-3 control-label">E-mail <b>(*)</b></label>
            <div class="col-sm-5">
                <input type="text" name="email" id="email" value="<?= $row->email; ?>" class="form-control" />
                <?= form_error('email'); ?>
            </div>
        </div>
        <!--Coloque seus campos adicionais aqui.-->
        <hr/>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" >Salvar</button>
                <?= anchor('', 'Cancelar', array('class' => 'btn btn-danger')); ?>
                <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#myModal">Alterar senha</button>
            </div>
        </div>
        </form>		
    </div>
</div>

<!--Modal alterar senha-->
<?= form_open('users/change_password'); ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Alterar senha</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="password" class="control-label">Senha atual</label>
                    <input type="password" name="actual_password" id="password" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Nova senha</label>
                    <input type="password" name="new_password" id="password" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Confirme a senha</label>
                    <input type="password" name="conf_password" id="password" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>