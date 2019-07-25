<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('module_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/accounts'); ?>"><i class="fa fa-users"></i> <?= wpn_lang('wpn_menu_account'); ?></a></li>
        <li><?= wpn_lang('module_add'); ?></li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_add'); ?></h3>
        </div>
        <div class="box-body">
            <form action="<?= site_url('admin/ipbanneds/add'); ?>" role="form" class="form-horizontal" method="post" accept-charset="utf-8">

                <div class="form-group">
                    <label for="id" class="col-sm-2 col-md-2 control-label"><?= wpn_lang('field_ip'); ?></label>
                    <div class="col-sm-3 col-md-3">
                        <input type="text" name="ip_address" id="ip_address" class="form-control" />
                        <?= form_error('ip_address'); ?>
                    </div>
                </div>

                <hr/>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 col-md-offset-2 col-md-10">
                        <button type="submit" class="btn btn-primary" ><?= wpn_lang('wpn_bot_save'); ?></button>
                        <?= anchor('admin/ipbanneds', wpn_lang('wpn_bot_cancel'), array('class' => 'btn btn-danger')); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>