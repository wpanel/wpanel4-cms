
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                <?php echo wpn_lang('wpn_pagerendered'); ?> <strong>{elapsed_time}</strong> <?php echo wpn_lang('wpn_seconds'); ?>. <?= wpn_lang('wpn_version'); ?> <?php echo WPN_VERSION; ?>
                </div>
                <p>&copy; <?php echo date('Y') ?> <a href="http://wpanel.org" target="_blank">Wpanel CMS</a>. <?= wpn_lang('wpn_copyright'); ?>.</p>
            </footer>
        </div>

        <div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="dataConfirmLabel"><?= wpn_lang('wpn_confirmbox_title'); ?></h4>
                    </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><?= wpn_lang('wpn_confirmbox_cancel'); ?></button>
                    <a class="btn btn-success" id="dataConfirmOK"><?= wpn_lang('wpn_confirmbox_ok'); ?></a>
                </div>
            </div>
        </div>

        <script>
        var roxyFileman = '<?php echo base_url("fileman/index.html"); ?>';
        CKEDITOR.replace( 'editor', {
            filebrowserBrowseUrl:roxyFileman,
            filebrowserImageBrowseUrl:roxyFileman+'?type=image',
            removeDialogTabs: 'link:upload;image:upload'
        });
        </script>
    </body>
</html>
