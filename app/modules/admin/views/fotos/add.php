<section class="content-header">
    <h1>
        Álbuns de foto
        <small>Gerencie os álbuns de foto do site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/albuns'); ?>"><i class="fa fa-camera"></i> Álbuns</a></li>
        <li>Cadastro de foto</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Cadastro de foto</h3>
        </div>
        <div class="box-body">
            <?= form_open_multipart('admin/fotos/add/'.$album_id, array('role'=>'form')); ?>
                <div class="form-group">
                    <label>Selecione a imagem</label>
                    <input type="file" name="userfile" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Descrição</label>
                    <input type="text" name="descricao" value="<?= set_value('descricao'); ?>" class="form-control" />
                    <?= form_error('descricao'); ?>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="0">Indisponível</option>
                                <option value="1">Publicado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                        &nbsp; <?= anchor('admin/fotos/index/'.$album_id, 'Cancelar', array('class' => 'btn btn-danger')); ?>
                    </div>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>