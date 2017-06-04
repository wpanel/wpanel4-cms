<h3 class="page-header">Eventos</h3>
<!-- Mostra a lista de eventos. -->
<?php foreach($events as $event){ ?>
    <div class="row wpn-postagens">
        <div class="col-md-12">
            <h1><?= anchor('event/'.$event->link, $event->title); ?></h1>
            <p class="text-muted">
                <span><b>Data</b> <?= mdate('%d/%m/%Y', strtotime($event->created)); ?> | <b>Local</b> <?= $event->description; ?><br/></span>
            </p>
            <?php
            // Exibe a imagem de capa caso ela exista.
            if (file_exists('./media/capas/'.$event->image)) {
                ?>
                <div class="wpn-capa">
                    <?php
                    $img_data = array(
                        'src'=>'media/capas/'.$event->image, 
                        'class'=>'img-responsive', 
                        'style'=>'margin-top:5px;', 
                        'alt'=>$event->title, 
                        'title'=>$event->title
                    );
                    echo anchor('event/'.$event->link, img($img_data));
                    ?>
                </div>
                <?php
            }
            ?>
            <p><?= word_limiter(strip_tags($event->content), 60); ?></p>
        </div>
    </div>
    <?php
}
?>