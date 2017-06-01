<!--<div class="panel panel-default">-->
    <h1 class="page-header">Alteração de dados pessoais</h1>
    <!--<div class="panel-body">-->
        <?= form_open('account/profile', array('role' => 'form', 'class' => 'form-horizontal',)); ?>
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
        <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Senha <b>(*)</b></label>
            <div class="col-sm-3">
                <input type="password" name="password" id="password" class="form-control" />
                <?= form_error('password'); ?>
            </div>
        </div>
        <hr/>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" >Salvar</button>
                <?= anchor('', 'Cancelar', array('class' => 'btn btn-danger')); ?>
            </div>
        </div>
        </form>		
    <!--</div>-->
<!--</div>-->
<script type="text/javascript">
    $(document).ready(function () {
        <?php if ($row->tipo == 'PF') echo 'form_pf();'; else echo 'form_pj();'; ?>
    });
</script>