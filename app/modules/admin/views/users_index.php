<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <b>Gerenciador de usuários</b>
    </div>
    <div class="panel-body">
        <?= anchor('admin/usuarios/add', glyphicon('plus-sign') . 'Novo usuário', array('class' => 'btn btn-primary')); ?>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
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
                                <?= anchor('admin/usuarios/delete/' . $row->id, '<span class="glyphicon glyphicon-trash"></span>', array('class' => 'btn btn-default', 'onClick' => 'return apagar();')); ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>




