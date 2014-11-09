<?php

if (@$titulo_view) {
    echo '<h1 class="page-header">'.$titulo_view.'</h1>';
}

?>

<div class="row">
<?php
foreach ($posts->result() as $post) {
?>
    <div class="col-md-4">
        <div class="thumbnail">
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
            <div class="caption">
                <h3><?php echo anchor('post/'.$post->link, $post->title); ?></h3>
            </div>
            
        </div>
    </div>
<?php
}
?>
</div>