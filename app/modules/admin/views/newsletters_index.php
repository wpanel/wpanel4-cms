<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <b>Exportar emails para newsletter</b>
    </div>
    <div class="panel-body">
        <p>
            Abaixo estão os emails de contatos cadastrados pelo formulário "Newsletter" 
            no site, use-os para enviar mensagens com as novidades.
        </p>
        <p>
            <b>Nota:</b>
            O wPanel não faz envio de mensagens em massa, utilize um serviço separado
            para isso.
        </p>
        <div class="well well-sm">
            <samp>
            <?php 
            foreach($contatos as $row) {
                echo $row->nome . " &lt;".$row->email."&gt;,\n";
            }
            ?>
            </samp>
        </div>
    </div>
</div>