<div class="sidebar-banner">
    <?php
    
    foreach ($banners as $row) {
        $output = "";
        $conf_foto = array(
            'src' => 'media/banners/' . $row->content,
            'class' => 'img-responsive',
        );
        $output =  img($conf_foto);
            if ($row->href) {
                $output =  anchor($row->href, img($conf_foto), ['target' => $row->target]);
            }
        
        echo '<div class="sidebar-item">' . $output . '</div>';
    } 
    
    ?>
</div>