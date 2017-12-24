<?= $editor; ?>
<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('module_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><i class="fa fa-cog"></i> <?= wpn_lang('module_title'); ?></li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-body">
            <?= form_open_multipart('admin/configuracoes/index', array('role' => 'form')); ?>
            <ul class="nav nav-pills" role="tablist" style="margin-bottom:20px;">
                <li class="active"><a href="#geral" role="tab" data-toggle="tab"><?= wpn_lang('tab_common'); ?></a></li>
                <li><a href="#home" role="tab" data-toggle="tab"><?= wpn_lang('tab_homepage'); ?></a></li>
                <li><a href="#layout" role="tab" data-toggle="tab"><?= wpn_lang('tab_layout'); ?></a></li>
                <li><a href="#imagens" role="tab" data-toggle="tab"><?= wpn_lang('tab_images'); ?></a></li>
                <li><a href="#media" role="tab" data-toggle="tab"><?= wpn_lang('tab_media'); ?></a></li>
                <li><a href="#contato" role="tab" data-toggle="tab"><?= wpn_lang('tab_contact'); ?></a></li>
                <li><a href="#social" role="tab" data-toggle="tab"><?= wpn_lang('tab_socialmedia'); ?></a></li>
            </ul>
            <div class="tab-content">
                <!--Painel de configuração geral-->
                <div class="tab-pane active  panel panel-default" id="geral">
                    <div class="panel-heading">
                        <?= wpn_lang('tab_common'); ?>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="site_titulo"><?= wpn_lang('field_site_titulo'); ?></label>
                                <input type="text" name="site_titulo" id="site_titulo" value="<?= $row->site_titulo; ?>" class="form-control" placeholder="<?= wpn_lang('place_site_titulo'); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="site_desc"><?= wpn_lang('field_site_desc'); ?></label>
                                <textarea name="site_desc" id="site_desc" class="form-control" placeholder="<?= wpn_lang('place_site_desc'); ?>"><?= $row->site_desc; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="site_tags"><?= wpn_lang('field_site_tags'); ?></label>
                                <input type="text" name="site_tags" id="site_tags" value="<?= $row->site_tags ?>" class="form-control" placeholder="<?= wpn_lang('place_site_tags'); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="copyright"><?= wpn_lang('field_copyright'); ?></label>
                                <input type="text" name="copyright" id="copyright" value="<?= $row->copyright ?>" class="form-control" placeholder="<?= wpn_lang('place_copyright'); ?>" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="home_category"><?= wpn_lang('field_language'); ?></label>
                                <select name="language" class="form-control">
                                    <?php foreach (config_item('available_languages') as $key => $item) { ?>
                                        <option value="<?= $key; ?>" <?php
                                        if ($row->language == $key) {
                                            echo 'selected';
                                        }
                                        ?> ><?= $item['label']; ?></option>
                                            <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="home_category"><?= wpn_lang('field_text_editor'); ?></label>
                                <?php
                                $available_editors = config_item('available_editors');
                                echo form_dropdown('text_editor', $available_editors, array($row->text_editor), array('class' => 'form-control'));
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="home_category"><?= wpn_lang('field_author'); ?></label>
                                <input type="text" name="author" id="author" value="<?= $row->author ?>" class="form-control" placeholder="<?= wpn_lang('place_author'); ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <!--Painel de configuração da página inicial-->
                <div class="tab-pane panel panel-default" id="home">
                    <div class="panel-heading">
                        <?= wpn_lang('tab_homepage'); ?>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="home_tipo" value="category" <?= $category_check; ?> class="radio" />
                                    <?= wpn_lang('field_home_tipo_category'); ?>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="home_category"><?= wpn_lang('field_category_available'); ?></label>
                                <?= form_dropdown('home_category', $opt_categoria, $row->home_id, array('class' => 'form-control')); ?>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="home_tipo" value="page" <?= $page_check; ?> class="radio" />
                                    <?= wpn_lang('field_home_tipo_page'); ?>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="home_post"><?= wpn_lang('field_pages_available'); ?></label>
                                <?= form_dropdown('home_post', $opt_posts, $row->home_id, array('class' => 'form-control')); ?>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="home_tipo" value="custom" <?= $custom_check; ?> class="radio" />
                                    <?= wpn_lang('field_home_tipo_custom'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Painel de configuração do layout-->
                <div class="tab-pane panel panel-default" id="layout">
                    <div class="panel-heading">
                        <?= wpn_lang('tab_layout'); ?>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4><?= wpn_lang('field_logomarca'); ?></h4>
                                    <hr/>
                                    <div class="form-group">
                                        <?php
                                        if ($row->logomarca) {
                                            echo img(array('src' => 'media/' . $row->logomarca, 'class' => 'img-responsive img-thumbnail', 'style' => 'margin-top:5px;'));
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".modal-logomarca"><?= wpn_lang('bot_change'); ?></button>
                                    </div>
                                    <h4><?= wpn_lang('field_favicon'); ?></h4>
                                    <hr/>
                                    <div class="form-group">
                                        <?php echo img(array('src' => 'media/favicon.ico', 'class' => 'img-responsive img-thumbnail', 'style' => 'margin-top:5px;')); ?>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".modal-favicon"><?= wpn_lang('bot_change'); ?></button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4><?= wpn_lang('field_background'); ?></h4>
                                    <hr/>
                                    <div class="form-group">
                                        <?php
                                        if ($row->background) {
                                            echo img(array('src' => 'media/' . $row->background, 'class' => 'img-responsive img-thumbnail', 'style' => 'margin-top:5px;'));
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".modal-background"><?= wpn_lang('bot_change'); ?></button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4><?= wpn_lang('field_bgcolor'); ?></h4>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-md-12" style="height: 50px; background-color: <?= $row->bgcolor ?>;"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <input type="text" name="bgcolor" id="bgcolor" value="<?= $row->bgcolor ?>" class="form-control select_color" placeholder="<?= wpn_lang('place_bgcolor'); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Painel de configuração imagens-->
                <div class="tab-pane  panel panel-default" id="imagens">
                    <div class="panel-heading">
                        <?= wpn_lang('tab_images'); ?>
                    </div>
                    <div class="panel-body">
                        <p><?= wpn_lang('tab_images_description'); ?></p>
                        <hr/>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="resize_image" value="1" <?= $resize_checked; ?> class="checkbox" />
                                <?= wpn_lang('field_resize_image'); ?>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="maintain_ratio" value="1" <?= $ratio_checked; ?> class="checkbox" />
                                <?= wpn_lang('field_maintain_ratio'); ?>
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="image_width"><?= wpn_lang('field_image_width'); ?></label>
                                    <input type="text" name="image_width" id="image_width" value="<?= $row->image_width ?>" class="form-control" placeholder="<?= wpn_lang('place_images'); ?>" />
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="image_height"><?= wpn_lang('field_image_height'); ?></label>
                                    <input type="text" name="image_height" id="image_height" value="<?= $row->image_height ?>" class="form-control" placeholder="<?= wpn_lang('place_images'); ?>" />
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="quality"><?= wpn_lang('field_quality'); ?></label>
                                    <input type="text" name="quality" id="quality" value="<?= $row->quality ?>" class="form-control" placeholder="<?= wpn_lang('place_images'); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <p><i><?= wpn_lang('tab_images_message'); ?></i></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Painel de exibição de mídia-->
                <div class="tab-pane panel panel-default" id="media">
                    <div class="panel-heading">
                        <?= wpn_lang('tab_media'); ?>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="home_category"><?= wpn_lang('field_media_show_photo'); ?></label>
                                <?= form_dropdown('media_show_photo', array('normal'=>'Abrir em outra janela', 'fancybox'=>'Exibir com FancyBox'), $row->media_show_photo, array('class' => 'form-control')); ?>
                            </div>
                            <div class="form-group">
                                <label for="home_category"><?= wpn_lang('field_media_show_video'); ?></label>
                                <?= form_dropdown('media_show_video', array('normal'=>'Abrir em outra janela', 'fancybox'=>'Exibir com FancyBox'), $row->media_show_video, array('class' => 'form-control')); ?>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!--Painel de configurações de contato-->
                <div class="tab-pane panel panel-default" id="contato">
                    <div class="panel-heading">
                        <?= wpn_lang('tab_contact'); ?>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="site_contato"><?= wpn_lang('field_site_contato'); ?></label>
                                <input type="text" name="site_contato" id="site_contato" value="<?= $row->site_contato ?>" class="form-control" placeholder="<?= wpn_lang('place_site_contato'); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="site_telefone"><?= wpn_lang('field_site_telefone'); ?></label>
                                <input type="text" name="site_telefone" id="site_telefone" value="<?= $row->site_telefone ?>" class="form-control" placeholder="<?= wpn_lang('place_site_telefone'); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="texto_contato"><?= wpn_lang('field_text_contato'); ?></label>
                                <textarea name="texto_contato" id="editor" class="form-control ckeditor"><?= $row->texto_contato; ?></textarea>
                            </div>
                            <h4 style="margin-top:20px;"><?= wpn_lang('smtp_configurations'); ?></h4>
                            <hr/>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="usa_smtp" value="1" <?= $smtp_checked; ?> class="checkbox" />
                                    <?= wpn_lang('field_use_smtp'); ?>
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="smtp_servidor"><?= wpn_lang('field_smtp_server'); ?></label>
                                        <input type="text" name="smtp_servidor" id="smtp_servidor" value="<?= $row->smtp_servidor ?>" class="form-control" placeholder="<?= wpn_lang('place_smtp_server'); ?>" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="smtp_porta"><?= wpn_lang('field_smtp_port'); ?></label>
                                        <input type="text" name="smtp_porta" id="smtp_porta" value="<?= $row->smtp_porta ?>" class="form-control" placeholder="<?= wpn_lang('place_smtp_port'); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="smtp_usuario"><?= wpn_lang('field_smtp_user'); ?></label>
                                        <input type="text" name="smtp_usuario" id="smtp_usuario" value="<?= $row->smtp_usuario ?>" class="form-control" placeholder="<?= wpn_lang('place_smtp_user'); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="smtp_senha"><?= wpn_lang('field_smtp_password'); ?></label>
                                        <input type="text" name="smtp_senha" id="smtp_senha" value="<?= $row->smtp_senha ?>" class="form-control" placeholder="<?= wpn_lang('place_smtp_password'); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="smtp_crypto"><?= wpn_lang('field_use_ssl'); ?></label>
                                        <select class="form-control" name="smtp_crypto">
                                            <option value="0" <?= ($row->smtp_crypto == '0' ? 'selected="selected"' : ''); ?>>None</option>
                                            <option value="ssl" <?= ($row->smtp_crypto == 'ssl' ? 'selected="selected"' : ''); ?>>SSL</option>
                                            <option value="tls" <?= ($row->smtp_crypto == 'tls' ? 'selected="selected"' : ''); ?>>TLS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Painel de configuração social-->
                <div class="tab-pane panel panel-default" id="social">
                    <div class="panel-heading">
                        <?= wpn_lang('tab_socialmedia'); ?>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="google_analytics"><?= wpn_lang('field_google_analytics'); ?></label>
                                <input type="text" name="google_analytics" id="google_analytics" value="<?= $row->google_analytics ?>" class="form-control" placeholder="<?= wpn_lang('place_google_analytics'); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="addthis_uid"><?= wpn_lang('field_addthis_uid'); ?></label>
                                <input type="text" name="addthis_uid" id="addthis_uid" value="<?= $row->addthis_uid ?>" class="form-control" placeholder="<?= wpn_lang('place_addthis_uid'); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="link_instagram"><?= wpn_lang('field_link_instagram'); ?></label>
                                <input type="text" name="link_instagram" id="link_instagram" value="<?= $row->link_instagram ?>" class="form-control" placeholder="<?= wpn_lang('place_instagram'); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="link_twitter"><?= wpn_lang('field_link_twitter'); ?></label>
                                <input type="text" name="link_twitter" id="link_twitter" value="<?= $row->link_twitter ?>" class="form-control" placeholder="<?= wpn_lang('place_twitter'); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="link_facebook"><?= wpn_lang('field_link_facebook'); ?></label>
                                <input type="text" name="link_facebook" id="link_facebook" value="<?= $row->link_facebook ?>" class="form-control" placeholder="<?= wpn_lang('place_facebook'); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="link_likebox"><?= wpn_lang('field_link_likebox'); ?></label>
                                <input type="text" name="link_likebox" id="link_likebox" value="<?= $row->link_likebox ?>" class="form-control" placeholder="<?= wpn_lang('place_likebox'); ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-confirma-modal-sm"><span class="glyphicon glyphicon-floppy-disk"></span> <?= wpn_lang('bot_save'); ?></button>
            </div>
            <div class="modal fade bs-confirma-modal-sm" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header"><b><?= wpn_lang('confirmation_title'); ?></b></div>
                        <div class="modal-body">
                            <p><?= wpn_lang('confirmation_message'); ?></p>
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span><?= wpn_lang('bot_confirm_ok'); ?></button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><?= wpn_lang('bot_confirm_cancel'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>

<?= form_open_multipart('admin/configuracoes/altlogo'); ?>
<div class="modal fade modal-logomarca" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel"><?= wpn_lang('modal_title_logomarca'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="logomarca"><?= wpn_lang('modal_select_image'); ?></label>
                    <input type="file" name="logomarca" id="logomarca" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?= wpn_lang('wpn_bot_cancel'); ?></button>
                <button type="submit" class="btn btn-success"><?= wpn_lang('wpn_bot_save'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>

<?= form_open_multipart('admin/configuracoes/altfavicon'); ?>
<div class="modal fade modal-favicon" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel"><?= wpn_lang('modal_title_favicon'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="favicon"><?= wpn_lang('modal_select_image'); ?></label>
                    <input type="file" name="favicon" id="favicon" class="form-control" />
                    <em><?= wpn_lang('modal_favicon_instruction'); ?></em>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?= wpn_lang('wpn_bot_cancel'); ?></button>
                <button type="submit" class="btn btn-success"><?= wpn_lang('wpn_bot_save'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>

<?= form_open_multipart('admin/configuracoes/altback'); ?>
<div class="modal fade modal-background" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel"><?= wpn_lang('modal_title_background'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="background"><?= wpn_lang('modal_select_image'); ?></label>
                    <input type="file" name="background" id="background" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?= wpn_lang('wpn_bot_cancel'); ?></button>
                <button type="submit" class="btn btn-success"><?= wpn_lang('wpn_bot_save'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>