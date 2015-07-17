<!-- Postagem. -->
<div class="row wpn-postagem">
    <?php if ($post->page==0){ ?>
        <div class="col-md-2 text-center hidden-xs">
            <h2><?php echo mdate('%d', strtotime($post->created)); ?></h2>
            <p><?php echo mdate('%M', strtotime($post->created)); ?></p>
        </div>
        <div class="col-md-10">
    <?php } else { ?>
        <div class="col-md-12">
    <?php } ?>
        <h1><?php echo $post->title; ?></h1>
        <p class="text-muted">
            <span class="visible-xs"> Postado dia <?php echo mdate('%d/%m/%Y', strtotime($post->created)); ?> <br/></span>
            <small>
                <?php if ($post->page==0){ ?>
                    <span class="category">
                        <?= $this->widget->run('categoryfrompost', array('post_id' => $post->id)); ?>
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
                <?= $this->widget->run('addthisbuttons'); ?>
            </div>
        </div>
        <?php

        echo $post->content;

        if ($post->page==0) {
            echo '<h4>Comentarios</h4>';
            echo $this->widget->run('facebookcomments', array('link' => site_url('post/'.$post->link)));
        }
        
        echo $this->widget->run('tagsfrompost', array('link'=>$post->link));

        ?>
    </div>
</div>
<!-- end - Postagem. -->