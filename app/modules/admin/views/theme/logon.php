<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin WPanel | <?= $title; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('/lib/img/favicon.ico'); ?>">
        <!-- bootstrap 3.3.4 -->
        <link href="<?= base_url('lib/css') ?>/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?= base_url('lib/css') ?>/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="login-page">
        <?= $view_content ?>
        <!-- jQuery 2.1.4 -->
        <script src="<?= base_url('lib/plugins') ?>/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- bootstrap 3.3.2 JS -->
        <script src="<?= base_url('lib/js') ?>/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>