<div class="page-header">
	<h2>
		Imóveis 
		<small>
			<?= anchor('admin/imoveis/add', '<span class="glyphicon glyphicon-plus-sign"></span> Novo imóvel', array('class'=>'pull-right')); ?>
		</small>
	</h2>
</div>


<div class="table-responsive">
<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Título</th>
			<th>Tipo</th>
			<th>Negócio</th>
			<th>Status</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($imoveis as $row){ ?>
		<tr>
			<td><?= $row->id; ?></td>
			<td><?= $row->titulo; ?></td>
			<td><?= $row->tipo_imovel; ?></td>
			<td><?= $row->tipo_negocio; ?></td>
			<td>
				<?php echo status_post($row->status); ?>
			</td>
			<td>
				<div class="btn-group btn-group-sm">
					<?= anchor('admin/imoveis/edit/'.$row->id, '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'btn btn-default')); ?>
					<?= anchor('admin/imoveis/delete/'.$row->id, '<span class="glyphicon glyphicon-trash"></span>', array('class' => 'btn btn-default', 'onClick'=>'return apagar();')); ?>
				</div>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
</div>