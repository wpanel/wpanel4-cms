<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('module_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/modulos'); ?>"><i class="fa fa-cog"></i> <?= wpn_lang('module_title'); ?></a></li>
        <li><a href="<?= site_url('admin/modulos/edit/'.$module_id); ?>"><i class="fa fa-cog"></i> <?= wpn_lang('wpn_actions'); ?></a></li>
        <li><?= wpn_lang('module_edit_action'); ?></li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_edit_action'); ?></h3>
        </div>
        <div class="box-body">
			<form action="<?= site_url('admin/modulos/altaction/'.$row->id.'/'.$row->module_id); ?>" role="form" class="form-horizontal" method="post" accept-charset="utf-8">
				
				<div class="form-group">
					<label for="id" class="col-sm-2 col-md-2 control-label"><?= wpn_lang('field_description'); ?></label>
					<div class="col-sm-10 col-md-10">
						<input type="text" name="description" id="description" value="<?= $row->description;?>" class="form-control" />
						<?= form_error('description'); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label for="id" class="col-sm-2 col-md-2 control-label"><?= wpn_lang('field_link'); ?></label>
					<div class="col-sm-10 col-md-10">
						<input type="text" name="link" id="link" value="<?= $row->link;?>" class="form-control" />
						<?= form_error('link'); ?>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-10 col-md-10 col-md-offset-2 col-sm-offset-2">
						<label>
							<input type="checkbox" name="whitelist" value="1" <?php if($row->whitelist == '1') echo 'checked';?> />
							<?= wpn_lang('field_whitelist'); ?>
						</label>
					</div>
				</div>
				
				<hr/>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10 col-md-offset-2 col-md-10">
						<button type="submit" class="btn btn-primary" ><?= wpn_lang('wpn_bot_save'); ?></button>
						<?= anchor('admin/modulos/edit/'.$row->module_id, wpn_lang('wpn_bot_cancel'), array('class'=>'btn btn-danger')); ?>
					</div>
				</div>
			</form>
        </div>
    </div>
</section>