<section class="content-header">
    <h1>
        Álbuns de foto
        <small>Gerencie os álbuns de foto do site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/albuns'); ?>"><i class="fa fa-camera"></i> Álbuns</a></li>
        <li>Cadastro de foto em massa</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Cadastro de foto em massa</h3>
        </div>
        <div class="box-body">
            <?php

            echo form_open_multipart('admin/fotos/addmass/'.$album_id, array('role'=>'form'));

            echo div(array('class'=>'form-group'));
            echo form_label('Selecione as imagens', 'fotos');
            echo form_input(array('name'=>'fotos[]', 'type'=>'file', 'multiple'=>'multiple'));
            echo form_error('fotos');
            echo close_div();

            echo div(array('class'=>'form-group'));
            echo form_label('Descrição', 'descricao');
            echo form_input(array('name'=>'descricao', 'value'=> set_value('descricao'), 'class'=>'form-control'));
            echo form_error('descricao');
            echo close_div();

            echo row();

            // Opções de status
            $options = array(
                              '0'  => 'Indisponível',
                              '1'  => 'Publicado'
                            );

            echo col(3);
            echo div(array('class'=>'form-group'));
            echo form_label('Status', 'status');
            echo form_dropdown('status', $options, null, null, 'form-control');
            echo close_div(3);

            echo hr();

            echo row();
            echo col();
            echo form_button(
                    array(
                      'type'=>'submit',
                      'name'=>'submit',
                      'content'=>'Cadastrar',
                      'class'=>'btn btn-primary'
                      )
                    );
            echo nbs(); // &nbsp;
            echo anchor('admin/fotos/index/'.$album_id, 'Cancelar', array('class'=>'btn btn-danger'));
            echo close_div(2);

            echo form_close();
            ?>
        </div>
    </div>
</section>