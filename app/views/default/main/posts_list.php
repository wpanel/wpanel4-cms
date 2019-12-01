<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<!-- Mostra o título da categoria caso esteja listando uma. -->
<?php if (isset($view_title)) { ?>
    <h1 class="page-header"><?= $view_title; ?></h1>
    <p><?= $view_description; ?></p>
<?php } ?>
<!-- Mostra a lista de postagens. -->
<?php
foreach($posts as $post){
    ?>
    <div class="row">
        <div class="col-md-12 wpn-postagens">
            <h3><?= anchor('post/'.$post->link, $post->title); ?></h3>
            <p class="text-muted">
                <span>Postado dia <?= mdate('%d/%m/%Y', strtotime($post->created_on)); ?> <br/></span>
                <small><?= $this->widget->load('wpncategoryfrompost', array('post_id' => $post->id)); ?></small>
            </p>
            <?php
            // Exibe a imagem de capa caso ela exista.
            if (file_exists('./media/capas/'.$post->image)) {
                ?>
                <div class="wpn-capa">
                    <?php
                    $img_data = array(
                        'src'=>'media/capas/'.$post->image, 
                        'class'=>'img-responsive', 
                        'style'=>'margin-top:5px;', 
                        'alt'=>$post->title, 
                        'title'=>$post->title
                    );
                    echo anchor('post/'.$post->link, img($img_data));
                    ?>
                </div>
                <?php
            }
            ?>
            <p><?= word_limiter(strip_tags($post->content), 60); ?></p>
            <p><?= anchor('post/'.$post->link, 'Continuar lendo...'); ?></p>
        </div>
    </div>
    <?php
}
?>