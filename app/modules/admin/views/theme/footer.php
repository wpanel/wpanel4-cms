
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                <?php echo wpn_lang('wpn_pagerendered', 'Page rendered in'); ?> <strong>{elapsed_time}</strong> <?php echo wpn_lang('wpn_seconds', 'Seconds'); ?>. Versão <?php echo WPN_VERSION; ?>
                </div>
                <p>&copy; Wpanel-PRO <?php echo date('Y') ?>, todos os direitos reservados a <a href="http://dotsistemas.com.br" target="_blank">Dot Sistemas</a>.</p>
            </footer>
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
