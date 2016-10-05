<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>
        Contas de usuário
        <small>Gerencie as contas de usuário aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><i class="fa fa-users"></i> Contas de usuário</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de contas</h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/accounts/add', glyphicon('plus-sign') . 'Novo cadastro', array('class' => 'btn btn-sm btn-primary')); ?>
                <?= anchor('admin/ipbanneds', glyphicon('ban-circle') . 'IP\'s banidos ', array('class' => 'btn btn-sm btn-danger')); ?>
            </div>
        </div>
        <div class="box-body">
            <?= $listagem; ?>
        </div>
    </div>
</section>