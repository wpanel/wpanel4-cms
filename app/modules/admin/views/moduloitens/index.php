<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        moduloitens
        <small>Módulo gerenciador moduloitens.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><i class="fa fa-cog"></i> moduloitens</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Listagem</h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/moduloitens/add', glyphicon('plus-sign') . 'Novo registro', array('class' => 'btn btn-sm btn-primary')); ?>
            </div>
        </div>
        <div class="box-body">
            <?= $listagem; ?>
        </div>
    </div>
</section>