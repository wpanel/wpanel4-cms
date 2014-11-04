<!-- Postagem. -->
<div class="row">
    <div class="col-md-12">
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
        ?>
    </div>
</div>
<!-- end - Postagem. -->