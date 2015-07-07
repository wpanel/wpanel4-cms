<section class="content-header">
    <h1>
        Usuários
        <small>Gerencie os usuários que administrarão o site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/usuarios'); ?>"><i class="fa fa-users"></i> Usuários</a></li>
        <li>Cadastro de usuário</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Cadastro de usuário</h3>
        </div>
        <div class="box-body">
            <?= form_open_multipart('admin/usuarios/add', array('role'=>'form')); ?>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="name">Nome completo</label>
                            <input type="text" name="name" class="form-control" />
                            <?= form_error('name'); ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="email">Email válido</label>
                            <input type="email" name="email" class="form-control" />
                            <?= form_error('email'); ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="username">Nome de usuário</label>
                            <input type="text" name="username" class="form-control" />
                            <?= form_error('username'); ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" name="password" class="form-control" />
                            <?= form_error('password'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">Foto do usuário</label>
                            <input type="file" name="image" class="form-control" />
                            <?= form_error('image'); ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <?php
                            // Opções de skin
                            $options = array(
                              'black'  => 'Black',
                              'black-light'  => 'Black-Light',
                              'blue'  => 'Blue',
                              'blue-light'  => 'Blue-Light',
                              'green'  => 'Green',
                              'green-light'  => 'Green-Light',
                              'purple'  => 'Purple',
                              'purple-light'  => 'Purple-Light',
                              'red'  => 'Red',
                              'red-light'  => 'Red-Light',
                              'yellow'  => 'Yellow',
                              'yellow-light'  => 'Yellow-Light'
                            );
                            ?>
                            <label for="skin">Estilo de cor</label>
                            <?= form_dropdown('skin', $options, null, null, 'form-control'); ?>
                            <?= form_error('skin'); ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <?php
                            // Opções de grupo
                            $options = array(
                              'admin'  => 'Administrador',
                              'user'    => 'Usuário comum'
                            );
                            ?>
                            <label for="role">Tipo do usuário</label>
                            <?= form_dropdown('role', $options, 'large', null, 'form-control'); ?>
                            <?= form_error('role'); ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <?php
                            // Status do usuário
                            $options = array(
                              '0'  => 'Bloqueado',
                              '1'    => 'Ativo'
                            );
                            ?>
                            <label for="status">Status</label>
                            <?= form_dropdown('status', $options, 'large', null, 'form-control'); ?>
                            <?= form_error('status'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" name="submit" class="btn btn-primary">Cadastrar</button>
                        <?= anchor('admin/usuarios', 'Cancelar', array('class'=>'btn btn-danger')); ?>
                    </div>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>