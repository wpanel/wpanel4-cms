<?php

if (@$titulo_view) {
    echo '<h3 class="page-header">'.$titulo_view.'</h3>';
}

?>

<div class="row wpn-postagens">
<?php
$col = 1; // Contador de ítens.
$max_col = 3; // Número máximo de ítens por  linha.
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
    // Cria uma nova linha de acordo com a quantidade de ítens por linha.
    if($col == $max_col){ $col = 1; echo '</div><div class="row wpn-postagens">'; } else { $col = $col +1; }
}
?>
</div>