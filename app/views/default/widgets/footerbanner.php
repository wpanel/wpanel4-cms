<div class="wpn-footer-banner">
    <?php 
    
    foreach ($banners as $row) {
        $output = "";
        $conf_foto = array(
            'src' => 'media/banners/' . $row->content
        );
        $output = img($conf_foto);
        if ($row->href) {
            $output = anchor($row->href, img($conf_foto), ['target' => $row->target]);
        }
        echo $output;
    } 
    
    ?>
</div>