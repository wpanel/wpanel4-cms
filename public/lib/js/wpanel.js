/**
         * Esta função exibe as mensagens do WPanel.
         */
        function sysmsg(mensagem){
            bootbox.alert({
                title: "WPanel",
                size: "small",
                className: "modal-default",
                message: mensagem
            });
        }

        /**
         * Esta função faz a confirmação de exclusão no WPanel.
         * 
         * @deprecated
         */
        function confirmar(link){
            bootbox.dialog({
                show: true,
                size: 'small',
                title: "Confirmação",
                message: "Esta opção não poderá ser desfeita, tem certeza que deseja prosseguir?", 
                locale: "br",
                buttons: {
                    "Cancelar": {
                        className: "btn-danger"
                    },
                    "Confirmo!": {
                        className: "btn-success",
                        callback: function(){
                            document.location = link;
                        }
                    }
                }
            });
        }

        /**
         * Funções que utilizam o JQuery.
         */
        $(function(){

            // Janela de confirmação.
            $('a[data-confirm]').click(function(ev) {
                var href = $(this).attr('href');
                if (!$('#dataConfirmModal').length) {
                    $('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-dialog modal-md" role="document"><div class="modal-content"><div class="modal-header"><h4 id="dataConfirmLabel">Confirme por favor</h4></div><div class="modal-body"></div><div class="modal-footer"><button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancelar</button><a class="btn btn-success" id="dataConfirmOK">Confirmar</a></div></div></div></div>');
                } 
                $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
                $('#dataConfirmOK').attr('href', href);
                $('#dataConfirmModal').modal({show:true});
                return false;
            });

            // DataTable.
            $("#grid").dataTable({
                "bPaginate": false,
                //"paging": false,
                "bInfo": false,
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

            $('.select_color').colorpicker();

            /* -------------------------------------------------------------------------
             * Este bloco faz o funcionamento do formulário de cadastro 
             * de itens de menu. 
             * ---------------------------------------------------------------------- */
            $("#tipo_link").click(function () {
                $("#form_link").show();
                $("#form_post").hide();
                $("#form_posts").hide();
                $("#form_funcional").hide();
                
            });
            $("#tipo_post").click(function () {
                $("#form_link").hide();
                $("#form_post").show();
                $("#form_posts").hide();
                $("#form_funcional").hide();
                $("#form_submenu").hide();
            });
            $("#tipo_posts").click(function () {
                $("#form_link").hide();
                $("#form_post").hide();
                $("#form_posts").show();
                $("#form_funcional").hide();
                $("#form_submenu").hide();
            });
            $("#tipo_funcional").click(function () {
                $("#form_link").hide();
                $("#form_post").hide();
                $("#form_posts").hide();
                $("#form_funcional").show();
                $("#form_submenu").hide();
            });
            $("#tipo_submenu").click(function () {
                $("#form_link").hide();
                $("#form_post").hide();
                $("#form_posts").hide();
                $("#form_funcional").hide();
                $("#form_submenu").show();
            });
            
        });