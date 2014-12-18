<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

echo page_header(
	'Agenda de eventos',
	2,
	anchor('admin/agendas/add',
		glyphicon('plus-sign') . 'Novo evento',
		array('class' => 'pull-right', 'style' => 'margin-left:20px;'))
);

echo div(array('class' => 'table-responsive'));
echo $listagem;
echo div(null, true);