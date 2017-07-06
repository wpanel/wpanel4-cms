<section class="content-header">
    <h1>
        Módulos
        <small>Gerencia os módulos do sistema.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/modulos'); ?>"><i class="fa fa-cog"></i> Módulos</a></li>
        <li>Cadastro</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Formulário de cadastro</h3>
        </div>
        <div class="box-body">
            <form action="<?= site_url('admin/modulos/add'); ?>" role="form" class="form-horizontal" method="post" accept-charset="utf-8">

                <div class="form-group">
                    <label for="id" class="col-sm-2 col-md-2 control-label">Nome</label>
                    <div class="col-sm-10 col-md-10">
                        <input type="text" name="name" id="name" class="form-control" />
                        <?= form_error('name'); ?>
                    </div>
                </div>

<!--                <div class="form-group">
                    <label for="id" class="col-sm-2 col-md-2 control-label">Ícone</label>
                    <div class="col-sm-10 col-md-10">
                        <input type="text" name="icon" id="icon" class="form-control" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 col-md-10 col-md-offset-2 com-sm-offset-2">
                        <label><input type="checkbox" name="show_in_menu" id="show_in_menu" value="1" /> Mostrar no menu</label>
                    </div>
                </div>-->

                <hr/>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 col-md-offset-2 col-md-10">
                        <button type="submit" class="btn btn-primary" >Salvar</button>
                        <?= anchor('admin/modulos', 'Cancelar', array('class' => 'btn btn-danger')); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>