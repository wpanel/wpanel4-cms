<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<!-- Mostra o título da categoria caso esteja listando uma. -->
<?php if (isset($view_title)) { ?>
    <h1 class="page-header"><?php echo $view_title; ?></h1>
    <p><?php echo $view_description; ?></p>
<?php } ?>
<!-- Mostra a lista de postagens em formato de mosaico. -->
<div class="row">
    <?php
    $num_cols = 1;
    foreach ($posts as $post)
    {
        /*
         * Faz um calculo simples para adequar o total
         * de colunas à class do bootstrap.
         */
        $col = 12 / $max_cols;
        ?>
        <div class="col-md-<?php echo $col; ?> wpn-postagens">
            <h3><?php echo anchor('post/' . $post->link, $post->title); ?></h3>
            <p class="text-muted">
                <span>Postado dia <?php echo mdate('%d/%m/%Y', strtotime($post->created_on)); ?> <br/></span>
                <small><?php echo $this->widget->load('wpncategoryfrompost', array('post_id' => $post->id)); ?></small>
            </p>
            <?php
            // Exibe a imagem de capa caso ela exista.
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
            <p><?php echo anchor('post/' . $post->link, 'Continuar lendo...'); ?></p>
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