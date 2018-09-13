<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header"><?= $video->titulo; ?></h1>
    </div>
</div>
<div class="row wpn-social-buttons">
    <div class="col-md-12">
        <?= $this->widget->load('wpnaddthisbuttons'); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="embed-responsive embed-responsive-16by9">
            <iframe src="//www.youtube.com/embed/<?= $video->link; ?>" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h5>Descrição</h5>
        <p><?= $video->descricao; ?></p>
        <!-- Mostra as palavras-chave da postagem. -->
        <?= $this->widget->load('wpntagsfrompost', array('tags'=>$video->tags)); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3>Comentários</h3>
        <?= $this->widget->load('wpnfacebookcomments', array('link' => site_url('video/' . $video->link . '/' . wpn_fakelink($video->titulo)))); ?>
    </div>
</div>