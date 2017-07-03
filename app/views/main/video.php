<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <h3 class="page-header"><?= $video->titulo; ?></h3>
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
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3>Comentários</h3>
        <?= $this->widget->load('wpnfacebookcomments', array('link' => site_url('video/' . $video->link . '/' . wpn_fakelink($video->titulo)))); ?>
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