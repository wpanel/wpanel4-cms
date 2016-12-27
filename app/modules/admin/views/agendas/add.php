<?= $this->wpanel->load_editor(); ?>
<section class="content-header">
    <h1>
        Agendas de eventos
        <small>Gerencie os eventos que serão exibidos no site aqui.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('admin/agendas'); ?>"><i class="fa fa-calendar"></i> Agendas</a></li>
        <li>Cadastro de evento</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Cadastro de evento</h3>
        </div>
        <div class="box-body">
			<?= form_open_multipart('admin/agendas/add', array('role'=>'form')); ?>
				<div class="form-group" >
					<label for="title">Título do evento</label>
					<input type="text" name="title" value="" class="form-control"  />
                    <?= form_error('title'); ?>
				</div>
				<div class="form-group" >
					<label for="description">Local</label>
					<input type="text" name="description" value="" class="form-control" rows="3"  />
				</div>
				<div class="form-group" >
					<label for="content">Conteúdo</label>
					<textarea name="content" cols="40" rows="10" class="form-control ckeditor" id="editor" ></textarea>
				</div>
				<div class="row " id="">
					<div class="col-md-3 " id="">
						<div class="form-group" >
							<label for="userfile">Imagem de capa</label>
							<input type="file" name="userfile" value="" class="form-control"  />
						</div>
					</div>
					<div class="col-md-3 " id="">
						<div class="form-group" >
							<label for="created">Data </label>
							<input type="text" name="created" value="" class="form-control"  />
                            <?= form_error('created'); ?>
						</div>
					</div>
					<div class="col-md-3 " id="">
						<div class="form-group" >
							<label for="tags">Palavras-chave (Separe com vírgula)</label>
							<textarea name="tags" cols="40" rows="5" class="form-control" ></textarea>
						</div>
					</div>
					<div class="col-md-3 " id="">
						<div class="form-group" >
							<label for="status">Status</label>
							<select name="status" class="form-control">
								<option value="0">Rascunho</option>
								<option value="1">Publicado</option>
							</select>
						</div>
					</div>
				</div>
				<hr/>
				<div class="row " id="">
					<div class="col-md-12 " id="">
						<button name="submit" type="submit" class="btn btn-primary" >Cadastrar</button>
						&nbsp;
						<?= anchor('admin/agendas', 'Cancelar', array('class' => 'btn btn-danger')); ?>
					</div>
				</div>
			<?= form_close(); ?>
        </div>
    </div>
</section>
