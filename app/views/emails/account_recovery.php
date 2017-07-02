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
            <p>Olá! Recebemos uma solicitação de redefinição de senha para o usuário <b><?= $email; ?></b> no site <?= wpn_config('site_titulo'); ?>.</p>
            <p>Para concluir o procedimento de redefinição de sua senha de acesso, clique no link abaixo. Se o link não estiver ativo, copie e cole o link diretamente no seu navegador.</p>
            <p><?= anchor('users/recovery/' . $token); ?></p>        
            <p><b>Nota:</b> Caso você não tenha solicitado a redefinição dos seus dados, basta ignorar esta mensagem, seus dados estão seguros.</p>        
            <hr/>
            <p class="small"><?= wpn_config('copyright'); ?></p>
        </div>
    </body>
</html>
