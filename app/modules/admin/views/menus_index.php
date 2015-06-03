<div class="panel panel-default">
    <div class="panel-heading">
        <b>Gerenciador de menus</b>
    </div>
    <div class="panel-body">
        <?= anchor('admin/menus/add', glyphicon('plus-sign') . 'Novo menu', array('class'=>'btn btn-primary')); ?>
    </div>
    <ul class="list-group">
        <?= $listagem; ?>
    </ul>
</div>