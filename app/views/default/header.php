<!DOCTYPE html>
<html>
    <head>
        <title><?= wpn_config('site_titulo'); ?></title>
        <?= $wpn_meta; ?>
        <!-- Bootstrap -->
        <?= wpn_asset('css', 'bootstrap.min.css'); ?>
        <!-- Estilo do layout -->
        <?= wpn_asset('css', 'template.css'); ?>
        <!-- jQuery -->
        <?= wpn_asset('js', 'jquery-2.1.4.min.js'); ?>
        <?= wpn_asset('js', 'bootstrap.min.js'); ?>
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
                                <?= wpn_config('site_titulo'); ?>
                            </a>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <div class="menu">
                                <?= $this->widget->runit('wpanelmenu', array('menu_id' => 1, 'class_menu' => 'nav navbar-nav navbar-right')); ?>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="row">
                <?= $this->widget->runit('slidebanner', array('position'=>'slide')); ?>
            </div>
            <div class="row">
                <div class="col-md-9">