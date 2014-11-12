<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $this->wpanel->get_titulo(); ?></title>
        <?php echo $this->wpanel->get_meta(); ?>
        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>lib/css/bootstrap.css" rel="stylesheet">
        <!-- jQuery -->
        <script src="<?php echo base_url()?>lib/js/jquery.js"></script>
        <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="<?php echo base_url(); ?>lib/js/bootstrap.js" type="text/javascript"></script>
        <!-- BEGIN Facebook -->
        <div id="fb-root"></div>
        <script>
             (function (d, s, id) {
                 var js, fjs = d.getElementsByTagName(s)[0];
                 if (d.getElementById(id))
                     return;
                 js = d.createElement(s);
                 js.id = id;
                 js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1472322323008859&version=v2.0";
                 fjs.parentNode.insertBefore(js, fjs);
             }(document, 'script', 'facebook-jssdk'));
        </script>
        <!-- END Facebook -->
        <style type="text/css">
            body {
                background-image: url('<?php echo base_url('media') . '/' . $this->wpanel->get_config('background'); ?>');
                background-position: top center;
                /*background-repeat: no-repeat;*/
                background-attachment: fixed;
                background-color: <?php echo $this->wpanel->get_config('bgcolor'); ?>;
            }
            .space {
                height: 15px;
            }
            .wpn_conteudo {
                background-color: #fff;
            }
            img.background-image {
                min-height: 100%;
                min-width: 1024px;
                width: 100%;
                height: auto;
                position: fixed;
                top: 0px;
                left: 0px;
                z-index: -1;
            }
            .menu-sidebar {

                list-style: none;
                list-style-position: outside;

                margin: 0;
                padding: 0;

            }
            .page-header {
                margin-top: 15px;
            }
            .footer {
                margin-top:20px;
                /*padding: 15px;*/
                background-color: #333;
                color: #fff;
                min-height: 350px;
            }
        </style>
    </head>
    <body>
        <div class="space hidden-xs">&nbsp;</div>
        <div class="container hidden-xs">
            <div class="row">
                <div class="col-md-12">
                    <?php

                    // Insere a imagem que será colocada como background pelo CSS.
                    $image_properties = array(
                    	'src' => base_url() . '/media/' . $this->wpanel->get_config('logomarca'),
                    	'class' => 'hidden-xs'
                    );

                    echo img($image_properties);

                    ?>
                </div>
            </div>
        </div>
        <div class="space hidden-xs">&nbsp;</div>
        <!-- Main wrapper -->
        <div class="container wpn_conteudo">
            <!-- Banner slide -->
            <div class="row hidden-xs">
                <div id="carousel-topo" data-interval="false" class="carousel slide"
                     data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        // Laço com o banner slider.
                        $laco = 0;
                        foreach ($this->wpanel->get_banner('slide') as $ban_sld) {
                        	
                            if ($laco == 0) {
                        		echo '<div class="item active">';
                        	} else {
                        		echo '<div class="item">';
                        	}
                        
                            $image_properties = array(
                        		'src' => 'media/banners/' . $ban_sld->content,
                        		'class' => '',
                        	);

                        	echo img($image_properties);
                        	echo "</div>";

                            $laco = $laco + 1;

                        } // Fim do laço
                        ?>
                    </div>
                    <a class="left carousel-control" href="#carousel-topo" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-topo" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            </div>
            <!-- End - Banner slide -->
            <!-- Navbar Topo | Inicio -->
            <div class="row">
                <div class="navbar navbar-default navbar-inverse navbar-static-top">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Alternar navegação</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse navbar-top-collapse">
                        <ul class="nav navbar-nav navbar-left" style="">
                            <li> <!-- class="active" -->
                                <?php echo anchor('', 'Home'); ?>
                            </li>
                            <li>
                                <?php echo anchor('/post/sobre', 'Sobre'); ?>
                            </li>
                            <li>
                                <?php echo anchor('contato', 'Contato'); ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Navbar Topo | Fim -->
            <!-- Body wrapper -->
            <div class="row">
                <!-- Content -->
                <div class="col-md-9">
                    <?php echo $content; ?>
                </div>
                <!-- end - content -->
                <!-- sidebar -->
                <div class="col-md-3">
                    <!-- Widget -->
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="page-header">Pesquisa</h4>
                            <?php echo form_open('search', array('class' => 'form-inline', 'role' => 'form')); ?>
                            <div class="form-group">
                                <input type="text" name="search" class="form-control" placeholder="Digite o que procura..." />
                                <input type="submit" value="Ok" class="btn btn-primary" />
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                    <!-- end - Widget -->
                    <!-- Widget -->
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="page-header">Categorias</h4>
                            <?php echo $this->wpanel->menu_categorias(0, array('class' => 'menu-sidebar')); ?>
                        </div>
                    </div>
                    <!-- end - Widget -->
                </div>
                <!-- end - sidebar -->
            </div>
            <!-- end - body wrapper -->
            <!-- Rodape | Inicio -->
            <div class="row footer">
                <div class="col-md-4">
                    <h4 class="page-header">Sobre</h4>
                    <p><?php echo $this->wpanel->get_config('site_desc'); ?></p>
                </div>
                <div class="col-md-4">
                    <h4 class="page-header">Newsletter</h4>
                    <?php echo form_open('newsletter', array('role' => 'form')); ?>
                        <div class="form-group">
                            <label class="control-label" for="nome">Nome</label>
                            <input class="form-control" name="nome" id="nome" placeholder="Seu nome..." type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email">Email</label>
                            <input class="form-control" name="email" id="email" placeholder="Seu email..." type="text">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-envelope"></span> Enviar
                        </button>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-4">
                    <h4 class="page-header">Social</h4>
                    <div class="fb-like-box col-md-4"
                        data-href="<?php echo $this->wpanel->get_config('link_likebox'); ?>"
                        data-colorscheme="light"
                        data-show-faces="true"
                        data-header="false"
                        data-stream="false"
                        data-show-border="false"
                        width="300"
                        height="250">
                    </div>
                </div>
                <div class="col-md-12">
                    <p><?php echo $this->wpanel->get_config('copyright'); ?>. Site by <a href="http://elieldepaula.com.br" alt="Eliel de Paula - Desenvolvedor Web">Eliel de Paula</a>, desenvolvido com <a href="http://elieldepaula.com.br/wpanel" alt="WPanel CMS">WPanel CMS</a>.</p>
                </div>
            </div>
            <!-- Rodape | Fim -->
        </div>
        <!-- end - Main wrapper -->
        <div class="space hidden-xs">&nbsp;</div>
    </body>
    <!-- Auto-play do carrossel -->
    <script type="text/javascript">
        var $ = jQuery.noConflict();
        $(document).ready(function () {
            $('#carousel-topo').carousel({interval: 5000, cycle: true});
        });
    </script>
    <?php echo $this->wpanel->get_config('google_analytics'); ?>
</html>