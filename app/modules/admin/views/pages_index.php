<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

echo page_header(
	'Páginas',
	2,
	anchor('admin/pages/add',
		glyphicon('plus-sign') . 'Nova página',
		array('class' => 'pull-right', 'style' => 'margin-left:20px;'))
);

echo div(array('class' => 'table-responsive'));
echo $listagem;
echo div(null, true);