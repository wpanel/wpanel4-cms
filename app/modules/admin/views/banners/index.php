<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        Banners
        <small>Gerencie os banners exibidos no site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><i class="fa fa-shirtsinbulk"></i> Banners</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de banners</h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/banners/add', glyphicon('plus-sign') . 'Novo banner', array('class' => 'btn btn-primary')); ?>
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