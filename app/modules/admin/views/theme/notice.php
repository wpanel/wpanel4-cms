<div id="notices" class="row">
    <div class="col-sm-12 col-md-12">
        <?php if (isset($notice) && is_array($notice)) : ?>
        <div style="margin:5px 8px 5px 5px;" class="alert alert-<?php echo $notice['type']; ?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $notice['message']; ?>
        </div>
        <?php endif; ?>
    </div>
</div>