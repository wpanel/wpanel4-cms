<section class="content-header">
    <h1>
        Álbuns de foto
        <small>Gerencie os álbuns de foto do site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/albuns'); ?>"><i class="fa fa-camera"></i> Álbuns</a></li>
        <li>Alteração de álbum</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Alteração de álbum</h3>
        </div>
        <div class="box-body">
            <?php

            echo form_open_multipart('admin/albuns/edit/'.$row->id, array('role'=>'form'));

            echo div(array('class'=>'form-group'));
            echo form_label('Título do álbum', 'titulo');
            echo form_input(array('name'=>'titulo', 'value'=> $row->titulo, 'class'=>'form-control'));
            echo form_error('titulo');
            echo close_div();

            echo div(array('class'=>'form-group'));
            echo form_label('Descrição', 'descricao');
            echo form_textarea(array('name'=>'descricao', 'value'=> $row->descricao, 'class'=>'form-control', 'rows'=>'5'));
            echo form_error('descricao');
            echo close_div();

            echo row();
            echo col(5);
            echo div(array('class'=>'form-group'));
            echo form_label('Imagem de capa', 'userfile');
            echo form_input(array('name'=>'userfile', 'type'=>'file', 'class'=>'form-control'));
            echo '<p style="margin-top:15px;"><b>Pré-visualização da imagem de capa:</b></p>';
            echo img(array('src'=>'media/capas/'.$row->capa, 'class'=>'img-responsive img-thumbnail', 'style'=>'margin-top:5px;'));
            echo div(array('class'=>'checkbox'));
            echo '<label>';
            echo form_checkbox(array('name'=>'alterar_imagem', 'value'=>'1', 'class'=>'checkbox'));
            echo ' Alterar a imagem.</label>';
            echo close_div(3);

            // Opções de status
            $options = array(
                              '0'  => 'Indisponível',
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
            echo anchor('admin/albuns', 'Cancelar', array('class'=>'btn btn-danger'));
            echo close_div(2);

            echo form_close();
            ?>
        </div>
    </div>
</section>