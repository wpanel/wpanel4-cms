<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header"><?= wpn_lang('picture_gallery_title'); ?></h1>
    </div>
</div>
<div class="row wpn-social-buttons">
    <div class="col-md-12">
        <?= $this->widget->load('wpnaddthisbuttons'); ?>      
    </div>
</div>
<div class="row">
    <?php
    $num_cols = 1;
    foreach ($albuns as $album) {
        /**
         * Performs a simple calculation to adjust the total
         * number of columns to the bootstrap class.
         */
        $col = 12 / $max_cols;
        ?>
        <div class="col-md-<?= $col; ?>">
        <?php
        // Exibe a imagem de capa caso ela exista.
        if (file_exists('./media/capas/' . $album->capa)) {
            ?>
                <div class="wpn-capa">
                <?php
                $capa = array(
                    'src' => '/media/capas/' . $album->capa,
                    'class' => 'img-responsive',
                    'alt' => $album->titulo
                );
                echo anchor('gallery/' . $album->id . '/' . wpn_fakelink($album->titulo), img($capa));
                ?>
                </div>
                    <?php
                }
                ?>
            <h4>
                <?= anchor('gallery/' . $album->id . '/' . wpn_fakelink($album->titulo), $album->titulo); ?><br/>
                <small><?= mdate('%d/%m/%Y', strtotime($album->created_on)); ?></small>
            </h4>
        </div>
    <?php
    // Creates a new line according to the number of items per line.
    if ($num_cols == $max_cols) {
        $num_cols = 1;
        echo '</div><div class="row">';
    } else
        $num_cols = $num_cols + 1;
}
?>
</div>

<div class="row">
    <div class="col-sm-12 col-md-12 text-center">
        <?= $pagination_links; ?>
    </div>
</div>