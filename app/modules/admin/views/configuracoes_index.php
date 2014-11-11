<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

echo "<link href=\"" . base_url() . "lib/css/bootstrap-colorpicker.css\" rel=\"stylesheet\">\n";

echo $this->wpanel->load_editor();

echo page_header('Configurações', 2);

echo form_open_multipart('admin/configuracoes/index', array('role' => 'form'));

echo '<ul class="nav nav-tabs" role="tablist" style="margin-bottom:20px;">';
echo '<li class="active"><a href="#geral" role="tab" data-toggle="tab">Configurações gerais</a></li>';
echo '<li><a href="#home" role="tab" data-toggle="tab">Página inicial</a></li>';
echo '<li><a href="#layout" role="tab" data-toggle="tab">Layout</a></li>';
echo '<li><a href="#contato" role="tab" data-toggle="tab">Contatos</a></li>';
echo '<li><a href="#social" role="tab" data-toggle="tab">Social e compartilhamento</a></li>';
echo '</ul>';

echo div(array('class' => 'tab-content'));// Abre a area de tabs.

// Painel de configuração geral
echo div(array('class' => 'tab-pane active', 'id' => 'geral'));

echo div(array('class' => 'form-group'));
echo form_label('Título do site', 'site_titulo');
echo form_input(array('name' => 'site_titulo', 'value' => $row->site_titulo, 'class' => 'form-control'));
echo form_error('site_titulo');
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Descrição do site', 'site_desc');
echo form_textarea(array('name' => 'site_desc', 'value' => $row->site_desc, 'class' => 'form-control', 'rows' => '4'));
echo form_error('site_desc');
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Código do Google Analytics', 'google_analytics');
echo form_textarea(array('name' => 'google_analytics', 'value' => $row->google_analytics, 'class' => 'form-control', 'rows' => '4'));
echo form_error('google_analytics');
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Palavras-chave do site', 'site_tags');
echo form_input(array('name' => 'site_tags', 'value' => $row->site_tags, 'class' => 'form-control'));
echo form_error('site_tags');
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Nota de rodapé (copyright)', 'copyright');
echo form_input(array('name' => 'copyright', 'value' => $row->copyright, 'class' => 'form-control'));
echo form_error('copyright');
echo close_div();

echo close_div();

// Painel de configuração da página inicial
$category_check = '';
$page_check = '';

if ($row->home_tipo == 'category') {
	$category_check = TRUE;
	$page_check = FALSE;
} elseif ($row->home_tipo == 'page') {
	$category_check = FALSE;
	$page_check = TRUE;
}

echo div(array('class' => 'tab-pane', 'id' => 'home'));
echo '<b>Definições da página inicial.</b>';

echo div(array('class' => 'radio'));
echo '<label>';
echo form_radio(array('name' => 'home_tipo', 'value' => 'category', 'checked' => $category_check, 'class' => 'radio'));
echo ' Usar uma listagem de categoria como página inicial.</label>';
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Categorias disponíveis', 'category_id');
echo form_dropdown('home_category', $opt_categoria, $row->home_id, null, 'form-control');
echo close_div();

echo div(array('class' => 'radio'));
echo '<label>';
echo form_radio(array('name' => 'home_tipo', 'value' => 'page', 'checked' => $page_check, 'class' => 'radio'));
echo ' Usar uma página ou postagem como página inicial.</label>';
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Páginas e postagens disponíveis', 'category_id');
echo form_dropdown('home_post', $opt_posts, $row->home_id, null, 'form-control');
echo close_div();

echo close_div();

// Painel de configuração dos contatos
echo div(array('class' => 'tab-pane', 'id' => 'contato'));

echo div(array('class' => 'form-group'));
echo form_label('Destinatário do formulário de contato', 'site_contato');
echo form_input(array('name' => 'site_contato', 'value' => $row->site_contato, 'class' => 'form-control'));
echo form_error('site_contato');
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Telefone de contato', 'site_telefone');
echo form_input(array('name' => 'site_telefone', 'value' => $row->site_telefone, 'class' => 'form-control'));
echo form_error('site_telefone');
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Texto da tela de contato', 'texto_contato');
echo form_textarea(array('name' => 'texto_contato', 'value' => $row->texto_contato, 'class' => 'form-control ckeditor', 'id' => 'editor', 'rows' => '4'));
echo form_error('texto_contato');
echo close_div();

echo '<h4 style="margin-top:20px;">Configurações de SMTP</h4>';
echo '<hr/>';

echo div(array('class' => 'checkbox'));
echo '<label>';
if ($row->usa_smtp == 1) {
	$checked = true;
} else {
	$checked = false;
}
echo form_checkbox(array('name' => 'usa_smtp', 'value' => '1', 'class' => 'checkbox', 'checked' => $checked));
echo ' Usar um SMTP próprio para enviar as mensagens de contato.</label>';
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Servidor', 'smtp_servidor');
echo form_input(array('name' => 'smtp_servidor', 'value' => $row->smtp_servidor, 'class' => 'form-control'));
echo form_error('smtp_servidor');
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Porta', 'smtp_porta');
echo form_input(array('name' => 'smtp_porta', 'value' => $row->smtp_porta, 'class' => 'form-control'));
echo form_error('smtp_porta');
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Usuário', 'smtp_usuario');
echo form_input(array('name' => 'smtp_usuario', 'value' => $row->smtp_usuario, 'class' => 'form-control'));
echo form_error('smtp_usuario');
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Senha', 'smtp_senha');
echo form_input(array('name' => 'smtp_senha', 'value' => $row->smtp_senha, 'class' => 'form-control'));
echo form_error('smtp_senha');
echo close_div();

echo close_div();

// Painel de configuração das redes sociais e de compartilhamento
echo div(array('class' => 'tab-pane', 'id' => 'social'));

// AddThis
echo div(array('class' => 'form-group'));
echo form_label('Profile ID do AddThis (Compartilhamento social e estatísticas do <a href="https://www.addthis.com" target="_blank">Add This</a>)', 'addthis_uid');
echo form_input(array('name' => 'addthis_uid', 'value' => $row->addthis_uid, 'class' => 'form-control'));
echo form_error('addthis_uid');
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('RSS do Youtube para exibição de vídeos', 'youtube_rss');
echo form_input(array('name' => 'youtube_rss', 'value' => $row->youtube_rss, 'class' => 'form-control'));
echo form_error('youtube_rss');
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Link para a conta do Instagram', 'link_instagram');
echo form_input(array('name' => 'link_instagram', 'value' => $row->link_instagram, 'class' => 'form-control'));
echo form_error('link_instagram');
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Link para a conta do Twitter', 'link_twitter');
echo form_input(array('name' => 'link_twitter', 'value' => $row->link_twitter, 'class' => 'form-control'));
echo form_error('link_twitter');
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Link para o perfil no Facebook', 'link_facebook');
echo form_input(array('name' => 'link_facebook', 'value' => $row->link_facebook, 'class' => 'form-control'));
echo form_error('link_facebook');
echo close_div();

echo div(array('class' => 'form-group'));
echo form_label('Link da Fan-Page do Facebook para o likebox', 'link_likebox');
echo form_input(array('name' => 'link_likebox', 'value' => $row->link_likebox, 'class' => 'form-control'));
echo '<p class="help-block">O link da Fan-Page não é o mesmo do perfil do Facebook.</p>';
echo form_error('link_likebox');
echo close_div();

echo close_div();

// Painel de configuração do layout
echo div(array('class' => 'tab-pane', 'id' => 'layout'));
// Logomarca
echo div(array('class' => 'form-group'));
echo form_label('Logomarca', 'logomarca');
echo form_input(array('name' => 'logomarca', 'type' => 'file'));
if ($row->logomarca) {
	echo img(array('src' => 'media/' . $row->logomarca, 'class' => 'img-responsive img-thumbnail', 'style' => 'margin-top:5px;'));
}
echo form_error('logomarca');
echo close_div();

echo div(array('class' => 'checkbox'));
echo '<label>';
echo form_checkbox(array('name' => 'alterar_logomarca', 'value' => '1', 'class' => 'checkbox'));
echo ' Alterar ou remover a logomarca.</label>';
echo close_div();
// Background
echo div(array('class' => 'form-group'));
echo form_label('Imagem de fundo', 'background');
echo form_input(array('name' => 'background', 'type' => 'file', 'value' => $row->copyright));
if ($row->background) {
	echo img(array('src' => 'media/' . $row->background, 'class' => 'img-responsive img-thumbnail', 'style' => 'margin-top:5px;', 'width' => '400'));
}
echo form_error('background');
echo close_div();

echo div(array('class' => 'checkbox'));
echo '<label>';
echo form_checkbox(array('name' => 'alterar_background', 'value' => '1', 'class' => 'checkbox'));
echo ' Alterar ou remover a imagem de fundo.</label>';

// Fecha a div do group, a tab e a area de tabs.
echo close_div();

echo div(array('class' => 'form-group'));
echo row();
echo col(3);
echo form_label('Cor de fundo do site', 'bgcolor');
echo form_input(array('name' => 'bgcolor', 'value' => $row->bgcolor, 'class' => 'form-control colorpicker'));
echo form_error('bgcolor');
echo close_div();
echo col(5);
echo html_comment('Espaço para o colorpicker.');
echo close_div(2);

echo close_div(3);

echo '<hr/>';

echo form_button(array('type' => 'submit', 'name' => 'submit', 'content' => '<span class="glyphicon glyphicon-floppy-disk"></span> Salvar as alterações', 'class' => 'btn btn-primary'));

echo form_close();
