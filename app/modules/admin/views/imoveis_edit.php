<script type="text/javascript">
<!--//
function sizeFrame() {
var F = document.getElementById("frame_admin_fotos");
if(F.contentDocument) {
F.height = F.contentDocument.documentElement.scrollHeight+30; //FF 3.0.11, Opera 9.63, and Chrome
} else {



F.height = F.contentWindow.document.body.scrollHeight+30; //IE6, IE7 and Chrome

}

}

window.onload=sizeFrame;

//-->
</script>
<?php

// Carrega o CKEditor
echo '<script type="text/javascript" src="' . base_url('') . 'ckeditor/ckeditor.js"></script>';
echo '<script>CKEDITOR.replace("editor");</script>';

$input_open = '<div class="form-group">';
$input_close = '</div>';

echo form_open('admin/imoveis/edit/' . $row->id, array('role' => 'form'));

echo $input_open;
echo form_label('Título do anúncio', 'titulo');
echo form_input(array('name' => 'titulo', 'value' => $row->titulo, 'class' => 'form-control'));
echo form_error('titulo');
echo $input_close;

echo $input_open;
echo form_label('Descrição do anúncio', 'descricao');
echo form_textarea(array('name' => 'descricao', 'value' => $row->descricao, 'class' => 'form-control ckeditor', 'id' => 'editor'));
echo form_error('descricao');
echo $input_close;

echo row();// open

echo col(7);
echo div(array('class' => 'form-group'));
echo form_label('Endereço', 'endereco');
echo form_input(array('name' => 'endereco', 'value' => $row->endereco, 'class' => 'form-control'));
echo div(null, true);
echo div(null, true);

echo col(1);
echo div(array('class' => 'form-group'));
echo form_label('Número', 'numero');
echo form_input(array('name' => 'numero', 'value' => $row->numero, 'class' => 'form-control'));
echo div(null, true);
echo div(null, true);

echo col(4);
echo div(array('class' => 'form-group'));
echo form_label('Complemento', 'complemento');
echo form_input(array('name' => 'complemento', 'value' => $row->complemento, 'class' => 'form-control'));
echo div(null, true);
echo div(null, true);

echo div(null, true);// close

echo row();// open

echo col(3);
echo div(array('class' => 'form-group'));
echo form_label('Bairro', 'bairro');
echo form_input(array('name' => 'bairro', 'value' => $row->bairro, 'class' => 'form-control'));
echo div(null, true);
echo div(null, true);

echo col(3);
echo div(array('class' => 'form-group'));
echo form_label('Cidade', 'cidade');
echo form_input(array('name' => 'cidade', 'value' => $row->cidade, 'class' => 'form-control'));
echo div(null, true);
echo div(null, true);

echo col(1);
echo div(array('class' => 'form-group'));
echo form_label('UF', 'uf');
echo form_input(array('name' => 'uf', 'value' => $row->uf, 'class' => 'form-control'));
echo div(null, true);
echo div(null, true);

echo col(2);
echo div(array('class' => 'form-group'));
echo form_label('Cep', 'cep');
echo form_input(array('name' => 'cep', 'value' => $row->cep, 'class' => 'form-control'));
echo div(null, true);
echo div(null, true);

echo div(null, true);// close

// Opções de imovel
$options = array(
	'apartamento' => 'Apartamento',
	'casa' => 'Casa',
	'kitnet' => 'Kit-Net',
	'terreno' => 'Terreno',
	'chacarafazenda' => 'Chacaras e Fazendas',
);
echo '<div class="row"><div class="col-md-3">';
echo $input_open;
echo form_label('Tipo de imóvel', 'tipo_imovel');
echo form_dropdown('tipo_imovel', $options, $row->tipo_imovel, null, 'form-control');
echo $input_close;
echo '</div>';

// Opções de negócio
$options = array(
	'aluguel' => 'Aluguel',
	'venda' => 'Venda',
	'arrendamento' => 'Arrendamento',
);
echo '<div class="col-md-3">';
echo $input_open;
echo form_label('Tipo de negócio', 'tipo_negocio');
echo form_dropdown('tipo_negocio', $options, $row->tipo_negocio, null, 'form-control');
echo $input_close;
echo '</div>';

// Opções de status
$options = array(
	'0' => 'Indisponível',
	'1' => 'Publicado',
);
echo '<div class="col-md-3">';
echo $input_open;
echo form_label('Status', 'status');
echo form_dropdown('status', $options, $row->status, null, 'form-control');
echo $input_close;
echo '</div></div>';

// linha
echo '<div class="row">';
echo '<div class="col-md-3">';
echo $input_open;
echo form_label('Área do terreno (m²)', 'area_terreno');
echo form_input(array('name' => 'area_terreno', 'value' => $row->area_terreno, 'class' => 'form-control'));
echo form_error('area_terreno');
echo $input_close;
echo '</div>';

echo '<div class="col-md-3">';
echo $input_open;
echo form_label('Área construída (m²)', 'area_construida');
echo form_input(array('name' => 'area_construida', 'value' => $row->area_construida, 'class' => 'form-control'));
echo form_error('area_construida');
echo $input_close;
echo '</div>';

echo '<div class="col-md-3">';
echo $input_open;
echo form_label('Num. de cômodos', 'comodos');
echo form_input(array('name' => 'comodos', 'value' => $row->comodos, 'class' => 'form-control'));
echo form_error('comodos');
echo $input_close;
echo '</div>';

echo '<div class="col-md-3">';
echo $input_open;
echo form_label('Num. suítes', 'suites');
echo form_input(array('name' => 'suites', 'value' => $row->suites, 'class' => 'form-control'));
echo form_error('suites');
echo $input_close;
echo '</div></div>';

// linha
echo '<div class="row">';
echo '<div class="col-md-3">';
echo $input_open;
echo form_label('Vagas de garagem', 'garagem');
echo form_input(array('name' => 'garagem', 'value' => $row->garagem, 'class' => 'form-control'));
echo form_error('garagem');
echo $input_close;
echo '</div>';

echo '<div class="col-md-3">';
echo $input_open;
echo form_label('Valor', 'valor');
echo form_input(array('name' => 'valor', 'value' => $row->valor, 'class' => 'form-control'));
echo form_error('valor');
echo $input_close;
echo '</div></div>';

// Administração das imagens do imóvel
echo '<hr/>';
echo '<iframe id="frame_admin_fotos" src="' . site_url('admin/imoveis/fotos/' . $row->id) . '" scrolling="no" frameborder="0" width="100%" height="400"></iframe>';
echo '<hr/>';

echo '<div class="row"><div class="col-md-12">';
echo form_button(array('type' => 'submit', 'name' => 'submit', 'content' => 'Salvar as alterações', 'class' => 'btn btn-primary'));
echo '&nbsp;';
echo anchor('admin/imoveis', 'Cancelar', array('class' => 'btn btn-danger'));
echo '</div></div>';

echo form_close();