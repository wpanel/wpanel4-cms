<?php

echo form_open('admin/categorias/add', array('role'=>'form'));

echo div(array('class'=>'form-group'));
echo form_label('Título', 'title');
echo form_input(array('name'=>'title', 'value'=> set_value('name'), 'class'=>'form-control'));
echo form_error('title');
echo div(null, true);

echo div(array('class'=>'form-group'));
echo form_label('Descrição', 'description');
echo form_textarea(array('name'=>'description', 'class'=>'form-control'));
echo div(null, true);

echo row();
echo col(6);

echo div(array('class'=>'form-group'));
echo form_label('Categoria-pai', 'category_id');
echo form_dropdown('category_id', $options, '', null, 'form-control');

echo close_div(2);
echo col(6);

$options_view = array(
	'Lista'=>'Lista',
	'Mosaico'=>'Mosaico'
);

echo div(array('class'=>'form-group'));
echo form_label('Tipo de visualização', 'view');
echo form_dropdown('view', $options_view, '', null, 'form-control');

echo close_div(3);


echo form_button(array('type'=>'submit', 'name'=>'submit', 'content'=>'Cadastrar', 'class'=>'btn btn-primary'));
echo '&nbsp;';
echo anchor('admin/categorias', 'Cancelar', array('class'=>'btn btn-danger'));

echo form_close();