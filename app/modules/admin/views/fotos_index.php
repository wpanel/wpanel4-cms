<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo page_header(
	'Lista de fotos',
	2,
	'&nbsp;&nbsp;' . anchor('admin/fotos/add/'.$album_id, glyphicon('plus-sign') . 'Adicionar foto individual', array('class'=>'pull-right', 'style'=>'margin-left:10px;margin-right:10px;')) . '&nbsp;&nbsp;' .
        '&nbsp;&nbsp;' . anchor('admin/fotos/addmass/'.$album_id, glyphicon('plus-sign') . 'Adicionar fotos em massa', array('class'=>'pull-right', 'style'=>'margin-left:10px;margin-right:10px;')) . '&nbsp;&nbsp;' .
	'&nbsp;&nbsp;' . anchor('admin/albuns', glyphicon('chevron-left') . 'Voltar', array('class'=>'pull-right'))
);

echo div(array('class'=>'table-responsive'));
echo $listagem;
echo div(null, true);
