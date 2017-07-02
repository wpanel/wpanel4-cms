<section class="content-header">
    <h1>
        Álbuns de foto
        <small>Gerencie os álbuns de foto do site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/galleries'); ?>"><i class="fa fa-camera"></i> Álbuns</a></li>
        <li>Alteração de álbum</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Alteração de álbum</h3>
        </div>
        <div class="box-body">
            <?= form_open_multipart('admin/galleries/edit/' . $row->id, array('role' => 'form')); ?>
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" value="<?= $row->titulo; ?>" class="form-control" />
                <?= form_error('titulo'); ?>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea name="descricao" rows="5" class="form-control"><?= $row->descricao; ?></textarea>
                <?= form_error('descricao'); ?>
            </div>
            <div class="row">
                <div class="col-sm-5 col-md-5">
                    <div class="form-group">
                        <label for="userfile">Imagem de capa</label>
                        <input type="file" name="userfile" class="form-control" />
                        <p style="margin-top:15px;"><b>Pré-visualização da imagem de capa:</b></p>
                        <?php
                        $data = array(
                            'src' => 'media/capas/' . $row->capa,
                            'class' => 'img-responsive img-thumbnail',
                            'style' => 'margin-top:5px;'
                        );
                        echo img($data);
                        ?>
                        <label>
                            <input type="checkbox" name="alterar_imagem" value="1" />
                            Alterar a imagem.
                        </label>
                    </div>
                </div>
                <div class="col-sm-3 col-md-3">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="0" <?php if ($row->status == 0) {
                            echo 'selected';
                        } ?>>Indisponível</option>
                            <option value="1" <?php if ($row->status == 1) {
                            echo 'selected';
                        } ?>>Publicado</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary">Salvar as alterações</button>
                    &nbsp;<?= anchor('admin/galleries', 'Cancelar', array('class' => 'btn btn-danger')); ?>
                </div>
            </div>
<?= form_close(); ?>
        </div>
    </div>
</section>