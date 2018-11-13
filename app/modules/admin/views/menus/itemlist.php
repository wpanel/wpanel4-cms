<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= wpn_lang('module_itens'); ?></h3>
        <div class="box-tools pull-right">
            <?= anchor('admin/menus/additem/'.$menu_id, glyphicon('plus-sign') . wpn_lang('wpn_bot_new'), array('class'=>'btn btn-sm btn-warning')); ?>
        </div>
    </div>
    <div class="box-body">
        <?= $listagem; ?>
    </div>
</div>