<?php

if ($titulo_view) {
    echo '<h1 class="page-header">'.$titulo_view.'</h1>';
}

foreach ($posts->result() as $post) {
?>
<div class="row">
    <div class="col-md-2 text-center hidden-xs">
        <h2><?php echo mdate('%d', strtotime($post->created)); ?></h2>
        <p><?php echo mdate('%M', strtotime($post->created)); ?></p>
    </div>
    <div class="col-md-10">
        <h2><?php echo anchor('post/'.$post->link, $post->title); ?></h2>
        <p class="text-muted">
            <span class="visible-xs"> Postado dia <?php echo mdate('%d/%m/%Y', strtotime($post->created)); ?> <br/></span>
            <small><?php echo $this->wpanel->categorias_do_post($post->id); ?></small>
        </p>
        <?php
        if ($post->image) {
        ?>
        <div style="height:200px;overflow: hidden;margin-top:15px;margin-bottom:15px;" class="thumbnail">
            <!-- Largura mínima de 700px -->
            <?php
            $img_data = array(
                'src'=>'media/capas/'.$post->image, 
                'class'=>'img-responsive', 
                'style'=>'margin-top:5px;', 
                'alt'=>$post->title, 
                'title'=>$post->title
            );
            echo img($img_data);
            ?>
        </div>
        <?php
        }
        ?>
        <p>
            <?php echo word_limiter(strip_tags($post->content), 60); ?>
        </p>
    </div>
</div>
<?php
}
?>