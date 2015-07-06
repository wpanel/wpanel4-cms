<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        Páginas
        <small>Gerencie as páginas fixas do site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><i class="fa fa-files-o"></i> Páginas</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de páginas</h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/pages/add', glyphicon('plus-sign') . 'Nova página', array('class' => 'btn btn-sm btn-primary')); ?>
            </div>
        </div>
        <div class="box-body">
            <?= $listagem; ?>
        </div>
    </div>
</section>