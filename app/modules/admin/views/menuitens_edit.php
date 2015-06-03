<form method="post" action="<?= site_url('admin/menuitens/edit/' . $row->id); ?>" role="form">
    <input type="hidden" name="menu_id" value="<?= $row->menu_id; ?>" />
    <div class="form-group">
        <label for="label">Label do link</label>
        <input type="text" name="label" id="label" value="<?= $row->label; ?>" class="form-control" />
        <?= form_error('label'); ?>
    </div>
    <div class="form-group">
        <p><label for="tipo">Tipo de link</label></p>
        <div class="radio">
            <label id="tipo_link">
                <input type="radio" name="tipo" id="tipo_link" value="link" <?php if($row->tipo == 'link'){ echo 'checked="checked"'; } ?> />
                Link externo
            </label>
            <label>
                <input type="radio" name="tipo" id="tipo_post" value="post" <?php if($row->tipo == 'post'){ echo 'checked="checked"'; } ?> />
                Página ou postagem
            </label>
            <label>
                <input type="radio" name="tipo" id="tipo_posts" value="posts" <?php if($row->tipo == 'posts'){ echo 'checked="checked"'; } ?> />
                Lista de postagens
            </label>
            <label>
                <input type="radio" name="tipo" id="tipo_funcional" value="funcional" <?php if($row->tipo == 'funcional'){ echo 'checked="checked"'; } ?> />
                Página funcional
            </label>
        </div>
        <?= form_error('tipo'); ?>
    </div>   
    <div class="form-group" id="form_link"<?php if($row->tipo == 'link'){ echo 'style="display:block;"'; } else {echo 'style="display:none;"';} ?>>
        <label for="link">Link externo</label>
        <input type="text" name="link" id="link" value="<?= $row->href; ?>" class="form-control" />
        <?= form_error('link'); ?>
    </div>
    <div class="form-group" id="form_post" <?php if($row->tipo == 'post'){ echo 'style="display:block;"'; } else {echo 'style="display:none;"';} ?>>
        <label for="post_id">Página ou Postagem</label>
        <select class="form-control" name="post_id" id="post_id">
            <?php
            foreach ($posts as $row_post)
            {
                if($row->href == $row_post->id){ $select = 'selected="selected"';}
                echo '<option value="' . $row_post->link . '" '.$select . '>' . $row_post->title . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group" id="form_posts" <?php if($row->tipo == 'posts'){ echo 'style="display:block;"'; } else {echo 'style="display:none;"';} ?>>
        <label for="categoria_id">Listagem de categoria</label>
        <select class="form-control" name="categoria_id" id="categoria_id">
            <?php
            foreach ($categorias as $row_cat)
            {
                if($row->href == $row_cat->id){ $select = 'selected="selected"';}
                echo '<option value="' . $row_cat->id . '" '.$select . '>' . $row_cat->title . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group" id="form_funcional" <?php if($row->tipo == 'funcional'){ echo 'style="display:block;"'; } else {echo 'style="display:none;"';} ?>>
        <label for="funcional">Página funcional</label>
        <select class="form-control" name="funcional" id="funcional">
            <option value="home" <?php if($row->href == 'home'){ echo 'selected="selected"';} ?>>Página inicial</option>
            <option value="contato" <?php if($row->href == 'contato'){ echo 'selected="selected"';} ?>>Página de contato</option>
            <option value="albuns" <?php if($row->href == 'fotos'){ echo 'selected="selected"';} ?>>Galeria de fotos</option>
            <option value="videos" <?php if($row->href == 'videos'){ echo 'selected="selected"';} ?>>Galeria de videos</option>
        </select>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="ordem">Ordem de exibição</label>
                <input type="text" name="ordem" id="ordem" value="<?= $row->ordem; ?>" class="form-control" />
                <?= form_error('ordem'); ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Salvar as alterações</button>
        <?= anchor('admin/menus', 'Cancelar', array('class' => 'btn btn-danger')); ?>
    </div>
</form>