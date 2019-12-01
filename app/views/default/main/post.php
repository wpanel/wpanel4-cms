<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<div class="row wpn-postagem">
    <div class="col-md-12">
        <h1 class="page-header"><?= $post->title; ?></h1>
        <p class="text-muted">
            <span>Postado dia <?= mdate('%d/%m/%Y', strtotime($post->created_on)); ?> <br/></span>
            <?php if($post->page==0){ ?>
                <small>
                    <span class="category">
                        <?= $this->widget->load('wpncategoryfrompost', array('post_id' => $post->id)); ?>
                    </span>
                </small>
            <?php } ?>
        </p>
        <?php
        // Exibe a imagem de capa caso ela exista.
        if (file_exists('./media/capas/'.$post->image)) {
            ?>
            <div class="wpn-capa">
                <?php
                $img_param = array(
                    'src'=>'media/capas/'.$post->image,
                    'alt'=>$post->title,
                    'class'=>'img-responsive', 
                    'style'=>'margin-top:5px;'
                );
                echo img($img_param);
                ?>
            </div>
            <?php
        }
        ?>
        <div class="row wpn-social-buttons">
            <div class="col-md-12">
                <!-- Mostra os botões de compartilhamento do AddThis. -->
                <?= $this->widget->load('wpnaddthisbuttons'); ?>
            </div>
        </div>
        <!-- Mostra o conteúdo da postagem. -->
        <?= $post->content; ?>
        <!-- Mostra os comentários do Facebook caso não seja uma 'Páina'. -->
        <?php if ($post->page==0) { ?>
            <h4>Comentarios</h4>
            <?= $this->widget->load('wpnfacebookcomments', array('link' => site_url('post/'.$post->link))); ?>
        <?php } ?>
        <!-- Mostra as palavras-chave da postagem. -->
        <?= $this->widget->load('wpntagsfrompost', array('tags'=>$post->tags)); ?>
    </div>
</div>