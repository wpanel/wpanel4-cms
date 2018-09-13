<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('module_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><i class="fa fa-reorder"></i> <?= wpn_lang('module_title'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_index'); ?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-sm btn-primary btn-lg" data-toggle="modal" data-target="#new_menu"><?= glyphicon('plus-sign') . wpn_lang('wpn_bot_new'); ?></button>
            </div>
        </div>
        <div class="box-body">
            <ul class="list-group">
		        <?= $listagem; ?>
		    </ul>
        </div>
    </div>
</section>

<!-- Modal new_menu -->
<?= form_open('admin/menus/add', array('role' => 'form')); ?>
    <div class="modal fade" id="new_menu" tabindex="-1" role="dialog" aria-labelledby="new_menu">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="new_menu"><?= wpn_lang('module_add'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nome"><?= wpn_lang('field_nome'); ?></label>
                        <input type="text" name="nome" value="" class="form-control">
                        <?= form_error('nome'); ?>
                    </div>
                    <div class="row " id="">
                        <div class="col-md-2 " id="">
                            <div class="form-group hidden">
                                <label for="posicao"><?= wpn_lang('field_position'); ?></label>
                                <select name="posicao" disabled="">
                                    <option value="0"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 " id="">
                            <div class="form-group hidden">
                                <label for="estilo"><?= wpn_lang('field_style'); ?></label>
                                <select name="estilo" disabled="">
                                    <option value="lista">Lista</option>
                                    <option value="linha">Linha</option>
                                    <option value="coluna">Coluna</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?= wpn_lang('wpn_bot_cancel'); ?></button>
                    <button type="submit" class="btn btn-success"><?= wpn_lang('wpn_bot_save'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?= form_close(); ?>
