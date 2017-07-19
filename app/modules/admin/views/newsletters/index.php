<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small>Exporte os emails para newsletter.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><i class="fa fa-envelope-o"></i> <?= wpn_lang('module_title'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de contatos</h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/newsletters/export', glyphicon('download').wpn_lang('bot_export_csv'), array('class' => 'btn btn-success')); ?>
                <button class="btn btn-danger" onClick="return confirmar('<?= site_url('admin/newsletters/clear'); ?>');"><?= glyphicon('trash'); ?> <?= wpn_lang('bot_clear_table'); ?></button>
            </div>
        </div>
        <div class="box-body">
            <p class="text-danger">
                <?= wpn_lang('news_note'); ?>
            </p>

            <table id="grid" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?= wpn_lang('field_name') ?></th>
                        <th><?= wpn_lang('field_email') ?></th>
                        <th><?= wpn_lang('field_created_on') ?></th>
                        <th><?= wpn_lang('field_ip'); ?></th>
                    </tr>
                </thead>
                <tbody class="sortable">
                    <?php
                    foreach($contatos as $row){
                        ?>
                        <tr id="item-<?= $row->id; ?>" style="cursor:move;">
                            <td><?= $row->id; ?></td>
                            <td><?= $row->nome; ?></td>
                            <td><?= $row->email; ?></td>
                            <td><?= datetime_for_user($row->created_on); ?></td>
                            <td><?= $row->ipaddress; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</section>
