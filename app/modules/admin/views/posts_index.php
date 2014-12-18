<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

echo page_header(
	'Postagens',
	2,
	anchor('admin/posts/add',
		glyphicon('plus-sign') . 'Nova postagem',
		array('class' => 'pull-right', 'style' => 'margin-left:20px;')) .
	anchor('admin/categorias',
		glyphicon('th-list') . 'Categorias',
		array('class' => 'pull-right'))
);

echo div(array('class' => 'table-responsive'));
echo $listagem;
echo div(null, true);