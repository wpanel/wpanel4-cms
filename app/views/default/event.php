<div class="row wpn-postagem">
    <div class="col-md-12">
        <h1><?php echo $post->title; ?></h1>
        <p class="text-muted">
            <span><b>Data</b> <?php echo mdate('%d/%m/%Y', strtotime($post->created)); ?> | <b>Local</b> <?php echo $post->description; ?><br/></span>
            <small>
                <?php if ($post->page==0){ ?><span class="category"><?php echo $this->wpanel->categorias_do_post($post->id); ?></span><?php } ?>
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
                <?= $this->widget->runit('addthisbuttons'); ?>
            </div>
        </div>
        <?php

        echo $post->content;

        if ($post->page==0) {
            echo '<h4>Comentarios</h4>';
            echo $this->widgets->facebook_comments(site_url('post/'.$post->link));
        }
        
        echo $this->widget->runit('tagsfrompost', array('link'=>$post->link));

        ?>
    </div>
</div>
<div class="row wpn-ads">
    <div class="col-md-12">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- WPanel CMS -->
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