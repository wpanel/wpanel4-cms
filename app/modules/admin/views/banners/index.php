<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        Banners
        <small>Gerencie os banners exibidos no site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><i class="fa fa-shirtsinbulk"></i> Banners</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de banners</h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/banners/add', glyphicon('plus-sign') . 'Novo banner', array('class' => 'btn btn-sm btn-primary')); ?>
            </div>
        </div>
        <div class="box-body">
            <table id="grid" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Posição</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($query as $row){
                        ?>
                        <tr>
                            <td><?= $row->id; ?></td>
                            <td><?= $row->title; ?></td>
                            <td><?= $options[$row->position]; ?></td>
                            <td><?= status_post($row->status); ?></td>
                            <td>
                                <div class="btn-group btn-group-xs">
                                    <?= anchor('admin/banners/edit/'.$row->id, glyphicon('edit'), array('class' => 'btn btn-default')); ?>
                                    <button class="btn btn-default" onClick="return confirmar('<?= site_url('admin/banners/delete/'.$row->id); ?>');"><?= glyphicon('trash'); ?></button>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>