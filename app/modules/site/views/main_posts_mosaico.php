<?php

if (@$titulo_view) {
    echo '<h3 class="page-header">'.$titulo_view.'</h3>';
}

?>

<div class="row wpn-postagens">
<?php
$col = 3;
foreach ($posts->result() as $post)
{
?>
    <div class="col-md-4">
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
            <div class="caption">
                <h4><?php echo anchor('post/'.$post->link, $post->title); ?></h4>
            </div>
        </div>
    </div>
    <?php
    if($col == 3){ $col = 1; echo '</div><div class="row wpn-postagens">'; } else { $col = $col +1; }
}
?>
</div>