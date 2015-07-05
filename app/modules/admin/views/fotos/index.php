<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        Álbuns de foto
        <small>Gerencie os álbuns de foto do site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/albuns'); ?>"><i class="fa fa-camera"></i> Álbuns</a></li>
        <li>Fotos</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de fotos</h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/albuns', glyphicon('chevron-left') . 'Voltar', array('class' => 'btn btn-primary')); ?>
                <?= anchor('admin/fotos/add/'.$album_id, glyphicon('plus-sign') . 'Adicionar foto', array('class' => 'btn btn-primary')); ?>
                <?= anchor('admin/fotos/addmass/'.$album_id, glyphicon('plus-sign') . 'Adicionar foto em massa', array('class' => 'btn btn-primary')); ?>
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