<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <b>Albuns de fotos</b>
    </div>
    <div class="panel-body">
        <?= anchor('admin/albuns/add', glyphicon('plus-sign') . 'Novo álbum', array('class' => 'btn btn-primary')); ?>
    </div>
    <?php
    echo div(array('class' => 'table-responsive'));
    echo $listagem;
    echo div(null, true);
    ?>
</div>