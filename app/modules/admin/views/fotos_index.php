<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <b>Lista de fotos</b>
    </div>
    <div class="panel-body">
        <?= anchor('admin/albuns', glyphicon('chevron-left') . 'Voltar', array('class' => 'btn btn-primary')); ?>
        <?= anchor('admin/fotos/add/'.$album_id, glyphicon('plus-sign') . 'Adicionar foto', array('class' => 'btn btn-primary')); ?>
        <?= anchor('admin/fotos/addmass/'.$album_id, glyphicon('plus-sign') . 'Adicionar foto em massa', array('class' => 'btn btn-primary')); ?>
    </div>
    <?php
    echo div(array('class' => 'table-responsive'));
    echo $listagem;
    echo div(null, true);
    ?>
</div>