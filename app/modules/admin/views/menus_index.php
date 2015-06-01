<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo page_header('Menus', 2, anchor('admin/menus/add', glyphicon('plus-sign') . 'Novo menu', array('class'=>'pull-right')));

echo div(array('class'=>'table-responsive'));
echo $listagem;
echo div(null, true);