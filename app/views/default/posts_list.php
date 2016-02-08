<?php

if (isset($titulo_view)) {
    echo '<h3 class="page-header">'.$titulo_view.'</h3>';
    echo '<p>'.$descricao_view.'</p>';
}

foreach ($posts->result() as $post) {
    ?>
    <div class="row">
        <div class="col-md-12 wpn-postagens">
            <h3><?php echo anchor('post/'.$post->link, $post->title); ?></h3>
            <p class="text-muted">
                <span>Postado dia <?php echo mdate('%d/%m/%Y', strtotime($post->created)); ?> <br/></span>
                <small><?= wpn_widget('categoryfrompost', array('post_id' => $post->id)); ?></small>
            </p>
            <?php
            if ($post->image) {
                ?>
                <div class="wpn-capa">
                    <!-- Largura mínima de 700px -->
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
            <p><?php echo word_limiter(strip_tags($post->content), 60); ?></p>
            <p><?= anchor('post/'.$post->link, 'Continuar lendo...'); ?></p>
        </div>
    </div>
    <?php
}
?>