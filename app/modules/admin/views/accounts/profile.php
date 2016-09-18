<section class="content-header">
    <h1>
        <?= wpn_lang('mod_profile', 'Account profile'); ?>
        <small>Mantenha seus dados sempre atualizados.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><?= wpn_lang('mod_profile', 'Account profile'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Alteração de perfil do usuário</h3>
        </div>
        <div class="box-body">
            <?= form_open_multipart('admin/accounts/profile', array('role'=>'form')); ?>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="name">Nome completo</label>
                            <input type="text" name="name" value="<?= $extra_data->name; ?>" class="form-control" />
                            <?= form_error('name'); ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="email">Email válido</label>
                            <input type="email" name="email" value="<?= $row->email; ?>" class="form-control" />
                            <?= form_error('email'); ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" name="password" class="form-control" />
                            <div class="checkbox">
                                <label>
                                    <?= form_checkbox('alterar_senha', '1', false); ?>
                                    Alterar a senha
                                </label>
                            </div>
                            <?= form_error('password'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="userfile">Foto do usuário</label>
                            <input type="file" name="userfile" class="form-control" />
                            <div class="checkbox">
                                <label>
                                    <?= form_checkbox('alterar_imagem', '1', false); ?>
                                    Alterar a foto
                                </label>
                            </div>
                            <?= form_error('image'); ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <?php if($extra_data->avatar){ ?>
                            <img src="<?= base_url('media/avatar') . '/'.$extra_data->avatar; ?>" class="img-responsive" width="120" />
                        <?php } else { ?>
                            <img src="<?= base_url('lib/img'); ?>/no-user.jpg" class="img-responsive" width="120" />
                        <?php } ?>
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
                            <?= form_dropdown('skin', $options, array($extra_data->skin), array('class'=>'form-control')); ?>
                            <?= form_error('skin'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" name="submit" class="btn btn-primary">Salvar alterações</button>
                        <?= anchor('admin/dashboard', 'Cancelar', array('class'=>'btn btn-danger')); ?>
                    </div>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>