<?php

$input_open = '<div class="form-group">';
$input_close = '</div>';

echo form_open('admin/usuarios/add', array('role'=>'form'));

echo $input_open;
echo form_label('Nome completo', 'name');
echo form_input(array('name'=>'name', 'value'=> set_value('name'), 'class'=>'form-control'));
echo form_error('name');
echo $input_close;

echo $input_open;
echo form_label('Email válido', 'email');
echo form_input(array('name'=>'email', 'value'=> set_value('email'), 'type'=>'email', 'class'=>'form-control'));
echo form_error('email');
echo $input_close;

echo $input_open;
echo form_label('Nome de usuário', 'username');
echo form_input(array('name'=>'username', 'value'=> set_value('username'), 'class'=>'form-control'));
echo form_error('username');
echo $input_close;

echo $input_open;
echo form_label('Senha', 'password');
echo form_password(array('name'=>'password', 'value'=> set_value('password'), 'class'=>'form-control'));
echo form_error('password');
echo $input_close;

// Opções de grupo
$options = array(
                  'admin'  => 'Administrador',
                  'user'    => 'Usuário comum'
                );

echo $input_open;
echo form_label('Grupo', 'role');
echo form_dropdown('role', $options, 'large', null, 'form-control');
echo $input_close;

// opções de status
$options = array(
                  '0'  => 'Bloqueado',
                  '1'    => 'Ativo'
                );

echo $input_open;
echo form_label('Status', 'status');
echo form_dropdown('status', $options, 'large', null, 'form-control');
echo $input_close;

echo form_button(array('type'=>'submit', 'name'=>'submit', 'content'=>'Cadastrar', 'class'=>'btn btn-primary'));
echo '&nbsp;';
echo anchor('admin/usuarios', 'Cancelar', array('class'=>'btn btn-danger'));

echo form_close();