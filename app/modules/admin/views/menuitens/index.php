<div class="panel panel-default">
    <div class="panel-heading">
        <b>Itens do menus</b>
    </div>
    <div class="panel-body">
        <?= anchor('admin/menuitens/add/'.$menu_id, glyphicon('plus-sign') . 'Novo ítem de menu', array('class'=>'btn btn-warning')); ?>
    </div>
    <?php
    echo div(array('class'=>'table-responsive'));
    echo $listagem;
    echo div(null, true);
    ?>
</div>