<?= $editor; ?>
<section class="content-header">
    <h1>
        Configurações
        <small>Gerencie configurações gerais do site nesta área.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><i class="fa fa-cog"></i> Configurações</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-body">
            <form method="post" action="<?= site_url('admin/configuracoes/index'); ?>" enctype="multipart/form-data" role="form">
                <ul class="nav nav-pills" role="tablist" style="margin-bottom:20px;">
                    <li class="active"><a href="#geral" role="tab" data-toggle="tab">Configurações gerais</a></li>
                    <li><a href="#home" role="tab" data-toggle="tab">Página inicial</a></li>
                    <li><a href="#layout" role="tab" data-toggle="tab">Layout</a></li>
                    <li><a href="#contato" role="tab" data-toggle="tab">Contatos</a></li>
                    <li><a href="#social" role="tab" data-toggle="tab">Social e compartilhamento</a></li>
                    <li><a href="#backup" role="tab" data-toggle="tab">Backup dos dados</a></li>
                </ul>
                <div class="tab-content">
                    <!--Painel de configuração geral-->
                    <div class="tab-pane active  panel panel-default" id="geral">
                        <div class="panel-heading">
                            Configurações gerais
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="site_titulo">Título do site</label>
                                    <input type="text" name="site_titulo" id="site_titulo" value="<?= $row->site_titulo; ?>" class="form-control" placeholder="Digite um título para o seu site." />
                                </div>
                                <div class="form-group">
                                    <label for="site_desc">Descrição do site</label>
                                    <textarea name="site_desc" id="site_desc" class="form-control" placeholder="Digite uma descrição para melhorar a visibilidade do site nos mecanismos de busca."><?= $row->site_desc; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="site_tags">Palavras-chave do site</label>
                                    <input type="text" name="site_tags" id="site_tags" value="<?= $row->site_tags ?>" class="form-control" placeholder="Digite as palavras-chave para seu site." />
                                </div>
                                <div class="form-group">
                                    <label for="copyright">Nota de rodapé (Copyright)</label>
                                    <input type="text" name="copyright" id="copyright" value="<?= $row->copyright ?>" class="form-control" placeholder="Digite uma nota para o rodapé do seu site." />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="home_category">Idioma</label>
                                    <select name="language" class="form-control">
                                        <?php foreach(config_item('available_languages') as $key => $item){ ?>
                                            <option value="<?= $key; ?>" <?php if($row->language == $key){ echo 'selected'; } ?> ><?= $item['label']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="home_category">Editor de texto</label>
                                    <?php
                                    $available_editors = config_item('available_editors');
                                    echo form_dropdown('text_editor', $available_editors, [$row->text_editor], array('class'=>'form-control')); 
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="home_category">Autor ou responsável</label>
                                    <input type="text" name="author" id="author" value="<?= $row->author ?>" class="form-control" placeholder="Ex: Nome do autor <email@site.com>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Painel de configuração da página inicial-->
                    <div class="tab-pane panel panel-default" id="home">
                        <div class="panel-heading">
                            Página inicial
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="home_tipo" value="category" <?= $category_check; ?> class="radio" />
                                        Usar uma listagem de categoria como página inicial.
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="home_category">Categorias disponíveis</label>
                                    <?= form_dropdown('home_category', $opt_categoria, $row->home_id, array('class'=>'form-control')); ?>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="home_tipo" value="page" <?= $page_check; ?> class="radio" />
                                        Usar uma página ou postagem como página inicial.
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="home_post">Páginas e postagens disponíveis</label>
                                    <?= form_dropdown('home_post', $opt_posts, $row->home_id, array('class'=>'form-control')); ?>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="home_tipo" value="custom" <?= $custom_check; ?> class="radio" />
                                        Usar uma página personalizada como página inicial.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Painel de configuração do layout-->
                    <div class="tab-pane panel panel-default" id="layout">
                        <div class="panel-heading">
                            Layout
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <h4>Logomarca</h4>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Visualização</label><br/>
                                            <?php
                                            if ($row->logomarca) {
                                                echo img(array('src' => 'media/' . $row->logomarca, 'class' => 'img-responsive img-thumbnail', 'style' => 'margin-top:5px;'));
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="logomarca">Selecione uma nova imagem</label>
                                            <input type="file" name="logomarca" id="logomarca" class="form-control" />
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="alterar_logomarca" value="1" class="checkbox" />
                                                    Marque para alterar ou excluir a logomarca atual.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h4>Imagem de fundo</h4>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Visualização</label><br/>
                                            <?php
                                            if ($row->background) {
                                                echo img(array('src' => 'media/' . $row->background, 'class' => 'img-responsive img-thumbnail', 'style' => 'margin-top:5px;'));
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="background">Selecione uma nova imagem</label>
                                            <input type="file" name="background" id="background" class="form-control" />
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="alterar_background" value="1" class="checkbox" />
                                                    Marque para alterar ou excluir a imagem de fundo atual.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h4>Cor de fundo</h4>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Visualização</label>
                                            <div class="col-md-12" style="height: 50px; background-color: <?= $row->bgcolor ?>;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bgcolor">Selecione uma cor de fundo</label>
                                            <input type="text" name="bgcolor" id="bgcolor" value="<?= $row->bgcolor ?>" class="form-control select_color" placeholder="Ex: #FF99CC" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Painel de configurações de contato-->
                    <div class="tab-pane panel panel-default" id="contato">
                        <div class="panel-heading">
                            Contatos
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="site_contato">Destinatário do formulário de contato</label>
                                    <input type="text" name="site_contato" id="site_contato" value="<?= $row->site_contato ?>" class="form-control" placeholder="Digite o email que receberá as mensagens do formulário de contato." />
                                </div>
                                <div class="form-group">
                                    <label for="site_telefone">Telefone de contato</label>
                                    <input type="text" name="site_telefone" id="site_telefone" value="<?= $row->site_telefone ?>" class="form-control" placeholder="Digite o telefone de contato que será exibido no site." />
                                </div>
                                <div class="form-group">
                                    <label for="texto_contato">Texto da tela de contato</label>
                                    <textarea name="texto_contato" id="editor" class="form-control ckeditor"><?= $row->texto_contato; ?></textarea>
                                </div>
                                <h4 style="margin-top:20px;">Configurações de SMTP</h4>
                                <hr/>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="usa_smtp" value="1" <?= $smtp_checked; ?> class="checkbox" />
                                        Usar um SMTP próprio para enviar as mensagens de contato.
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="smtp_servidor">Servidor SMTP</label>
                                            <input type="text" name="smtp_servidor" id="smtp_servidor" value="<?= $row->smtp_servidor ?>" class="form-control" placeholder="Informe seu servidor de SMTP." />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="smtp_porta">Porta do servidor</label>
                                            <input type="text" name="smtp_porta" id="smtp_porta" value="<?= $row->smtp_porta ?>" class="form-control" placeholder="Informe a porta do seu servidor de SMTP." />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="smtp_usuario">Usuário</label>
                                            <input type="text" name="smtp_usuario" id="smtp_usuario" value="<?= $row->smtp_usuario ?>" class="form-control" placeholder="Informe usuário da conexão." />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="smtp_senha">Senha (visível)</label>
                                            <input type="text" name="smtp_senha" id="smtp_senha" value="<?= $row->smtp_senha ?>" class="form-control" placeholder="Informe a senha da conexão." />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Painel de configuração social-->
                    <div class="tab-pane panel panel-default" id="social">
                        <div class="panel-heading">
                            Social e compartilhamento
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="google_analytics">Código do <a href="http://analytics.google.com" target="_blank">Google Analytics</a></label>
                                    <input type="text" name="google_analytics" id="google_analytics" value="<?= $row->google_analytics ?>" class="form-control" placeholder="Digite o código de rastreio do Googel Analytics." />
                                </div>
                                <div class="form-group">
                                    <label for="addthis_uid">Código "Profile ID" do <a href="https://www.addthis.com" target="_blank">AddThis</a></label>
                                    <input type="text" name="addthis_uid" id="addthis_uid" value="<?= $row->addthis_uid ?>" class="form-control" placeholder="Digite seu código de usuário do AddThis.com" />
                                </div>
                                <div class="form-group">
                                    <label for="link_instagram">Link para a conta do Instagram</label>
                                    <input type="text" name="link_instagram" id="link_instagram" value="<?= $row->link_instagram ?>" class="form-control" placeholder="Informe o linkn da sua conta no Instagram." />
                                </div>
                                <div class="form-group">
                                    <label for="link_twitter">Link para a conta do Twitter</label>
                                    <input type="text" name="link_twitter" id="link_twitter" value="<?= $row->link_twitter ?>" class="form-control" placeholder="Informe o link da sua conta no Twitter." />
                                </div>
                                <div class="form-group">
                                    <label for="link_facebook">Link para o perfil no Facebook</label>
                                    <input type="text" name="link_facebook" id="link_facebook" value="<?= $row->link_facebook ?>" class="form-control" placeholder="Informe o link do seu perfil no Facebook." />
                                </div>
                                <div class="form-group">
                                    <label for="link_likebox">Link da Fan-Page do Facebook para o likebox</label>
                                    <input type="text" name="link_likebox" id="link_likebox" value="<?= $row->link_likebox ?>" class="form-control" placeholder="Informe o link da sua Fan-Page no Facebook." />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Painel de backup dos dados -->
                    <div class="tab-pane  panel panel-default" id="backup">
                        <div class="panel-heading">
                            Backup dos dados
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <p>Clique no botão abaixo para efetuar um backup do banco de dados. Todas as informações sobre postagens, banners, configurações serão salvas.</p>
                                <p>Para fazer um backup dos arquivos, como as imagens, faça-o usando o painel de controle do provedor. Caso não tenha acesso, contate seu webmaster.</p>
                                <p><?= anchor('admin/backups/execute', '<span class="glyphicon glyphicon-circle-arrow-down"></span> Fazer o backup', array('class'=>'btn btn-success')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-confirma-modal-sm"><span class="glyphicon glyphicon-floppy-disk"></span> Salvar as alterações</button>
                </div>
                <div class="modal fade bs-confirma-modal-sm" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header"><b>Confirmação</b></div>
                            <div class="modal-body">
                                <p>Deseja mesmo salvar estas alterações?</p>
                                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Sim, tenho certeza!</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>