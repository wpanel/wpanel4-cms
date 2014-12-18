<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo page_header(
	'Lista de fotos', 
	2, 
	anchor('admin/fotos/add/'.$album_id, glyphicon('plus-sign') . 'Adicionar foto', array('class'=>'pull-right')) .
	anchor('admin/albuns', glyphicon('chevron-left') . 'Voltar&nbsp;&nbsp;', array('class'=>'pull-right'))
);

echo div(array('class'=>'table-responsive'));
echo $listagem;
echo div(null, true);