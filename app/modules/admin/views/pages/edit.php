<?php
echo $this->wpanel->load_editor();
?>

<section class="content-header">
    <h1>
        Páginas
        <small>Gerencie as páginas fixas do site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/pages'); ?>"><i class="fa fa-files-o"></i> Páginas</a></li>
        <li>Alteração de página</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Alteração de página</h3>
        </div>
        <div class="box-body">
            <?php
            echo form_open_multipart('admin/pages/edit/'.$id, array('role'=>'form'));

            echo div(array('class'=>'form-group'));
            echo form_label('Título da página', 'title');
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
            echo col(5);
            echo div(array('class'=>'form-group'));
            echo form_label('Imagem de capa', 'userfile');
            echo form_input(array('name'=>'userfile', 'type'=>'file'));
            if ($row->image) {
              echo img(array('src'=>'media/capas/'.$row->image, 'class'=>'img-responsive img-thumbnail', 'style'=>'margin-top:5px;'));
            }
            echo div(array('class'=>'checkbox'));
            echo '<label>';
            echo form_checkbox(array('name'=>'alterar_imagem', 'value'=>'1', 'class'=>'checkbox'));
            echo ' Alterar a foto.</label>';
            echo close_div(3);

            echo col(4);
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
            echo form_dropdown('status', $options, $row->status, null, 'form-control');
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
            echo anchor('admin/pages', 'Cancelar', array('class'=>'btn btn-danger'));
            echo close_div(3);

            echo form_close();
            ?>
        </div>
    </div>
</section>