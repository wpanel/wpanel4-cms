<?= $this->wpanel->load_editor(); ?>
<section class="content-header">
    <h1>
        <?= wpn_lang('module_title') ?>
        <small><?= wpn_lang('module_description') ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard') ?></a></li>
        <li><a href="<?= site_url('admin/events'); ?>"><i class="fa fa-calendar"></i> <?= wpn_lang('module_title') ?></a></li>
        <li><?= wpn_lang('module_edit') ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_edit') ?></h3>
        </div>
        <div class="box-body">
		<?= form_open_multipart('admin/events/edit/'.$id, array('role'=>'form')); ?>
			<div class="form-group" >
				<label for="title"><?= wpn_lang('field_title') ?></label>
				<input type="text" name="title" value="<?= $row->title; ?>" class="form-control"  />
				<?= form_error('title'); ?>
			</div>
			<div class="form-group" >
				<label for="description"><?= wpn_lang('field_description') ?></label>
				<input type="text" name="description" value="<?= $row->description; ?>" class="form-control" rows="3"  />
			</div>
			<div class="form-group" >
				<label for="content"><?= wpn_lang('field_content') ?></label>
				<textarea name="content" cols="40" rows="10" class="form-control ckeditor" id="editor">
					<?= $row->content; ?>
				</textarea>
			</div>
			<div class="row " id="">
				<div class="col-md-3 " id="">
					<div class="form-group" >
						<label for="userfile"><?= wpn_lang('field_folder') ?></label>
						<input type="file" name="userfile" value="" class="form-control"  />
							<?php
							$data = array(
								'src' => 'media/capas/'.$row->image,
								'class' => 'img-responsive img-thumbnail',
								'style' => 'margin-top: 5px'
							);
							echo img($data);
							?>
						<div class="checkbox"><label><input type="checkbox" name="alterar_imagem" value="1" /> <?= wpn_lang('change_folder') ?></label></div>
					</div>
				 </div>
			 	<div class="col-md-3 " id="">
					 <div class="form-group" >
						 <label for="created"><?= wpn_lang('field_created_on') ?></label>
					 	<input type="text" name="created" value="<?= datetime_for_user($row->created_on, FALSE); ?>" class="form-control"  />
						<?= form_error('created'); ?>
					 </div>
				 </div>
				 <div class="col-md-3 " id="">
					 <div class="form-group" >
						 <label for="tags"><?= wpn_lang('field_tags') ?></label>
						 <textarea name="tags" cols="40" rows="5" class="form-control" ><?= $row->tags; ?></textarea>
					 </div>
				 </div>
				 <div class="col-md-3 " id="">
					 <div class="form-group" >
						 <label for="status"><?= wpn_lang('field_status') ?></label>
						 <select name="status" class="form-control">
						 	<option value="0" <?php if($row->status == 0){ echo 'selected'; } ?>>Rascunho</option>
						 	<option value="1" <?php if($row->status == 1){ echo 'selected'; } ?>>Publicado</option>
						 </select>
					 </div>
				 </div>
			 </div>
			 <hr/>
			 <div class="row " id="">
				 <div class="col-md-12 " id="">
					 <button name="submit" type="submit" class="btn btn-primary" ><?= wpn_lang('wpn_bot_save') ?></button>
					 &nbsp;<?= anchor('admin/events', wpn_lang('wpn_bot_cancel'), array('class' => 'btn btn-danger')); ?>
				 </div>
			 </div>
			 <?= form_close(); ?>
        </div>
    </div>
</section>
