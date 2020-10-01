<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin WPanel</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('/lib/img/favicon.ico'); ?>">
        <!-- Bootstrap -->
        <link href="<?= base_url('lib/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="<?= base_url('lib/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?= base_url('lib/css/AdminLTE.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. -->
        <link href="<?= base_url('lib/css/skins/_all-skins.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- jQuery 2.1.4 -->
        <script src="<?= base_url('lib/plugins/jQuery/jquery-2.2.4.min.js') ?>"></script>
        <!--JQueryUI-->
        <script src="<?= base_url('lib/plugins/jQueryUI/jquery-ui-1.10.3.min.js') ?>"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?= base_url('lib/js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <!-- BootBox **** -->
        <script src="<?= base_url('lib/plugins/bootbox/bootbox.min.js') ?>"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="<?= base_url('lib/plugins/datatables/jquery.dataTables.min.js') ?>" type="text/javascript"></script>
        <!--Data Tables-->
        <script src="<?= base_url('lib/plugins/datatables/dataTables.bootstrap.min.js') ?>" type="text/javascript"></script>
        <!--Color-Picker-->
        <script src="<?= base_url('lib/plugins/colorpicker/bootstrap-colorpicker.min.js') ?>" type="text/javascript"></script>
        <link href="<?= base_url('lib/plugins/colorpicker/bootstrap-colorpicker.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- SlimScroll **** -->
        <script src="<?= base_url('lib/plugins/slimScroll/jquery.slimscroll.min.js') ?>" type="text/javascript"></script>
        <!-- FastClick **** -->
        <script src='<?= base_url('lib/plugins/fastclick/fastclick.min.js') ?>'></script>
        <!-- AdminLTE App -->
        <script src="<?= base_url('lib/js/app.min.js') ?>" type="text/javascript"></script>
        <!-- WPanel JS -->
        <script src="<?= base_url('lib/js/wpanel.js') ?>"></script>
    </head>
    <?php
    $skin = auth_extra_data('skin');
    if ($skin == '')
        $skin = 'blue';

    $avatar = auth_extra_data('avatar');
    if ($avatar)
        $avatar = base_url('media/avatar/' . $avatar);
    else
        $avatar = base_url('lib/img/no-user.jpg');
    ?>
    <body class="skin-<?= $skin; ?> sidebar-mini">

        <!-- Site wrapper -->
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="<?= site_url('admin'); ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>A</b>WP</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Admin</b>WPanel</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <?= $this->widget->load('notificate'); ?>
                            <li>
                                <?= anchor('', '<span class="fa fa-globe fa-lg fa-2x"></span><span class="hidden-xs">&nbsp;&nbsp;'.wpn_lang('link_view_site').'</span>', array('target' => '_blank')); ?>
                            </li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?= $avatar; ?>" class="user-image" alt="<?= auth_extra_data('name'); ?>"/>
                                    <span class="hidden-xs"><?= auth_extra_data('name'); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?= $avatar; ?>" class="img-circle" alt="<?= auth_extra_data('name'); ?>" />
                                        <p>
                                            <?= auth_extra_data('name'); ?>
                                            <small><?= wpn_lang('wpn_since'); ?> <?= mdate(config_item('user_date_format'), strtotime(auth_login_data('created_on'))); ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <?= anchor('admin/accounts/profile', glyphicon('user') . wpn_lang('link_profile'), array('class' => 'btn btn-primary btn-flat')); ?>
                                        </div>
                                        <div class="pull-right">
                                            <?= anchor('/admin/logout', glyphicon('off') . wpn_lang('link_logout'), array('class' => 'btn btn-danger btn-flat')); ?>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?= $avatar; ?>" class="img-circle" alt="<?= auth_extra_data('name'); ?>" />
                        </div>
                        <div class="pull-left info">
                            <p><?= auth_extra_data('name'); ?></p>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header"><?= wpn_lang('wpn_mainoptions'); ?></li>
                        <li <?= wpn_activelink('dashboard'); ?>>
                            <?= anchor('admin/dashboard', '<i class="fa fa-dashboard"></i> <span>' . wpn_lang('wpn_menu_dashboard') . '</span>'); ?>
                        </li>
                        <!-- Menu Portal -->
                        <li class="treeview <?= wpn_activelink(array('posts', 'categories', 'pages', 'events', 'banners', 'galleries', 'fotos', 'videos', 'enquetes', 'enqrespostas', 'comments'), 2, 'active'); ?>">
                            <a href="#">
                                <i class="fa fa-globe"></i>
                                <span><?= wpn_lang('wpn_menu_portal'); ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if (auth_link_permission('admin/posts')) { ?>
                                    <li <?= wpn_activelink(array('posts', 'categories')); ?>>
                                        <?= anchor('admin/posts', '<i class="fa fa-files-o"></i> <span>' . wpn_lang('wpn_menu_post') . '</span>'); ?>
                                    </li>
                                <?php } ?>
                                <?php if (auth_link_permission('admin/pages')) { ?>
                                    <li <?= wpn_activelink('pages'); ?>>
                                        <?= anchor('admin/pages', '<i class="fa fa-files-o"></i> <span>' . wpn_lang('wpn_menu_page') . '</span>'); ?>
                                    </li>
                                <?php } ?>
                                <?php if (auth_link_permission('admin/banners')) { ?>
                                    <li <?= wpn_activelink('banners'); ?>>
                                        <?= anchor('admin/banners', '<i class="fa fa-shirtsinbulk"></i> <span>' . wpn_lang('wpn_menu_banner') . '</span>'); ?>
                                    </li>
                                <?php } ?>
                                <?php if (auth_link_permission('admin/galleries')) { ?>
                                    <li <?= wpn_activelink('galleries'); ?>
                                        <?= wpn_activelink('pictures'); ?>><?= anchor('admin/galleries', '<i class="fa fa-camera"></i> <span>' . wpn_lang('wpn_menu_gallery') . '</span>'); ?>
                                    </li>
                                <?php } ?>
                                <?php if (auth_link_permission('admin/videos')) { ?>
                                    <li <?= wpn_activelink('videos'); ?>>
                                        <?= anchor('admin/videos', '<i class="fa fa-film"></i> <span>' . wpn_lang('wpn_menu_video') . '</span>'); ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <!-- Menu Sistema -->
                        <li class="treeview <?= wpn_activelink(array('menus', 'notifications', 'newsletters', 'accounts', 'ipbanneds', 'configuracoes'), 2, 'active'); ?>">
                            <a href="#">
                                <i class="fa fa-gears"></i>
                                <span><?= wpn_lang('wpn_menu_system'); ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if (auth_link_permission('admin/menus')) { ?>
                                    <li <?= wpn_activelink('menus'); ?> <?= wpn_activelink('menuitens'); ?>><?= anchor('admin/menus', '<i class="fa fa-reorder"></i> <span>' . wpn_lang('wpn_menu_menu') . '</span>'); ?>
                                    </li>
                                <?php } ?>
                                <?php if (auth_link_permission('admin/newsletters')) { ?>
                                    <li <?= wpn_activelink('newsletters'); ?>>
                                        <?= anchor('admin/newsletters', '<i class="fa fa-envelope-o"></i> <span>' . wpn_lang('wpn_menu_newsletter') . '</span>'); ?>
                                    </li>
                                <?php } ?>
                                <?php if (auth_link_permission('admin/accounts')) { ?>
                                    <li <?= wpn_activelink(array('accounts', 'ipbanneds')); ?>>
                                        <?= anchor('admin/accounts', '<i class="fa fa-users"></i> <span>' . wpn_lang('wpn_menu_account') . '</span>'); ?>
                                    </li>
                                <?php } ?>
                                <?php if (auth_link_permission('admin/notifications')) { ?>
                                    <li <?= wpn_activelink('notifications'); ?>>
                                        <?= anchor('admin/notifications', '<i class="fa fa-bell-o"></i> <span>' . wpn_lang('wpn_menu_notification') . '</span>'); ?>
                                    </li>
                                <?php } ?>
                                <?php if (auth_link_permission('admin/configuracoes')) { ?>
                                    <li <?= wpn_activelink('configuracoes'); ?>>
                                        <?= anchor('admin/configuracoes', '<i class="fa fa-cog"></i> <span>' . wpn_lang('wpn_menu_configuration') . '</span>'); ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php if($this->auth->is_root()): ?>
                        <!-- Menu Desenvolvedor -->
                            <li class="treeview <?= wpn_activelink(array('developers', 'generator', 'modulos'), 2, 'active'); ?>">
                                <a href="#">
                                    <i class="fa fa-code"></i>
                                    <span><?= wpn_lang('wpn_menu_developer'); ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li <?= wpn_activelink('modmigration', 3); ?>>
                                        <?= anchor('admin/developers/modmigration', '<i class="fa fa-cog"></i> <span>' . wpn_lang('wpn_menu_migrations') . '</span>'); ?>
                                    </li>
                                    <!-- <li <?= wpn_activelink('generator'); ?>>
                                        <?= anchor('admin/generator', '<i class="fa fa-cog"></i> <span>' . wpn_lang('wpn_menu_generator') . '</span>'); ?>
                                    </li>
                                    -->
                                    <li <?= wpn_activelink('logs', 3); ?>>
                                        <?= anchor('admin/developers/logs', '<i class="fa fa-exclamation-circle"></i> <span>' . wpn_lang('wpn_menu_logs') . '</span>'); ?>
                                    </li>
                                    <li <?= wpn_activelink('backups', 3); ?>>
                                        <?= anchor('admin/developers/backups', '<i class="fa fa-database"></i> <span>' . wpn_lang('wpn_menu_backups') . '</span>'); ?>
                                    </li>
                                    <li <?= wpn_activelink('modulos'); ?>>
                                        <?= anchor('admin/modulos', '<i class="fa fa-plug"></i> <span>'.wpn_lang('wpn_menu_modules').'</span>'); ?>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li>
                            <?= anchor('admin/logout', '<i class="fa fa-sign-out"></i> <span>'.wpn_lang('wpn_menu_logout').'</span>'); ?>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
