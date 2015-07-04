<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <b>Postagens</b>
    </div>
    <div class="panel-body">
        <?= anchor('admin/posts/add', glyphicon('plus-sign') . 'Nova postagem', array('class' => 'btn btn-primary')); ?>
        <?= anchor('admin/categorias', glyphicon('th-list') . 'Categorias', array('class' => 'btn btn-default')); ?>
    </div>
    <?php
    echo div(array('class' => 'table-responsive'));
    echo $listagem;
    echo div(null, true);
    ?>
</div>