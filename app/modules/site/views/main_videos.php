<?php
function get_code_video($var=''){
    $x = explode('v=', $var);
    $y = explode('&', $x[1]);
    return $y[0]; //'ahIeUqQEgtg';
}
?>
<div class="row">
  <div class="col-md-12">
    <h3>Lista de vídeos </h3>
  </div>
  </div>
  <div class="row">
    <?php
   $col = 1;
    foreach($lista_videos as $item){
      ?>
      <div class="col-md-4">
        <div class="thumbnail">
          <!-- 400x300 -->
          <?php
          if ($enclosure = $item->get_enclosure())
          {
            $image_properties = array(
                      'src' => $enclosure->get_thumbnail(),
                      'class' => 'img-responsive'
            );
            echo img($image_properties);
          }
          ?>
          <div class="caption">
            <h3><?= anchor('video/'.get_code_video($item->get_link()),$item->get_title()); ?></h3>
          </div>
        </div>
      </div>
      <?php
      if($col == 3){
        echo '</div><div class="row">';
        $col = 1;
      } else {
        $col = $col +1;
      }
    }
    ?>
  </div>

