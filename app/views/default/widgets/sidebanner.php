<div class="sidebar-banner">
    <?php foreach ($banners as $row) :
        $conf_foto = array(
            'src' => 'media/banners/' . $row->content,
            'class' => 'img-responsive',
        );
        ?>
        <div class="sidebar-item">
            <?php
            if ($row->href) {
                echo anchor($row->href, img($conf_foto), ['target' => $row->target]);
            } else {
                echo img($conf_foto);
            }
            ?>
        </div>
    <?php endforeach; ?>
</div>
