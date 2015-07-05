<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        Agendas de eventos
        <small>Gerencie os eventos que serão exibidos do site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><i class="fa fa-calendar"></i> Agendas</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de eventos</h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/agendas/add', glyphicon('plus-sign') . 'Novo evento', array('class' => 'btn btn-primary')); ?>
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