<section class="content-header">
    <h1>
        Contas de usuário
        <small>Gerencie as contas de usuário aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/usuarios'); ?>"><i class="fa fa-users"></i> Contas de usuário</a></li>
        <li>Alteração de conta de usuário</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Alteração de conta de usuário</h3>
        </div>
        <div class="box-body">
            <?= form_open_multipart('admin/accounts/add', array('role'=>'form')); ?>
                <ul class="nav nav-pills" role="tablist" style="margin-bottom:20px;">
                    <li class="active"><a href="#userdata" role="tab" data-toggle="tab">Dados do usuário</a></li>
                    <li><a href="#permissions" role="tab" data-toggle="tab">Permissões</a></li>
                </ul>
                <div class="tab-content">
                    <!--Painel de configuração geral-->
                    <div class="tab-pane active panel panel-default" id="userdata">
                        <div class="panel-heading">
                            Dados do usuário
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nome completo</label>
                                        <input type="text" name="name" value="<?= auth_extra_data('name', $row->extra_data); ?>" class="form-control" />
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
                                        <?= form_error('password'); ?>
                                    </div>
                                </div>
                            </div> <!-- end row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="userfile">Foto do usuário</label>
                                        <input type="file" name="userfile" class="form-control" />
                                        <?= form_error('image'); ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
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
                                        <?= form_dropdown('skin', $options, array(auth_extra_data('skin', $row->extra_data)), array('class'=>'form-control')); ?>
                                        <?= form_error('skin'); ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="role">Tipo do usuário</label>
                                        <?= form_dropdown('role', config_item('auth_account_role'), array($row->role), array('class'=>'form-control')); ?>
                                        <?= form_error('role'); ?>
                                    </div>
                                </div>
                            </div> <!-- end row -->
                        </div>
                    </div>
                    <div class="tab-pane panel panel-default" id="permissions">
                        <div class="panel-heading">
                            Permissões
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        <?php foreach($query_module as $key => $mod){ ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a 
                                                            role="button" 
                                                            class="collapsed"
                                                            data-toggle="collapse" 
                                                            data-parent="#accordion" 
                                                            href="#collapse-<?= $mod['id']; ?>" 
                                                            aria-expanded="true" 
                                                            aria-controls="collapse-<?= $mod['id']; ?>">
                                                            <span class="glyphicon glyphicon-triangle-bottom"></span> <?= $mod['name']; ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse-<?= $mod['id']; ?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th><input type="checkbox" onchange="marcardesmarcar(<?= $mod['id']; ?>)" /></th>
                                                                    <th>Descrição</th>
                                                                    <th>Link</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach($mod['actions'] as $act){ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <input 
                                                                            type="checkbox" 
                                                                            name="permission[]" 
                                                                            value="<?= $act['id']; ?>" 
                                                                            class="marcar-<?= $mod['id']; ?>" 
                                                                            <?php if(has_permission($act['link'], $row->id))echo "checked"; ?>
                                                                            />
                                                                        </td>
                                                                        <td><?= $act['description']; ?></td>
                                                                        <td><?= anchor($act['link'], $act['link'], array('target'=>'_blank')); ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div> <!-- end row -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" name="submit" class="btn btn-primary">Salvar</button>
                        <?= anchor('admin/accounts', 'Cancelar', array('class'=>'btn btn-danger')); ?>
                    </div>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>
<script type="text/javascript">
    function marcardesmarcar(id){
      $('.marcar-'+id).each(
             function(){
               if ($(this).prop( "checked")) 
               $(this).prop("checked", false);
               else $(this).prop("checked", true);               
             }
        );
    }
</script>