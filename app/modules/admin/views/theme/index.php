<?php $this->load->view('theme/header'); ?>
<?php if (isset($notice)) : ?>
    <?php echo $notice; ?>
<?php else : ?>
<?php endif; ?>
<?= $view_content ?>
<?php $this->load->view('theme/footer'); ?>