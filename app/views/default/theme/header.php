<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<!DOCTYPE html>
<html>
    <head>
        <?= wpn_meta(); ?>
        <?= $this->widget->load('wpntitle'); ?>
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('media/' . wpn_config('favicon')); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="canonical" href="<?= current_url(); ?>" />
        <!-- Bootstrap -->
        <?= wpn_asset('css', 'bootstrap.min.css'); ?>
        <?= wpn_asset('css', 'bootstrap-submenu.min.css'); ?>
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Estilo do template -->
        <?= wpn_asset('css', 'template.css'); ?>
        <!-- Javascript -->
        <?= wpn_asset('js', 'jquery-2.2.4.min.js'); ?>
        <?= wpn_asset('js', 'bootstrap.min.js'); ?>
        <?= wpn_asset('js', 'bootstrap-submenu.min.js'); ?>
        <?= wpn_asset('js', 'wpanel.js'); ?>
        <!-- Widgets do cabeçalho -->
        <?= $this->widget->load('wpnfacebookheader'); ?>
        <?= $this->widget->load('wpnaddthisheader'); ?>
        <?= $this->widget->load('wpnbackground'); ?>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <nav class="navbar navbar-default navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Alternar navegação</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="<?= site_url(); ?>">
                                <!--<span class="visible-xs"><?= wpn_config('site_titulo'); ?></span>-->
                                <?= $this->widget->load('wpnlogomarca', array('class_name'=>'img-responsive')); ?>
                            </a>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <div class="menu">
                                <?= $this->widget->load('wpnmainmenu', array('menu_id' => 1, 'ul_style' => 'nav navbar-nav navbar-right', 'li_style'=>'dropdown')); ?>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <?php if (@$show_slide) { ?>
            <div class="row hidden-xs">
                <?= $this->widget->load('wpnslidebanner', array('position'=>'slide')); ?>
            </div>
            <?php } ?>
        </div>
        <div class="container wpn-container">
            <div class="row">
                <div class="col-md-9">
