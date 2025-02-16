<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<!-- Bibliotecas adicionais para o Fancybox. -->
<script type="text/javascript" src="<?= base_url('lib/plugins/fancybox/jquery.fancybox.pack.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('lib/plugins/fancybox/jquery.easing.pack.js'); ?>"></script>
<link rel="stylesheet" href="<?= base_url('lib/plugins/fancybox/jquery.fancybox.css'); ?>" type="text/css" media="screen" />
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header"><?= $album->titulo; ?></h1>
        <p><?= $album->descricao; ?></p>
        <p><?= mdate('%d/%m/%Y', strtotime($album->created_on)); ?></p>
    </div>
</div>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
        <?= $this->widget->load('wpnaddthisbuttons'); ?>      
    </div>
</div>
<div class="row">
    <?php
    $num_cols = 1;
    foreach ($pictures as $row) {

        /**
         * Performs a simple calculation to adjust the total
         * number of columns to the bootstrap class.
         */
        $col = 12 / $max_cols;
        ?>
        <div class="col-md-<?= $col; ?>">
            <?php
            $conf_foto = array(
                'src' => base_url('/media/albuns/' . $album->id . '/' . $row->filename),
                'class' => 'img-responsive',
                'alt' => $row->descricao
            );

            // Mounts the link according to the configuration display definition.
            switch (wpn_config('media_show_photo')) {
                case 'normal':
                    echo anchor('picture/'.wpn_fakelink($album->titulo).'/'.$row->id, img($conf_foto));
                    break;
                case 'fancybox':
                    echo anchor(base_url('media/albuns/' . $album->id . '/' . $row->filename), img($conf_foto) ,array('class' => 'fancybox', 'role' => 'group'));
                    break;
            }
            
            ?>
            <h4><?= $row->descricao; ?></h4>
        </div>
    <?php
    // Creates a new line according to the number of items per line.
    if ($num_cols == $max_cols) {
        $num_cols = 1;
        echo '</div><div class="row">';
    } else {
        $num_cols = $num_cols + 1;
    }
}
?>
</div>

<div class="row">
    <div class="col-sm-12 col-md-12 text-center">
        <?= $pagination_links; ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <!-- Shows album keywords.. -->
        <?= $this->widget->load('wpntagsfrompost', array('tags'=>$album->tags)); ?>
    </div>
</div>

<div class="row" style="margin-top: 20px;">
    <div class="col-md-12">
        <h3 class="page-header"><?= wpn_lang('head_comments'); ?></h3>
        <?= $this->widget->load('wpnfacebookcomments', array('link' => site_url('album/' . $album->id))); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>