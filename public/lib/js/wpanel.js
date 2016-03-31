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
         * Esta função aplica o plugin dataTable nas listagens do WPanel.
         */
        $(function(){

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