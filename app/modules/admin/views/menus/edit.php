<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('module_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/menus'); ?>"><i class="fa fa-reorder"></i> <?= wpn_lang('module_title'); ?></a></li>
        <li><?= wpn_lang('module_edit'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_edit'); ?></h3>
        </div>
        <div class="box-body">
        	<?php

			echo form_open_multipart('admin/menus/edit/'.$row->id, array('role' => 'form'));

			echo div(array('class' => 'form-group'));
			echo form_label(wpn_lang('field_nome'), 'nome');
			echo form_input(array('name' => 'nome', 'value' => $row->nome, 'class' => 'form-control'));
			echo form_error('nome');
			echo close_div();

			echo row();

			$options_pos = config_item('pos_menus');

			echo col(2);
			echo div(array('class' => 'form-group hidden'));
			echo form_label('Posição', 'posicao');
			echo form_dropdown('posicao', $options_pos, $row->posicao, 'disabled', 'form-control');
			echo form_error('posicao');
			echo close_div(2);

			// Opções de estilo
			$options_estilo = array(
			    'lista' => 'Lista',
			    'linha' => 'Linha',
			    'coluna' => 'Coluna'
			);


			echo col(3);
			echo div(array('class' => 'form-group hidden'));
			echo form_label('Estilo', 'estilo');
			echo form_dropdown('estilo', $options_estilo, $row->estilo, 'disabled', 'form-control');
			echo close_div(3);

			echo row();
			echo col();
			echo form_button(
			        array(
			            'type' => 'submit',
			            'name' => 'submit',
			            'content' => wpn_lang('wpn_bot_save'),
			            'class' => 'btn btn-primary'
			        )
			);
			echo nbs();
			echo anchor('admin/menus', wpn_lang('wpn_bot_cancel'), array('class' => 'btn btn-danger'));
			echo close_div(2);

			echo form_close();
			?>
		</div>
	</div>
</section>
