<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        Newsletters
        <small>Exporte os emails para newsletter.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><i class="fa fa-envelope-o"></i> Newsletters</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de contatos</h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/newsletters/export', glyphicon('download').'Exportar CSV', array('class' => 'btn btn-success')); ?>
                <button class="btn btn-danger" onClick="return confirmar('<?= site_url('admin/newsletters/clear'); ?>');"><?= glyphicon('trash'); ?> Limpar</button>
            </div>
        </div>
        <div class="box-body">
            <p class="text-danger">
                <b>Nota:</b>
                O wPanel não faz envio de mensagens em massa, utilize um serviço separado
                para isso.
            </p>

            <table id="grid" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Data</th>
                        <th>Ip</th>
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
                            <td><?= datetime_for_user($row->created); ?></td>
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