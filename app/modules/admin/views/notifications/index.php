<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        <?= wpn_lang('module_title') ?>
        <small><?= wpn_lang('module_description') ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard') ?></a></li>
        <li><i class="fa fa-bell-o"></i> <?= wpn_lang('module_title') ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_index') ?></h3>
        </div>
        <div class="box-body">
            
            <div class="table-responsive">
                <div class="container-fluid">
                    <?= $listagem; ?>
                </div>
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