<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header"><?= $album->titulo; ?></h1>
        <p><?= $album->descricao; ?></p>
        <p><?= mdate('%d/%m/%Y', strtotime($album->created_on)); ?></p>
        <!-- <hr/> -->
    </div>
</div>

<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
        <?= $this->widget->load('wpnaddthisbuttons'); ?>      
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php
        $conf_foto = array(
            'src' => '/media/albuns/' . $album->id . '/' . $picture->filename,
            'class' => 'img-responsive',
            'alt' => $picture->descricao
        );
        echo img($conf_foto);
        ?>
        <h4><?= $picture->descricao; ?></h4>
    </div>
</div>

<div class="row" style="margin-top: 20px;">
    <div class="col-md-12">
        <h3 class="page-header">Comentários</h3>
        <?= $this->widget->load('wpnfacebookcomments', array('link' => site_url('foto/' . $picture->id))); ?>
    </div>
</div>

<div class="row wpn-ads">
    <div class="col-md-12">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-0286050943868335"
             data-ad-slot="6888761431"
             data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
</div>