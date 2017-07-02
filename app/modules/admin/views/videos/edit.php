<section class="content-header">
    <h1>
        Videos
        <small>Painel de gerenciamento de Videos.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/videos'); ?>"><i class="fa fa-tag"></i> Videos</a></li>
        <li>Alteração de cadastro</li>
    </ol>
</section>
<section class="content">
    <div class="panel panel-default">
        <div class="panel-heading">Alteração de Vídeos</div>
        <div class="panel-body">

            <?= form_open('admin/videos/edit/' . $row->id, array('class' => 'form-horizontal', 'role' => 'form')); ?>
            <div class="form-group">
                <label for="titulo" class="col-sm-2 col-md-2">Titulo</label>
                <div class="col-sm-10 col-md-10">
                    <input type="text"  class="form-control" id="titulo" name="titulo" value="<?= $row->titulo; ?>" >
                    <?= form_error('titulo'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="descricao" class="col-sm-2 col-md-2">Descricao</label>
                <div class="col-sm-10 col-md-10">
                    <textarea class="form-control" id="descricao" name="descricao"  rows=""><?= $row->descricao; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="link" class="col-sm-2 col-md-2">Link</label>
                <div class="col-sm-6 col-md-6">
                    <input type="text"  class="form-control" id="link" name="link" value="https://www.youtube.com/watch?v=<?= $row->link; ?>" >
                    <p class="text-muted"><em>Exemplo: https://www.youtube.com/watch?v=gLBxGhpy_eQ</em></p>
                    <?= form_error('link'); ?>
                </div>
            </div>
            <div class="form-group">
                <?php
                // Status do usuário
                $options = array(
                    '0' => 'Indisponível',
                    '1' => 'Publicado'
                );
                ?>
                <label for="status" class="col-sm-2 col-md-2">Status</label>
                <div class="col-sm-3 col-md-3">
                    <?= form_dropdown('status', $options, array($row->status), array('class' => 'form-control')); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-md-10 col-sm-offset-2 col-md-offset-2">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $row->link; ?>" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <hr/>
            <div class="col-sm-10 col-md-10 col-sm-offset-2 col-md-offset-2">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="<?= site_url('admin/videos'); ?>" class="btn btn-danger">Cancelar</a>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>
