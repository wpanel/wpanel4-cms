<section class="content-header">
    <h1>
        Menus
        <small>Gerencie os menús e opções de navegação do site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/menus'); ?>"><i class="fa fa-reorder"></i> Menus</a></li>
        <li>Cadastro de ítem de menu</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Cadastro de ítem de menu</h3>
        </div>
        <div class="box-body">
            <form method="post" action="<?= site_url('admin/menuitens/add/' . $menu_id); ?>" role="form">
                <div class="form-group">
                    <label for="label">Label do link</label>
                    <input type="text" name="label" id="label" class="form-control" />
                    <?= form_error('label'); ?>
                </div>
                <div class="form-group">
                    <p><label for="tipo">Tipo de link</label></p>
                    <div class="radio">
                        <label id="tipo_link">
                            <input type="radio" name="tipo" id="tipo_link" value="link" checked="checked" />
                            Link externo
                        </label>
                        <label>
                            <input type="radio" name="tipo" id="tipo_post" value="post" />
                            Página ou postagem
                        </label>
                        <label>
                            <input type="radio" name="tipo" id="tipo_posts" value="posts" />
                            Lista de postagens
                        </label>
                        <label>
                            <input type="radio" name="tipo" id="tipo_funcional" value="funcional" />
                            Página funcional
                        </label>
                        <label>
                            <input type="radio" name="tipo" id="tipo_submenu" value="submenu" />
                            Sub-Menu
                        </label>
                    </div>
                    <?= form_error('tipo'); ?>
                </div>
                <div class="form-group" id="form_link">
                    <label for="link">Link externo</label>
                    <input type="text" name="link" id="link" class="form-control" />
                    <?= form_error('link'); ?>
                </div>
                <div class="form-group" id="form_post" style="display: none;">
                    <label for="post_id">Página ou Postagem</label>
                    <select class="form-control" name="post_id" id="post_id">
                        <?php
                        foreach ($posts as $row_post)
                        {
                            echo '<option value="' . $row_post->link . '">' . $row_post->title . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group" id="form_posts" style="display: none;">
                    <label for="categoria_id">Listagem de categoria</label>
                    <select class="form-control" name="categoria_id" id="categoria_id">
                        <?php
                        foreach ($categorias as $row_cat)
                        {
                            echo '<option value="' . $row_cat->id . '">' . $row_cat->title . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group" id="form_funcional" style="display: none;">
                    <label for="funcional">Página funcional</label>
                    <select class="form-control" name="funcional" id="funcional">
                        <option value="home">Página inicial</option>
                        <option value="contato">Página de contato</option>
                        <option value="albuns">Galeria de fotos</option>
                        <option value="videos">Galeria de videos</option>
                        <option value="events">Lista de eventos</option>
                        <option value="rss">Página de RSS</option>
                    </select>
                </div>
                <div class="form-group" id="form_submenu" style="display: none;">
                    <label for="funcional">Sub-menu</label>
                    <select class="form-control" name="submenu" id="funcional">
                        <option value="">[Selecione um menu]</option>
                        <?php foreach($menus as $row_menu){ ?>
                        <option value="<?= $row_menu->id; ?>"><?= $row_menu->nome; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="ordem">Ordem de exibição</label>
                            <input type="text" name="ordem" id="ordem" class="form-control" />
                            <?= form_error('ordem'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    <?= anchor('admin/menus', 'Cancelar', array('class' => 'btn btn-danger')); ?>
                </div>
            </form>
        </div>
    </div>
</section>