<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<h1 class="page-header"><?= wpn_lang('header_search_results'); ?> <?= $search_terms; ?></h1>
<?php foreach ($results as $row) { ?>
    <div class="row wpn-postagens">
        <div class="col-md-12">
            <h3 class="page-header"><?= anchor('post/' . $row->link, $row->title); ?></h3>
            <p class="text-muted">
                <span><?= wpn_lang('posted_on'); ?> <?= mdate('%d/%m/%Y', strtotime($row->created_on)); ?> <br/></span>
                <small><?= $this->widget->load('wpncategoryfrompost', array('post_id' => $row->id)); ?></small>
            </p>
            <?php
            if (file_exists('./media/capas/' . $row->image)) {
                ?>
                <div class="wpn-capa">
                    <?php
                    $img_data = array(
                        'src' => 'media/capas/' . $row->image,
                        'class' => 'img-responsive',
                        'style' => 'margin-top:5px;',
                        'alt' => $row->title,
                        'title' => $row->title
                    );
                    echo anchor('post/' . $row->link, img($img_data));
                    ?>
                </div>
                <?php
            }
            ?>
            <p><?= word_limiter(strip_tags($row->content), 60); ?></p>
        </div>
    </div>
    <?php
}
?>