<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('module_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/accounts'); ?>"><i class="fa fa-users"></i> <?= wpn_lang('module_title'); ?></a></li>
        <li><?= wpn_lang('module_edit'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_edit'); ?></h3>
        </div>
        <div class="box-body">
            <?= form_open_multipart('admin/accounts/edit/'.$row->id, array('role'=>'form')); ?>
                <ul class="nav nav-pills" role="tablist" style="margin-bottom:20px;">
                    <li class="active"><a href="#userdata" role="tab" data-toggle="tab"><?= wpn_lang('tab_userdata'); ?></a></li>
                    <li><a href="#permissions" role="tab" data-toggle="tab"><?= wpn_lang('tab_permissions'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <!--Painel de configuração geral-->
                    <div class="tab-pane active panel panel-default" id="userdata">
                        <div class="panel-heading">
                            <?= wpn_lang('tab_userdata'); ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name"><?= wpn_lang('field_name'); ?></label>
                                        <input type="text" name="name" value="<?= $extra->name; ?>" class="form-control" />
                                        <?= form_error('name'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email"><?= wpn_lang('field_email'); ?></label>
                                        <input type="email" name="email" value="<?= $row->email; ?>" class="form-control" />
                                        <?= form_error('email'); ?>
                                    </div>
                                </div>
                            </div> <!-- end row -->
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="thumbnail">
                                        <?php if($extra->avatar){ ?>
                                            <img src="<?= base_url('media/avatar') . '/'.$extra->avatar; ?>" class="img-responsive" />
                                        <?php } else { ?>
                                            <img src="<?= base_url('lib/img'); ?>/no-user.jpg" class="img-responsive" />
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="userfile"><?= wpn_lang('field_avatar'); ?></label>
                                        <input type="file" name="userfile" class="form-control" />
                                        <input type="hidden" name="avatar" value="<?= $extra->avatar; ?>"/>
                                        <div class="checkbox">
                                            <label>
                                                <?= form_checkbox('change_avatar', '1', false); ?>
                                                <?= wpn_lang('field_change_avatar'); ?>
                                            </label>
                                        </div>
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
                                        <label for="skin"><?= wpn_lang('field_skin'); ?></label>
                                        <?= form_dropdown('skin', $options, array($extra->skin), array('class'=>'form-control')); ?>
                                        <?= form_error('skin'); ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="role"><?= wpn_lang('field_role'); ?></label>
                                        <?= form_dropdown('role', $roles, array($row->role), array('class'=>'form-control')); ?>
                                        <?= form_error('role'); ?>
                                    </div>
                                </div>
                            </div> <!-- end row -->
                        </div>
                    </div>
                    <div class="tab-pane panel panel-default" id="permissions">
                        <div class="panel-heading">
                            <?= wpn_lang('tab_permissions'); ?>
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
                                                                    <th><?= wpn_lang('field_description'); ?></th>
                                                                    <th><?= wpn_lang('field_link'); ?></th>
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
                                                                            <?php if(auth_link_permission($act['link'], $row->id, true))echo "checked"; ?>
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
                        <button type="submit" name="submit" class="btn btn-primary"><?= wpn_lang('wpn_bot_save'); ?></button>
                        <?= anchor('admin/accounts', wpn_lang('wpn_bot_cancel'), array('class'=>'btn btn-danger')); ?>
                    </div>
                    <div class="col-md-6 text-right">
                        <?php
                        if($row->status == 1)
                            echo anchor('admin/accounts/deactivate/'.$row->id, wpn_lang('bot_deactivate'), array('class'=>'btn btn-danger'));
                        else
                            echo anchor('admin/accounts/activate/'.$row->id, wpn_lang('bot_activate'), array('class'=>'btn btn-success'));
                        ?>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".change-password-modal"><?= wpn_lang('bot_change_password'); ?></button>
                    </div>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>

<?= form_open('admin/accounts/changepassword/'.$row->id); ?>
<div class="modal fade change-password-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?= wpn_lang('modal_change_password'); ?>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="password"><?= wpn_lang('field_password'); ?></label>
                            <input type="password" name="password" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><?= wpn_lang('wpn_bot_save'); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?= wpn_lang('wpn_bot_cancel'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>

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
