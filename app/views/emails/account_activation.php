<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ativação de cadastro | <?= wpn_config('site_titulo'); ?></title>
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
            <h2><?= wpn_config('site_titulo')?> | Ativação de cadastro</h2>
            <p>Olá! Recebemos uma solicitação de cadastro para o e-mail <b><?= $email; ?></b> no site <?= wpn_config('site_titulo'); ?>.</p>
            <p>Para concluir o procedimento de ativação do cadastro, clique no link abaixo. Se o link não estiver ativo, copie e cole o link diretamente no seu navegador.</p>
            <p><?= anchor('users/activate/' . $token); ?></p>        
            <p><b>Nota:</b> Caso você não tenha solicitado este cadastro, por favor <?= anchor('contact','entre em contato conosco'); ?>.</p>        
            <hr/>
            <p class="small"><?= wpn_config('copyright'); ?></p>
        </div>
    </body>
</html>
