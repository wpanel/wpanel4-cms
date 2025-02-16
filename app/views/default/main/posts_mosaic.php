<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<!-- Show the category header if it's a list of posts from a category. -->
<?php if (isset($view_title)) { ?>
    <h1 class="page-header"><?php echo $view_title; ?></h1>
    <p><?php echo $view_description; ?></p>
<?php } ?>
<!-- List posts in mosaic format. -->
<div class="row">
    <?php
    $num_cols = 1;
    foreach ($posts as $post)
    {
        $col = 12 / $max_cols;
        ?>
        <div class="col-md-<?php echo $col; ?> wpn-postagens">
            <h3><?php echo anchor('post/' . $post->link, $post->title); ?></h3>
            <p class="text-muted">
                <span><?= wpn_lang('posted_on'); ?> <?php echo mdate('%d/%m/%Y', strtotime($post->created_on)); ?> <br/></span>
                <small><?php echo $this->widget->load('wpncategoryfrompost', array('post_id' => $post->id)); ?></small>
            </p>
            <?php
            if (file_exists('./media/capas/' . $post->image))
            {
                ?>
                <div class="wpn-capa">
                    <?php
                    $img_data = array(
                        'src' => 'media/capas/' . $post->image,
                        'class' => 'img-responsive',
                        'style' => 'margin-top:5px;',
                        'alt' => $post->title,
                        'title' => $post->title
                    );
                    echo anchor('post/' . $post->link, img($img_data));
                    ?>
                </div>
                <?php
            }
            ?>
            <p><?php echo word_limiter(strip_tags($post->content), 60); ?></p>
            <p><?php echo anchor('post/' . $post->link, wpn_lang('keep_reading')); ?></p>
        </div>
        <?php
        if ($num_cols == $max_cols)
        {
            echo '</div><div class="row wpn-postagens">';
            $num_cols = 1;
        } else
            $num_cols = $num_cols + 1;
    }
    ?>
</div>