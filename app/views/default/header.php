<!DOCTYPE html>
<!--

This site is developed with Wpanel CMS - http://wpanel.org

WPanel CMS

An open source Content Manager System for websites and systems using CodeIgniter.

This content is released under the MIT License (MIT)

Copyright (c) 2008 - 2017, Eliel de Paula.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

@package     WpanelCms
@author      Eliel de Paula <dev@elieldepaula.com.br>
@copyright   Copyright (c) 2008 - 2017, Eliel de Paula. (https://elieldepaula.com.br/)
@license     http://opensource.org/licenses/MIT  MIT License
@link        https://wpanel.org

-->
<html>
    <head>
        <?= wpn_widget('wpntitle'); ?>
        <?= wpn_meta(); ?>
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="canonical" href="<?= current_url(); ?>" />
        <!-- Bootstrap -->
        <?= wpn_asset('css', 'bootstrap.min.css'); ?>
        <!-- Estilo do template -->
        <?= wpn_asset('css', 'template.css'); ?>
        <!-- jQuery -->
        <?= wpn_asset('js', 'jquery-2.1.4.min.js'); ?>
        <?= wpn_asset('js', 'bootstrap.min.js'); ?>
        <?= wpn_widget('facebookheader'); ?>
        <?= wpn_widget('addthisheader'); ?>
        <?= wpn_widget('background'); ?>
    </head>
    <body>

        <div class="container-fuid">
            <div class="row">
                <nav class="navbar navbar-default navbar-fixed-top">
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
                                <?= wpn_widget('logomarca', array('class_name'=>'img-responsive')); ?>
                            </a>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <div class="menu">
                                <?= wpn_widget('wpanelmenu', array('menu_id' => 1, 'ul_style' => 'nav navbar-nav navbar-right', 'li_style'=>'dropdown')); ?>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
            
        <div class="container-fluid">
            <div class="row hidden-xs">
                <?= wpn_widget('slidebanner', array('position'=>'slide')); ?>
            </div>
        </div>
        
        <div class="container wpn-container">
            <?= wpn_widget('notice'); ?>
            <div class="row">
                <div class="col-sm-9 col-md-9">