<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>
        Contas de usuário
        <small>Gerencie as contas de usuário do site aqui.</small>
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
            </div>
        </div>
        <div class="box-body">
            <?= $listagem; ?>
            <?php /*<table id="grid" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Grupo</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $row)
                    { ?>
                        <tr>
                            <td><?= $row->id; ?></td>
                            <td><?= auth_extra_data('name'); ?></td>
                            <td><?= $row->email; ?></td>
                            <td><?= $roles[$row->role]; ?></td>
                            <td>
                                <?php
                                echo status_user($row->status);
                                ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-xs">
                                    <?= anchor('admin/usuarios/edit/' . $row->id, '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'btn btn-default')); ?>
                                    <?= '<button class="btn btn-default" onClick="return confirmar(\''.site_url('admin/usuarios/delete/' . $row->id).'\');">'.glyphicon('trash').'</button>'; ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table> */ ?>
        </div>
    </div>
</section>