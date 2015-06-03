<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <b>Páginas</b>
    </div>
    <div class="panel-body">
        <?= anchor('admin/pages/add', glyphicon('plus-sign') . 'Nova página', array('class' => 'btn btn-primary')); ?>
    </div>
    <?php
    echo div(array('class' => 'table-responsive'));
    echo $listagem;
    echo div(null, true);
    ?>
</div>