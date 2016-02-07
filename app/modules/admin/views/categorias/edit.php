<section class="content-header">
    <h1>
        Categorias
        <small>Gerencie as categorias de postagens.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/categorias'); ?>"><i class="fa fa-tag"></i> Categorias</a></li>
        <li>Alteração de categoria</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Alteração de categoria</h3>
        </div>
        <div class="box-body">
            <?php 
            echo form_open('admin/categorias/edit/'.$row->id, array('role'=>'form'));

            echo div(array('class'=>'form-group'));
            echo form_label('Título', 'title');
            echo form_input(array('name'=>'title', 'value'=> $row->title, 'class'=>'form-control'));
            echo form_error('title');
            echo div(null, true);

            echo div(array('class'=>'form-group'));
            echo form_label('Descrição', 'description');
            echo form_textarea(array('name'=>'description', 'value'=> $row->description,'class'=>'form-control'));
            echo div(null, true);

            echo row();
            echo col(6);

            echo div(array('class'=>'form-group'));
            echo form_label('Categoria-pai', 'category_id');
            echo form_dropdown('category_id', $options, array($row->category_id), array('class'=>'form-control'));

            echo close_div(2);
            echo col(6);

            $options = config_item('posts_views');

            echo div(array('class'=>'form-group'));
            echo form_label('Tipo de visualização', 'view');
            echo form_dropdown('view', $options, [$row->view], array('class'=>'form-control'));

            echo close_div(3);
            //000
            // echo div(array('class'=>'form-group'));
            // echo form_label('Categoria-pai', 'category_id');
            // echo form_dropdown('category_id', $options, array($row->category_id), null, 'form-control');
            // echo div(null, true);
            //000
            echo form_button(array('type'=>'submit', 'name'=>'submit', 'content'=>'Salvar as alterações', 'class'=>'btn btn-primary'));
            echo '&nbsp;';
            echo anchor('admin/categorias', 'Cancelar', array('class'=>'btn btn-danger'));

            echo form_close();
            ?>
        </div>
    </div>
</section>