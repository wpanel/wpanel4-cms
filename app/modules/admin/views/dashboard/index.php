<section class="content-header">
    <h1>
        Dashboard
        <small>Seja bem vindo ao painel de controle.</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Dashboard</li>
    </ol>
</section>

<section class="content">
    <div class="box">
      <div class="box-body">

<div class="row">
  <div class="col-md-4" style="margin-top:10px;">
    <a 
      href="<?= site_url('admin/posts'); ?>" 
      class="btn btn-primary btn-lg btn-block" 
      style="padding-top:30px;padding-bottom:30px;">
      <span class="glyphicon glyphicon-list-alt"></span> Gerenciar Postagens
    </a>
  </div>
  <div class="col-md-4" style="margin-top:10px;">
    <a 
      href="<?= site_url('admin/pages'); ?>" 
      class="btn btn-primary btn-lg btn-block" 
      style="padding-top:30px;padding-bottom:30px;">
      <span class="glyphicon glyphicon-list-alt"></span> Gerenciar Páginas
    </a>
  </div>
  <div class="col-md-4" style="margin-top:10px;">
    <a 
      href="<?= site_url('admin/banners'); ?>" 
      class="btn btn-primary btn-lg btn-block" 
      style="padding-top:30px;padding-bottom:30px;">
      <span class="glyphicon glyphicon-align-justify"></span> Gerenciar Banners
    </a>
  </div>
</div>

<div class="row">
  <div class="col-md-4" style="margin-top:10px;">
    <a 
      href="<?= site_url('admin/usuarios'); ?>" 
      class="btn btn-warning btn-lg btn-block" 
      style="padding-top:30px;padding-bottom:30px;">
      <span class="glyphicon glyphicon-user"></span> Gerenciar Usuários
    </a>
  </div>
  <div class="col-md-4" style="margin-top:10px;">
    <a 
      href="<?= site_url('admin/configuracoes'); ?>" 
      class="btn btn-danger btn-lg btn-block" 
      style="padding-top:30px;padding-bottom:30px;">
      <span class="glyphicon glyphicon-cog"></span> Configurações
    </a>
  </div>
  <div class="col-md-4" style="margin-top:10px;">
    <a 
      href="<?= site_url(); ?>" target="_blank" 
      class="btn btn-success btn-lg btn-block" 
      style="padding-top:30px;padding-bottom:30px;">
      <span class="glyphicon glyphicon-arrow-left"></span> Ir para o site
    </a>
  </div>
</div>

<!-- <h2 class="page-header">Atalhos</h2> -->

<div class="row" style="margin-top: 15px;">

  <div class="col-md-6">
    <h4>Postagem rápida</h4>
    <?php

    /**
     * Este bloco traz um formulário compacto
     * para o cadastro de novas postagens no
     * site.
     */
    echo form_open_multipart('admin/posts/add', array('role'=>'form'));

    echo div(array('class'=>'form-group'));
    // echo form_label('Título da postagem', 'title');
    echo form_input(array('name'=>'title', 'class'=>'form-control', 'placeholder'=>'Digite o título da postagem'));
    echo form_error('title');
    echo close_div();

    echo div(array('class'=>'form-group'));
    // echo form_label('Conteúdo', 'content');
    echo form_textarea(array('name'=>'content', 'rows'=>'5', 'class'=>'form-control ckeditor', 'placeholder'=>'Digite o texto da postagem', 'id'=>'editor'));
    echo form_error('content');
    echo close_div();

    echo row();
    echo col(4);
    
    // Opções de status
    $options = array(
                      '0'  => 'Rascunho',
                      '1'  => 'Publicado'
                    );
    echo form_dropdown('status', $options, null, null, 'form-control');

    echo close_div();
    echo col(4);
    echo form_button(
            array(
              'type'=>'submit', 
              'name'=>'submit', 
              'content'=>'<span class="glyphicon glyphicon-floppy-disk"></span> Cadastrar a postagem', 
              'class'=>'btn btn-primary'
              )
            );
    echo close_div(2);

    echo form_close();

    ?>
  </div>

  <div class="col-md-3">
    <h4>Páginas e postagens</h4>
    <table class="table table-striped">
      <tbody>
        <tr>
          <td>Postagens cadastradas</td>
          <td><?= badge($total_posts); ?></td>
        </tr>
        <tr>
          <td>Postagens publicadas</td>
          <td><?= badge($total_posts_publicados); ?></td>
        </tr>
        <tr>
          <td>Postagens desativadas</td>
          <td><?= badge($total_posts_rascunhos); ?></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="col-md-3">
    <h4>Banners</h4>
    <table class="table table-striped">
      <tbody>
        <tr>
          <td>Banners cadastrados</td>
          <td><?= badge($total_banners); ?></td>
        </tr>
        <tr>
          <td>Banners publicados</td>
          <td><?= badge($total_banners_publicados); ?></td>
        </tr>
        <tr>
          <td>Banners desativados</td>
          <td><?= badge($total_banners_rascunhos); ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

</div>
</div>
</section>