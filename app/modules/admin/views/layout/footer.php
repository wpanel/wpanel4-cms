
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                <?= wpn_lang('wpn_pagerendered', 'Page rendered in'); ?> <strong>{elapsed_time}</strong> <?= wpn_lang('wpn_seconds', 'Seconds'); ?>.
                </div>
                <p>&copy; Wpanel CMS <?= date('Y') ?>, <a href="http://wpanel.org/licenca.html" target="_blank"><?= wpn_lang('wpn_licence', 'Terms and licence'); ?></a>. <?= wpn_lang('wpn_developed', 'Developed by'); ?> <a href="http://elieldepaula.com.br" target="_blank">Eliel de Paula</a>.</p>
            </footer>
        </div>
        <script>
        var roxyFileman = '<?= base_url("fileman/index.html"); ?>';
        CKEDITOR.replace( 'editor', {
            filebrowserBrowseUrl:roxyFileman,
            filebrowserImageBrowseUrl:roxyFileman+'?type=image',
            removeDialogTabs: 'link:upload;image:upload'
        });
        </script>
    </body>
</html>