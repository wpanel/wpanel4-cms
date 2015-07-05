	      <!-- </section> -->
	    </div>
	    <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Versão</b> 2.0 | Página renderizada em <strong>{elapsed_time}</strong> segundos.
        </div>
        <strong>Copyright &copy; 2006-<?= date('Y') ?> <a href="http://elieldepaula.com.br">Eliel de Paula</a>.</strong>
      </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?= base_url('lib/plugins') ?>/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?= base_url('lib/js') ?>/bootstrap.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="<?= base_url('lib/plugins') ?>/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?= base_url('lib/plugins') ?>/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="<?= base_url('lib/plugins') ?>/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?= base_url('lib/plugins') ?>/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('lib/js') ?>/app.min.js" type="text/javascript"></script>
    
    <!-- <script src="<?= base_url('lib/js') ?>/wpanel.js"></script> -->

    <script type="text/javascript">
      $(function () {
        $("#grid").dataTable({
            language: {
                search: "Pesquisar na tabela: ",
                lengthMenu: "Mostrar  _MENU_  registros por vez.",
                info: "Exibindo registros de _START_ a _END_ de _TOTAL_ registros.",
                paginate: {
                    first:      "Primeiro",
                    previous:   "Anterior",
                    next:       "Próximo",
                    last:       "Último"
                },
                loadingRecords: "Carregando ...",
                zeroRecords:    "Nenhum registro foi encontrado."
            }
        });
      });
    </script>

  </body>
</html>