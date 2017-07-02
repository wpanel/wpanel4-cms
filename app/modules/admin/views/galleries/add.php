<section class="content-header">
    <h1>
        Álbuns de foto
        <small>Gerencie os álbuns de foto do site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/galleries'); ?>"><i class="fa fa-camera"></i> Álbuns</a></li>
        <li>Cadastro de álbum</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Cadastro de álbum</h3>
        </div>
        <div class="box-body">
            <?= form_open_multipart('admin/galleries/add', array('role' => 'form')); ?>
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" value="<?= set_value('titulo'); ?>" class="form-control" />
                <?= form_error('titulo'); ?>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea name="descricao" rows="5" class="form-control"><?= set_value('descricao'); ?></textarea>
                <?= form_error('descricao'); ?>
            </div>
            <div class="row">
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <label for="userfile">Imagem de capa</label>
                        <input type="file" name="userfile" class="form-control" />
                    </div>
                </div>
                <div class="col-sm-3 col-md-3">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
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
                    &nbsp;<?= anchor('admin/galleries', 'Cancelar', array('class' => 'btn btn-danger')); ?>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>
