<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo page_header('Itens do menu', 2, anchor('admin/menuitens/add/'.$menu_id, glyphicon('plus-sign') . 'Novo ítem de menu', array('class'=>'pull-right')));

echo div(array('class'=>'table-responsive'));
echo $listagem;
echo div(null, true);