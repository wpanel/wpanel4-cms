<!DOCTYPE html>
<html lang="en"><head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Eliel de Paula <elieldepaula@gmail.com>">
        <link rel="icon" href="<?= base_url() ?>lib/img/favicon.ico">

        <title>wPanel 11 - Administração</title>

        <!-- Bootstrap core CSS -->
        <link href="<?= base_url() ?>lib/css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?= base_url() ?>lib/css/dashboard.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="<?= base_url() ?>lib/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="<?= base_url() ?>lib/js/ie-emulation-modes-warning.js"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style type="text/css" id="holderjs-style"></style></head>
    <script type="text/javascript">
        function apagar() {
            if (confirm('Esta opcao nao podera ser desfeita,\ntem certeza que deseja proseguir ?'))
                return true;
            else
                return false;
        }
    </script>

    <body>

        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Navegação</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= site_url('admin'); ?>">
                        <span style="color:#fff;font-weight:bolder;">wPanel</span> - Administração
                    </a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li<?php if ($this->uri->segment(2) == 'dashboard' or $this->uri->segment(2) == '') {
    echo ' class="active"';
} ?>><?= anchor('admin/dashboard', glyphicon('th') . 'Dashboard'); ?></li>
                        <li<?php if ($this->uri->segment(2) == 'configuracoes') {
    echo ' class="active"';
} ?>><?= anchor('admin/configuracoes', glyphicon('cog') . 'Configurações'); ?></li>
                        <li<?php if ($this->uri->segment(2) == 'usuarios') {
    echo ' class="active"';
} ?>><?= anchor('admin/usuarios/edit/' . $this->auth->get_userid(), glyphicon('user') . 'Perfil'); ?></li>
                        <li><?= anchor('/admin/dashboard/logout', glyphicon('off') . 'Sair'); ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li<?php if ($this->uri->segment(2) == 'dashboard' or $this->uri->segment(2) == '') {
    echo ' class="active"';
} ?>><?= anchor('admin/dashboard', 'Dashboard'); ?></li>
                        <li<?php if ($this->uri->segment(2) == 'posts') {
    echo ' class="active"';
} ?>><?= anchor('admin/posts', 'Postagens'); ?></li>
                        <li<?php if ($this->uri->segment(2) == 'pages') {
    echo ' class="active"';
} ?>><?= anchor('admin/pages', 'Páginas'); ?></li>
                        <li<?php if ($this->uri->segment(2) == 'agendas') {
                        echo ' class="active"';
                    } ?>><?= anchor('admin/agendas', 'Agenda de eventos'); ?></li>
                        <li<?php if ($this->uri->segment(2) == 'categorias') {
                        echo ' class="active"';
                    } ?>><?= anchor('admin/categorias', 'Categorias de posts'); ?></li>
                        <li<?php if ($this->uri->segment(2) == 'banners') {
                        echo ' class="active"';
                    } ?>><?= anchor('admin/banners', 'Banners'); ?></li>
                        <li<?php if ($this->uri->segment(2) == 'albuns' or $this->uri->segment(2) == 'fotos') {
                        echo ' class="active"';
                    } ?>><?= anchor('admin/albuns', 'Albuns de fotos'); ?></li>
                        <li<?php if ($this->uri->segment(2) == 'menus') {
                        echo ' class="active"';
                    } ?>><?= anchor('admin/menus', 'Gerenciador de menus'); ?></li>
                        <li<?php if ($this->uri->segment(2) == 'usuarios') {
                        echo ' class="active"';
                    } ?>><?= anchor('admin/usuarios', 'Usuários'); ?></li>
                        <li<?php if ($this->uri->segment(2) == 'configuracoes') {
                        echo ' class="active"';
                    } ?>><?= anchor('admin/configuracoes', 'Configurações'); ?></li>
                    </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php
// Mensagens do sistema;
$msg_sistema = $this->session->flashdata('msg_sistema');

if ($msg_sistema) {
    echo alerts($msg_sistema, 'warning', true);
}

// Conteúdo dinâmico.
echo $content;
?>
                    <hr/>
                    <p class="text-right">Página renderizada em <strong>{elapsed_time}</strong> segundos.</p>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?= base_url(); ?>lib/js/jquery.js"></script>
        <script src="<?= base_url(); ?>lib/js/bootstrap.js"></script>
        <script src="<?= base_url(); ?>lib/js/bootstrap-colorpicker.js"></script>
        <script src="<?= base_url(); ?>lib/js/docs.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="<?= base_url() ?>lib/js/ie10-viewport-bug-workaround.js"></script>

        <script>
        $(function () {
            
        $('.colorpicker').colorpicker();
            
            $("#form_link").show();
            $("#form_post").hide();
            $("#form_posts").hide();
            $("#form_funcional").hide();

            $("#tipo_link").click(function () {
                $("#form_link").show();
                $("#form_post").hide();
                $("#form_posts").hide();
                $("#form_funcional").hide();
            });
            $("#tipo_post").click(function () {
                $("#form_link").hide();
                $("#form_post").show();
                $("#form_posts").hide();
                $("#form_funcional").hide();
            });
            $("#tipo_posts").click(function () {
                $("#form_link").hide();
                $("#form_post").hide();
                $("#form_posts").show();
                $("#form_funcional").hide();
            });
            $("#tipo_funcional").click(function () {
                $("#form_link").hide();
                $("#form_post").hide();
                $("#form_posts").hide();
                $("#form_funcional").show();
            });

        });
        </script>

    </body>
</html>