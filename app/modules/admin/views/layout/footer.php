	      <!-- </section> -->
	    </div>
	    <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Versão</b> 1.2.4 | Página renderizada em <strong>{elapsed_time}</strong> segundos.
        </div>
        <strong>Copyright &copy; <?= date('Y') ?> <a href="http://elieldepaula.com.br" target="_blank">Eliel de Paula</a>.</strong>
      </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?= base_url('lib/plugins') ?>/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?= base_url('lib/js') ?>/bootstrap.min.js" type="text/javascript"></script>
    <!-- BootBox -->
    <script src="<?= base_url('lib/plugins') ?>/bootbox/bootbox.min.js"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="<?= base_url('lib/plugins') ?>/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?= base_url('lib/plugins') ?>/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="<?= base_url('lib/plugins') ?>/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?= base_url('lib/plugins') ?>/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('lib/js') ?>/app.min.js" type="text/javascript"></script>
    <!-- WPanel JS -->
    <script src="<?= base_url('lib/js') ?>/wpanel.js"></script>
    <script>
    var roxyFileman = '<?= base_url(); ?>fileman/index.html';
    CKEDITOR.replace( 'editor', {
        filebrowserBrowseUrl:roxyFileman,
        filebrowserImageBrowseUrl:roxyFileman+'?type=image',
        removeDialogTabs: 'link:upload;image:upload'
    });
    </script>
  </body>
</html>