<?php
echo $this->wpanel->load_editor();
?>
<section class="content-header">
    <h1>
        <?= wpn_lang('mod_post', 'Posts'); ?>
        <small><?= wpn_lang('desc_post', 'Manage articles and post of the site.'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('mod_dashboard', 'Dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/posts'); ?>"><i class="fa fa-files-o"></i> <?= wpn_lang('mod_post', 'Posts'); ?></a></li>
        <li><?= wpn_lang('wpn_update_record', 'Update record'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Alteração de postagem</h3>
        </div>
        <div class="box-body">
            <?php
            echo form_open_multipart('admin/posts/edit/'.$id, array('role'=>'form'));

            echo div(array('class'=>'form-group'));
            echo form_label('Título da postagem', 'title');
            echo form_input(array('name'=>'title', 'value'=> $row->title, 'class'=>'form-control'));
            echo form_error('title');
            echo close_div();

            echo div(array('class'=>'form-group'));
            echo form_label('Descrição para os mecanismos de busca (No máximo 160 caracteres.)', 'description');
            echo form_textarea(array('name'=>'description', 'value'=> $row->description, 'class'=>'form-control', 'rows'=>'3'));
            echo form_error('description');
            echo close_div();

            echo div(array('class'=>'form-group'));
            echo form_label('Conteúdo', 'content');
            echo form_textarea(array('name'=>'content', 'value'=> $row->content, 'class'=>'form-control ckeditor', 'id'=>'editor'));
            echo form_error('content');
            echo close_div();

            echo row();
            echo col(3);
            echo div(array('class'=>'form-group'));
            echo form_label('Imagem de capa', 'userfile');
            echo form_input(array('name'=>'userfile', 'type'=>'file', 'class'=>'form-control'));
            if(file_exists('./media/capas/'.$row->image)){
                echo img(array('src'=>'media/capas/'.$row->image, 'class'=>'img-responsive img-thumbnail', 'style'=>'margin-top:5px;'));
            } else {
                echo '<p>Arquivo inexistente</p>';
            }
            echo div(array('class'=>'checkbox'));
            echo '<label>';
            echo form_checkbox(array('name'=>'alterar_imagem', 'value'=>'1', 'class'=>'checkbox'));
            echo ' Alterar a foto.</label>';
            echo close_div(3);

            echo col(3);
            echo div(array('class'=>'form-group'));
            echo form_label('Categorias', 'category_id');
            echo form_multiselect('category_id[]', $categorias, $cat_select, array('class'=>'form-control'));
            echo anchor('admin/categorias',glyphicon('share').' Cadastro de categorias');
            echo close_div(2);

            echo col(3);
            echo div(array('class'=>'form-group'));
            echo form_label('Palavras-chave (Separe com vírgula)', 'tags');
            echo form_textarea(array('name'=>'tags', 'value'=> $row->tags, 'class'=>'form-control', 'rows'=>'5'));
            echo close_div(2);

            // Opções de status
            $options = array(
                              '0'  => 'Rascunho',
                              '1'  => 'Publicado'
                            );
            echo col(3);
            echo div(array('class'=>'form-group'));
            echo form_label('Status', 'status');
            echo form_dropdown('status', $options, $row->status, array('class'=>'form-control'));
            echo close_div(3);

            echo hr();

            echo row();
            echo col();
            echo form_button(
                    array(
                      'type'=>'submit', 
                      'name'=>'submit', 
                      'content'=>'Salvar as alterações', 
                      'class'=>'btn btn-primary'
                      )
                    );
            echo nbs(); // &nbsp;
            echo anchor('admin/posts', 'Cancelar', array('class'=>'btn btn-danger'));
            echo close_div(2);

            echo form_close();
            ?>
        </div>
    </div>
</section>