<?php

echo form_open_multipart('admin/fotos/edit/'.$row->id, array('role'=>'form'));

echo div(array('class'=>'form-group'));
echo form_label('Selecione a imagem', 'userfile');
echo form_input(array('name'=>'userfile', 'type'=>'file'));
echo '<p style="margin-top:15px;"><b>Pré-visualização da imagem:</b></p>';
echo img(array('src'=>'media/albuns/'.$row->album_id.'/'.$row->filename, 'class'=>'img-responsive img-thumbnail', 'style'=>'margin-top:5px;'));
echo div(array('class'=>'checkbox'));
echo '<label>';
echo form_checkbox(array('name'=>'alterar_imagem', 'value'=>'1', 'class'=>'checkbox'));
echo ' Alterar a imagem.</label>';
echo close_div();

echo div(array('class'=>'form-group'));
echo form_label('Descrição', 'descricao');
echo form_input(array('name'=>'descricao', 'value'=> $row->descricao, 'class'=>'form-control'));
echo form_error('descricao');
echo close_div();

echo row();

// Opções de status
$options = array(
                  '0'  => 'Indisponível',
                  '1'  => 'Publicado'
                );

echo col(3);
echo div(array('class'=>'form-group'));
echo form_label('Status', 'status');
echo form_dropdown('status', $options, $row->status, null, 'form-control');
echo close_div(3);

echo hr();

echo row();
echo col();
echo form_button(
        array(
          'type'=>'submit', 
          'name'=>'submit', 
          'content'=>'Salvar as alterações', 
          'class'=>'btn btn-primary'
          )
        );
echo nbs(); // &nbsp;
echo anchor('admin/fotos/index/'.$row->album_id, 'Cancelar', array('class'=>'btn btn-danger'));
echo close_div(2);

echo form_close();