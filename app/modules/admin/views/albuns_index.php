<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo page_header('Albuns de fotos', 2, anchor('admin/albuns/add', glyphicon('plus-sign') . 'Novo álbum', array('class'=>'pull-right')));

echo div(array('class'=>'table-responsive'));
echo $listagem;
echo div(null, true);