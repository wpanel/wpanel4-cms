<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Recuperação de senha | <?= wpn_config('site_titulo'); ?></title>
        <style>
            body {
                font-family: verdana;
                margin: 30px;
                background-color: #cccccc;
            }
            .content {
                padding: 30px;
                background-color: #ffffff;
            }
            .small {
                font-size: 11px;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <h2><?= wpn_config('site_titulo')?> | Recuperação de Senha</h2>
            <p>Olá! Recebemos a confirmação de redefinição de senha para o usuário <b><?= $email; ?></b> no site <?= wpn_config('site_titulo'); ?>.</p>
            <p>Abaixo estão seus novos dados para acesso, recomendamos que acesse e redefina a senha para uma de sua preferência imediatamente.</p>
            <p>
                <b>E-mail: </b><?= $email; ?><br/>
                <b>Senha: </b><?= $password; ?>
            </p>
            <hr/>
            <p class="small"><?= wpn_config('copyright'); ?></p>
        </div>
    </body>
</html>
