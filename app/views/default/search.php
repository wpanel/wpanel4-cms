<h1 class="page-header">Resultados da busca por: <?= $search_terms; ?></h1>
<!-- Mostra a lista de resultados. -->
<?php foreach ($results as $row) { ?>
    <div class="row wpn-postagens">
        <div class="col-sm-12 col-md-12">
            <h3><?= anchor('post/'.$row->link, $row->title); ?></h3>
            <p class="text-muted">
                <span>Postado dia <?= mdate('%d/%m/%Y', strtotime($row->created)); ?> <br/></span>
                <small><?= wpn_widget('categoryfrompost', array('post_id' => $row->id)); ?></small>
            </p>
            <?php
            // Exibe a imagem de capa caso ela exista.
            if (file_exists('./media/capas/'.$row->image)) {
            ?>
            <div class="wpn-capa">
                <?php
                $img_data = array(
                    'src'=>'media/capas/'.$row->image, 
                    'class'=>'img-responsive', 
                    'style'=>'margin-top:5px;', 
                    'alt'=>$row->title, 
                    'title'=>$row->title
                );
                echo anchor('post/'.$row->link, img($img_data));
                ?>
            </div>
            <?php
            }
            ?>
            <p><?= word_limiter(strip_tags($row->content), 60); ?></p>
        </div>
    </div>
    <?php
}
?>