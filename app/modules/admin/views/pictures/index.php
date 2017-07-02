<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        Álbuns de picture
        <small>Gerencie os álbuns de picture do site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/galleries'); ?>"><i class="fa fa-camera"></i> Álbuns</a></li>
        <li>Fotos</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de pictures</h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/galleries', glyphicon('chevron-left') . 'Voltar', array('class' => 'btn btn-sm btn-primary')); ?>
                <?= anchor('admin/pictures/add/'.$album_id, glyphicon('plus-sign') . 'Adicionar fotos', array('class' => 'btn btn-sm btn-primary')); ?>
                <?= anchor('admin/pictures/addmass/'.$album_id, glyphicon('plus-sign') . 'Adicionar fotos em massa', array('class' => 'btn btn-sm btn-primary')); ?>
            </div>
        </div>
        <div class="box-body">
            <?= $listagem; ?>
        </div>
    </div>
</section>