<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>
        Usuários
        <small>Gerencie os usuários que administrarão o site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><i class="fa fa-users"></i> Usuários</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de usuários</h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/usuarios/add', glyphicon('plus-sign') . 'Novo usuário', array('class' => 'btn btn-primary')); ?>
            </div>
        </div>
        <div class="box-body">
            <table id="grid" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $row)
                    { ?>
                        <tr>
                            <td><?= $row->id; ?></td>
                            <td><?= $row->name; ?></td>
                            <td><?= $row->email; ?></td>
                            <td>
                                <?php
                                echo status_user($row->status);
                                ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <?= anchor('admin/usuarios/edit/' . $row->id, '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'btn btn-default')); ?>
                                    <?= '<button class="btn btn-default" onClick="return confirmar(\''.site_url('admin/usuarios/delete/' . $row->id).'\');">'.glyphicon('trash').'</button>'; ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>