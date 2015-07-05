<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Itens de menu</h3>
        <div class="box-tools pull-right">
            <?= anchor('admin/menuitens/add/'.$menu_id, glyphicon('plus-sign') . 'Novo ítem de menu', array('class'=>'btn btn-warning')); ?>
        </div>
    </div>
    <div class="box-body">
        <?php
        echo div(array('class'=>'table-responsive'));
        echo $listagem;
        echo div(null, true);
        ?>
    </div>
</div>