<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo page_header('Banners', 2, anchor('admin/banners/add', glyphicon('plus-sign') . 'Novo banner', array('class'=>'pull-right')));

echo div(array('class'=>'table-responsive'));
echo $listagem;
echo div(null, true);