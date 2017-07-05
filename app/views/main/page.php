<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<div class="row wpn-postagem">
    <div class="col-md-12">
        <h1 class="page-header"><?php echo $post->title; ?></h1>
        <p class="text-muted">
            <span>Postado dia <?php echo mdate('%d/%m/%Y', strtotime($post->created_on)); ?> <br/></span>
            <small>
                <?php if ($post->page==0){ ?>
                    <span class="category">
                        <?= $this->widget->load('wpncategoryfrompost', array('post_id' => $post->id)); ?>
                    </span>
                <?php } ?>
            </small>
        </p>
        <?php
        if ($post->image) {
            ?>
            <div class="wpn-capa">
                <!-- Largura mínima de 700px -->
                <?php
                $img_param = array(
                    'src'=>'media/capas/'.$post->image,
                    'alt'=>$post->title,
                    'class'=>'img-responsive', 'style'=>'margin-top:5px;'
                );
                echo img($img_param);
                ?>
            </div>
            <?php
        }
        ?>
        <div class="row wpn-social-buttons">
            <div class="col-md-12">
                <?= $this->widget->load('wpnaddthisbuttons'); ?>
            </div>
        </div>
        <?php

        echo $post->content;

        if ($post->page==0) {
            echo '<h4>Comentarios</h4>';
            echo $this->widget->load('wpnfacebookcomments', array('link' => site_url('post/'.$post->link)));
        }
        
        echo $this->widget->load('wpntagsfrompost', array('tags'=>$post->tags));

        ?>
    </div>
</div>