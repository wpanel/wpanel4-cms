<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        Newsletters
        <small>Exporte os emails para newsletter.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><i class="fa fa-envelope-o"></i> Newsletters</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de contatos</h3>
        </div>
        <div class="box-body">
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
</section>