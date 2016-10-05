<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        IP's banidos
        <small>Módulo gerenciador de IP's banidos.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/accounts'); ?>"><i class="fa fa-users"></i> Contas de usuário</a></li>
        <li><i class="fa fa-cog"></i> IP's banidos</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Listagem</h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/accounts', glyphicon('user') . 'Contas de usuários', array('class' => 'btn btn-sm btn-info')); ?>
                <?= anchor('admin/ipbanneds/add', glyphicon('plus-sign') . 'Novo registro', array('class' => 'btn btn-sm btn-primary')); ?>
            </div>
        </div>
        <div class="box-body">
            <?= $listagem; ?>
        </div>
    </div>
</section>