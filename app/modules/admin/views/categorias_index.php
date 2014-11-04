<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo page_header('Categorias', 2, anchor('admin/categorias/add', glyphicon('plus-sign') . 'Nova categoria', array('class'=>'pull-right')));

echo div(array('class'=>'table-responsive'));
echo $listagem;
echo div(null, true);