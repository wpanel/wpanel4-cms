<!DOCTYPE html>
<html>
    <head>
        <title><?= $wpn_title; ?></title>
        <?= $wpn_meta; ?>
        <!-- Bootstrap -->
        <link href="<?= $wpn_assets; ?>/css/bootstrap.min.css" rel="stylesheet">
        <!-- Estilo do layout -->
        <link href="<?= $wpn_assets; ?>/css/template.css" rel="stylesheet">
        <!-- jQuery -->
        <script src="<?= $wpn_assets; ?>/js/jquery-2.1.4.min.js"></script>
        <script src="<?= $wpn_assets; ?>/js/bootstrap.min.js" type="text/javascript"></script>
        <?= $wpn_header_addthis; ?>
        <?= $wpn_header_facebook; ?>
        <?= $wpn_background; ?>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <nav class="navbar navbar-default">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Alternar navegação</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="<?= site_url(); ?>">
                                <?php 

                                /*

                                    Use uma logomarca ou o título!

                                    Para imprimir a logomarca carregada no painel de controle
                                    use o código:

                                    echo $wpn_logo;

                                    Para imprimir somente o título do site, geralmente usado
                                    somente na navbar do bootstrap, use o código:

                                    echo $wpn_title;

                                */

                                echo $wpn_title;

                                ?>
                            </a>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <div class="menu">
                                <?= $this->widget->run('wpanelmenu', array('menu_id' => 1, 'class_menu' => 'nav navbar-nav navbar-right')); ?>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="row">
                <?= $this->widget->run('slidebanner', array('position'=>'slide')); ?>
            </div>
            <div class="row">
                <div class="col-md-9">