<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('module_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><i class="fa fa-envelope-o"></i> <?= wpn_lang('module_title'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_index'); ?></h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/newsletters/export', glyphicon('download').wpn_lang('bot_export_csv'), array('class' => 'btn btn-sm btn-success')); ?>
                <?= anchor('admin/newsletters/clear', glyphicon('trash').wpn_lang('bot_clear_table'), array('class' => 'btn btn-sm btn-danger', 'data-confirm' => wpn_lang('message_confirm'))); ?>
            </div>
        </div>
        <div class="box-body">
            <p class="text-danger">
                <?= wpn_lang('news_note'); ?>
            </p>
            
            <div class="table-responsive">
                <div class="container-fluid">
                    
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
                                    <td><?= mdate(config_item('user_date_format'), strtotime($row->created_on)); ?></td>
                                    <td><?= $row->ipaddress; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
