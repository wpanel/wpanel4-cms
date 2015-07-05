<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        Postagens
        <small>Gerencie os artigos e postagens do site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><i class="fa fa-files-o"></i> Postagens</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de postagens</h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/posts/add', glyphicon('plus-sign') . 'Nova postagem', array('class' => 'btn btn-primary')); ?>
                <?= anchor('admin/categorias', glyphicon('th-list') . 'Categorias', array('class' => 'btn btn-default')); ?>
            </div>
        </div>
        <div class="box-body">
            <?php
            echo div(array('class' => 'table-responsive'));
            echo $listagem;
            echo div(null, true);
            ?>
        </div>
    </div>
</section>