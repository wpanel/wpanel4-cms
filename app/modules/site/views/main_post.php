<!-- Postagem. -->
<div class="row">
    <?php if ($post->page==0){ ?>
    <div class="col-md-2 text-center hidden-xs">
        <h2><?php echo mdate('%d', strtotime($post->created)); ?></h2>
        <p><?php echo mdate('%M', strtotime($post->created)); ?></p>
    </div>
    <div class="col-md-10">
    <?php } else { ?>
    <div class="col-md-12">
    <?php } ?>
        <h2><?= $post->title; ?></h2>
        <p class="text-muted">
            <span class="visible-xs"> Postado dia <?php echo mdate('%d/%m/%Y', strtotime($post->created)); ?> <br/></span>
            <small>
                <?php if ($post->page==0){ ?><span class="category"><?php echo $this->wpanel->categorias_do_post($post->id); ?></span><?php } ?>
            </small>
        </p>
        <?php
        if ($post->image) {
            ?>
            <div style="margin-top:15px;margin-bottom:15px;" class="thumbnail">
                <!-- Largura mínima de 700px -->
                <?php
                echo img(array('src'=>'media/capas/'.$post->image, 'class'=>'img-responsive', 'style'=>'margin-top:5px;'));
                ?>
            </div>
            <?php
        }

        echo $post->content;

        if ($post->page==0) {
            ?>
            <h3>Comentarios</h3>
            <!-- Comentários do Facebook -->
            <div class="fb-comments" 
                data-href="<?= site_url('post/' . $post->link); ?>" 
                data-num-posts="15" data-width="100%"></div>
            <?php
        }
        ?>
        <?= $this->wpanel->prepare_tags($post->tags); ?>
    </div>
</div>
<!-- end - Postagem. -->