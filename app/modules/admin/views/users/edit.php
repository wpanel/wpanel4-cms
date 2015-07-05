<section class="content-header">
    <h1>
        Usuários
        <small>Gerencie os usuários que administrarão o site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/users'); ?>"><i class="fa fa-users"></i> Usuários</a></li>
        <li>Alteração de usuário</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Alteração de usuário</h3>
        </div>
        <div class="box-body">
            <?php

            $input_open = '<div class="form-group">';
            $input_close = '</div>';

            echo form_open('admin/usuarios/edit/'.$id, array('role'=>'form'));

            echo $input_open;
            echo form_label('Nome completo', 'name');
            echo form_input(array('name'=>'name', 'value'=> $row->name, 'class'=>'form-control'));
            echo form_error('name');
            echo $input_close;

            echo $input_open;
            echo form_label('Email válido', 'email');
            echo form_input(array('name'=>'email', 'value'=> $row->email, 'type'=>'email', 'class'=>'form-control'));
            echo form_error('email');
            echo $input_close;

            echo $input_open;
            echo form_label('Nome de usuário', 'username');
            echo form_input(array('name'=>'username', 'value'=> $row->username, 'class'=>'form-control'));
            echo form_error('username');
            echo $input_close;

            echo $input_open;
            echo form_label('Senha', 'password');
            echo form_password(array('name'=>'password', 'class'=>'form-control'));
            echo form_error('password');
            echo $input_close;

            echo '<div class="checkbox">';
            echo '<label>';
            echo form_checkbox('alterar_senha', '1', false);
            echo ' Alterar a senha</label>';
            echo $input_close;

            // Opções de grupo
            $options = array(
                              'admin'  => 'Administrador',
                              'user'    => 'Usuário comum'
                            );

            echo $input_open;
            echo form_label('Grupo', 'role');
            echo form_dropdown('role', $options, array($row->role), null, 'form-control');
            echo $input_close;

            // opções de status
            $options = array(
                              '0'  => 'Bloqueado',
                              '1'    => 'Ativo'
                            );

            echo $input_open;
            echo form_label('Status', 'status');
            echo form_dropdown('status', $options, array($row->status), null, 'form-control');
            echo $input_close;

            echo form_button(array('type'=>'submit', 'name'=>'submit', 'content'=>'Salvar alterações', 'class'=>'btn btn-primary'));
            echo '&nbsp;';
            echo anchor('admin/usuarios', 'Cancelar', array('class'=>'btn btn-danger'));

            echo form_close();
            ?>
        </div>
    </div>
</section>