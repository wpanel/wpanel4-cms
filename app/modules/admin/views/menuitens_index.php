<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo page_header(
        'Itens do menu', 
        2, 
        '&nbsp;&nbsp;' . anchor('admin/menuitens/add/'.$menu_id, glyphicon('plus-sign') . 'Novo ítem de menu', array('class'=>'pull-right')) . '&nbsp;&nbsp;' .
        '&nbsp;&nbsp;' . anchor('admin/menus', glyphicon('chevron-left') . 'Voltar', array('class'=>'pull-right', 'style'=>'margin-right:15px;'))
        );

echo div(array('class'=>'table-responsive'));
echo $listagem;
echo div(null, true);