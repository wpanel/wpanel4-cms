<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        Categorias
        <small>Gerencie as categorias de postagens.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><i class="fa fa-tag"></i> Categorias</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de categorias</h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/categorias/add', glyphicon('plus-sign') . 'Nova categoria', array('class' => 'btn btn-sm btn-primary')); ?>
            </div>
        </div>
        <div class="box-body">
            
             <div class="table-responsive">
                <?= $listagem; ?>
            </div>
            
            <hr/>

            <div class="row" style="margin-bottom: 20px;">
                <div class="col-sm-12 col-md-12">
                    <span class="total"><?= wpn_lang('pag_total_of'); ?> <b><?= $total_rows; ?></b> <?= wpn_lang('pag_records'); ?>.</span>
                    <nav class="text-center">
                        <?= $pagination_links; ?>
                    </nav>
                </div>
            </div>
            
        </div>
    </div>
</section>