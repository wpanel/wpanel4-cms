<!-- Fancybox aditional libraries. -->
<script type="text/javascript" src="<?= base_url('lib/plugins/fancybox/jquery.fancybox.pack.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('lib/plugins/fancybox/jquery.easing.pack.js'); ?>"></script>
<link rel="stylesheet" href="<?= base_url('lib/plugins/fancybox/jquery.fancybox.css'); ?>" type="text/css" media="screen" />
<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="page-header"><?= $album->titulo; ?></h3>
        <p><?= $album->descricao; ?></p>
        <p><?= mdate('%d/%m/%Y', strtotime($album->created)); ?></p>
    </div>
</div>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-sm-12 col-md-12">
        <?= wpn_widget('addthisbuttons'); ?>      
    </div>
</div>
<div class="row">
    <?php
    $num_cols = 1;
    foreach ($pictures as $row)
    {
        $col = 12 / $max_cols;
        ?>
        <div class="col-md-<?= $col; ?>">
            <?php
            $conf_foto = array(
                'src' => base_url('/media/albuns/' . $album->id . '/' . $row->filename),
                'class' => 'img-responsive',
                'alt' => $row->descricao
            );
            // Link antigo para exibição da foto em outra página.
            // echo anchor('foto/'.wpn_fakelink($album->titulo).'/'.$row->id, img($conf_foto));
            ?>
            <a href="<?= base_url('media/albuns/' . $album->id . '/' . $row->filename); ?>" class="fancybox" rel="group"><?= img($conf_foto); ?></a>
            <h4><?= $row->descricao; ?></h4>
        </div>
        <?php
        // Cria uma nova linha de acordo com a quantidade de ítens por linha.
        if ($num_cols == $max_cols)
        {
            $num_cols = 1;
            echo '</div><div class="row">';
        } else
        {
            $num_cols = $num_cols + 1;
        }
    }
    ?>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-sm-12 col-md-12">
        <h3 class="page-header">Comentários</h3>
<?= wpn_widget('facebookcomments', array('link' => site_url('album/' . $album->id))); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>